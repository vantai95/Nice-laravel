<?php

namespace App\Http\Controllers\User;

use App, Lang, Session, Log, Exception, Auth, DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\District;
use App\Models\Ward;
use App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Customization;
use App\Models\DishCustomization;
use App\Models\CustomizationOption;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderCustomerInfo;
use App\Models\OrderDeliveryInfo;
use App\Models\OrderItem;
use App\Models\UserCustomerInfo;
use App\Models\OrderItemCustomization;
use App\Models\Promotion;
use App\Models\PromotionUsage;
use App\Models\Setting;
use App\Models\RestaurantDeliverySetting;

use App\Services\CommonService;
use App\Services\CartService;
use App\Services\RestaurantService;
use App\Services\TBDService;
use App\Services\TBPService;
use App\Services\CheckoutService;
use App\Services\Restaurant\RestaurantBuilderService;

use App\Mail\CheckoutToMail;
use App\Mail\NewOrderMail;
use App\Mail\SendMailable;
use App\Mail\ActiveAccountMail;

use Carbon\Carbon;


class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $cart = Session::get('cart');
        $cookieService = $cart['service'];
        $isCheckoutPage = true;

        $lang = Session::get('locale');
        $slug = $cart['restaurant'];
        $district = $request->input('district');
        $wardInput = $request->input('ward');

        $onlinePayments = Setting::join('restaurants', 'restaurants.id', 'settings.restaurant_id')
            ->join('restaurant_delivery_settings', 'restaurant_delivery_settings.restaurant_id', '=', 'restaurants.id')
            ->join('districts', 'districts.id', '=', 'restaurant_delivery_settings.district_id')
            ->where('restaurants.active', 1)
            ->where('restaurants.slug', '=', $slug)
            ->where('districts.slug', $district)
            ->select('settings.*')->get();

        if (!$onlinePayments->isEmpty()) {
            if ($onlinePayments[0]['value'] == 1 && $onlinePayments[1]['value'] == 0) {
                $onlinePayment = 'paypal';
            } elseif ($onlinePayments[0]['value'] == 0 && $onlinePayments[1]['value'] == 1) {
                $onlinePayment = 'ngan_luong';
            } elseif ($onlinePayments[0]['value'] == 1 && $onlinePayments[1]['value'] == 1) {
                $onlinePayment = 'paypal_and_ngan_luong';
            } else {
                $onlinePayment = 'no_setting';
            }
        } else {
            $onlinePayment = 'no_setting';
        }

        if (count($cart['items']) == 0) {
            Session::flash('flash_error', "Session timeout click OrderNow again to checkout");
            return redirect("/");
        }

        $promotionChange = CartService::isCartPromotionsChange($cart);
        if ($promotionChange == true) {
            Session::flash('flash_error', "Promotion changed! Please retry");
            return redirect("/restaurants/$slug?district=$district");
        }

        $restaurant = Restaurant::leftJoin('taxes', 'taxes.restaurant_id', 'restaurants.id')
            ->join('restaurant_delivery_settings', 'restaurant_delivery_settings.restaurant_id', '=', 'restaurants.id')
            ->join('districts', 'districts.id', '=', 'restaurant_delivery_settings.district_id')
            ->where('restaurants.active', 1)
            ->where('restaurants.slug', '=', $slug)
            ->where('districts.slug', $district);
        if (empty($wardInput)) {
            $restaurant = $restaurant->whereNull('restaurant_delivery_settings.ward_id');
        } else {
            $restaurant = $restaurant->where('restaurant_delivery_settings.ward_id', $wardInput);
        }

        $restaurant = $restaurant->select('restaurants.*', 'restaurants.id as res_id', 'taxes.type', 'taxes.rate',
            'restaurant_delivery_settings.min_order_amount as minOrderAmount',
            'restaurant_delivery_settings.delivery_cost as deliveryCost',
            "districts.name_$lang as districtName",
            'restaurant_delivery_settings.district_id',
            "restaurant_delivery_settings.ward_id as ward_delivery");

        $restaurant = RestaurantBuilderService::allDeliverySettingListBuilder($restaurant,$lang)->first();

        $title = collect([
            '1' => "Mr.",
            '0' => "Ms.",
        ]);

        $messagingApp = collect([
            'whatsapp' => 'WhatsApp',
            'viber' => 'Viber',
            'zalo' => 'Zalo',
            'fb' => 'FB Messenger',
            'wechat' => 'WeChat',
            'line' => 'Line',
            'other' => 'Other app...'
        ]);

        if ($restaurant->online_payment == 1 && $restaurant->cod_payment == 0) {
            $payment_type = 'online';
        } elseif ($restaurant->online_payment == 0 && $restaurant->cod_payment == 1) {
            $payment_type = 'cod';
        } elseif ($restaurant->cod_payment == 1 && $restaurant->online_payment == 1) {
            $payment_type = 'cod_and_online';
        } else {
            $payment_type = 'no_setting';
        }
        $cart['delivery_fee'] = ($cart['service'] == "delivery") ? CartService::calculateDeliveryFee($cart) : 0;

        // remove voucher from Cart if it expired
        if ($cart['voucher']) {
            $voucher = Promotion::where('id', $cart['voucher']['id'])->where('status', 1)->select('*',
                "name_$lang as name")->first();
            if (!$voucher || !$voucher->isAvailable()) {
                $cart['voucher'] = null;
            }

            if (!empty($voucher)) {
                $vouchers = json_decode(json_encode($voucher), true);
                $cart['voucher'] = $vouchers;
            }
        }

        Session::put('cart', $cart);

        if ($cart['restaurant'] == "" || count($cart['items']) == 0 || $cart['sub_total'] < $restaurant->minOrderAmount) {
            return redirect('/');
        }

        $delivery_ward = Ward::where('district_id', $restaurant->district_id)
            ->select('wards.*', "wards.name_$lang as name", "wards.type_$lang as type")
            ->get()->groupBy('district_id');
        $countOrder = 0;
        $preorder = null;
        $alter_info = [];
        if (Auth::check()) {

            $user = Auth::user();
            $alter_infos = UserCustomerInfo::join('users', 'users.id', '=',
                'user_customer_infos.user_id')->where('users.id', '=', $user->id)
                ->select('user_customer_infos.*',
                    'users.gender',
                    'users.full_name')->get();
            if (count($alter_infos) == 0) {
                $alter_info = $user;
            } else {
                $alter_info = $alter_infos[0];
            }
            $preorder = Order::select('order_delivery_info.*')
                ->join('order_delivery_info', 'order_delivery_info.order_id', '=', 'orders.id')
                ->where('order_delivery_info.user_id', '=', $user->id)
                ->orderBy('id', 'desc')->first();

            $countOrder = DB::select("SELECT
                count(orders.id) total_orders
                FROM orders
                WHERE user_id = $user->id AND restaurant_id = $restaurant->id
            ")[0]->total_orders;
        }
        $residencetype = collect([
            'house' => "House",
            "hotel" => "Hotel",
            'building' => "Building",
            "compound" => "Compound",
        ]);

        $delivery_time = collect(Order::DELIVERY_TIME);

        // $orderServices = collect($restaurant->orderServices());
        // $orderPayments = collect($restaurant->orderPayments());

        $payment_amount = collect([
            '100000' => CommonService::formatPriceVND(100000),
            '200000' => CommonService::formatPriceVND(200000),
            '500000' => CommonService::formatPriceVND(500000),
            '1000000' => CommonService::formatPriceVND(1000000)
        ]);

        $orderServices = collect($restaurant->orderServices());
        $orderPayments = collect($restaurant->orderPayments());

        $districts = District::where('id', '=', $restaurant->district_id)->get();
        $wards = Ward::where('district_id', '=', $restaurant->district_id)->get();


        $exchange = Setting::join('setting_keys', 'settings.key', '=', 'setting_keys.name')
            ->where('setting_keys.name', 'exchange_rate')
            ->where('settings.restaurant_id', $restaurant->id)->first();
        $exchange_rate = config('constants.EXCHANGE_RATE');
        if (!empty($exchange)) {
            if ($exchange->value > 0) {
                $exchange_rate = $exchange->value;
            }
        }
        $showPayPal = false;
        $paypalSetting = Setting::join('setting_keys', 'settings.key', '=', 'setting_keys.name')
            ->where('setting_keys.name', 'paypal')
            ->where('settings.restaurant_id', $restaurant->id)->first();
        if (!empty($paypalSetting)) {
            if ($paypalSetting->value > 0) {
                $showPayPal = true;
            }
        }
        $showNganLuong = false;
        $nganluongSetting = Setting::join('setting_keys', 'settings.key', '=', 'setting_keys.name')
            ->where('setting_keys.name', 'nganluong')
            ->where('settings.restaurant_id', $restaurant->id)->first();
        if (!empty($nganluongSetting)) {
            if ($nganluongSetting->value > 0) {
                $showNganLuong = true;
            }
        }

        return view('newuser.views.checkout.show',
            compact('cookieService', 'isCheckoutPage', 'delivery_ward', 'preorder',
                'cart', 'orderServices', 'orderPayments', 'title', 'residencetype', 'districts', 'wards', 'restaurant', 'messagingApp',
                'payment_amount', 'countOrder', 'alter_info', 'delivery_time', 'exchange_rate', 'onlinePayment',
                'payment_type', 'showNganLuong', 'showPayPal'));

        return view('user.checkout.show', compact('delivery_ward', 'preorder',
            'cart', 'orderServices', 'orderPayments', 'title', 'residencetype', 'districts', 'wards', 'restaurant',
            'payment_amount', 'countOrder', 'alter_info', 'delivery_time', 'exchange_rate', 'onlinePayment',
            'payment_type', 'showNganLuong', 'showPayPal'));
    }

    public function finish(Request $request)
    {
//        dd($request->input());
        $data = $request->post('info');
        $cart = $request->post('cart');
        $slug = $cart['restaurant'];
        $district = $request->input('district');

        // check promotion
        $promotionChange = CartService::isCartPromotionsChange($cart);
        if ($promotionChange == true) {
            Session::flash('flash_error', "Promotion changed! Please retry");
            return response()->json(['promotions_changed' => true]);
        }

        // check voucher
        $voucher = Promotion::where('id', $cart['voucher']['id'])->first() ?? null;

        $restaurant = Restaurant::where('restaurants.slug', '=', $cart['restaurant'])->first();
        $order_id = 0;
        $otp_verify = 0;
        $otp_created_at = null;
        $otp_expired_at = null;

        DB::transaction(function () use ($data, $cart, $restaurant, &$order_id, &$otp_verify, &$otp_created_at, &$otp_expired_at) {
            $otp = CommonService::generateOTP();

            [$user_id] = CheckoutService::userCheck($data, $restaurant, Auth::user());

            [$otp_verify] = CheckoutService::otpVerifyOrNot($user_id, $restaurant, $cart);

            [$token, $order_id, $otp_created_at, $otp_expired_at] = CheckoutService::createOrder($cart, $data, $user_id, $otp_verify,
                $otp);

            $user_data = [
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'address' => (isset($data['address']['full_address'])) ? $data['address']['full_address'] : "",
                'phone' => $data['phone'],
                'gender' => $data['title']
            ];
            if ($cart['payment'] != Order::PAYMENT_METHOD['ONLINE_PAYMENT']) {
                CheckoutService::sendCheckoutEmail($otp_verify, $user_data, $otp, $restaurant, $token, $order_id);
            }

        });
        Session::forget('cart');
        return response()->json([
            'order_id' => $order_id,
            'send_left' => intval(env('OTP_RESEND_LIMIT')),
            'otp_verify' => $otp_verify,
            'otp_created_at' => $otp_created_at,
            'otp_expired_at' => $otp_expired_at
        ]);
    }

    function confirmotp(Request $request)
    {
        $order_id = $request->input('order_id');
        $otp = $request->input('otp');
        $order = Order::find($order_id);

        if (strtotime($order->otp_expired_at) < time()) {
            return response()->json([
                'error' => true,
                'message' => 'OTP expired'
            ]);
        } else {
            if (!$order->otp_verified) {
                if ($order->otp == $otp) {
                    $order->otp_verified = 1;
                    $order->save();
                    return response()->json(['error' => 0]);
                } else {
                    return response()->json([
                        'error' => true,
                        'message' => 'OTP is not correct'
                    ]);
                }
            }
        }
    }

    function resendOTP(Request $request)
    {
        $order_id = $request->input('order_id');
        return CheckoutService::doResendOtp($order_id);
    }

    public function activeAccount($account_token)
    {
        // decrypt -> email
        $userAccount = User::where('account_token', $account_token)->first();
        if (empty($userAccount)) {
            Session::flash('flash_error', 'Token is invalid, please click the correct link to get right token');
            return redirect('/');
        } else {
            if ($userAccount->email_verified) {
                Session::flash('flash_error', 'Your account is already active, no action required!');
                return redirect('/');
            }
        }
        $userAccount->update(['email_verified' => 1]);
        Session::flash('flash_message', 'Your account has been activated successfully!');
        return redirect('/');
    }

    public function checkVoucher(Request $request)
    {
        $cart = Session::get('cart');
        $lang = Session::get('locale');

        $voucherCode = $request->post('voucher_code');
        $voucher = Promotion::where(DB::raw('LOWER(promotion_code)'), strtolower($voucherCode))
                ->where('is_global', 1)->select('*', "name_$lang as name")->first() ?? null;

        if ($voucher) {
            $isVoucherValid = CartService::isVoucherValid($voucher, $cart, $lang);

            if ($isVoucherValid == true) {
                $cart['voucher'] = $voucher;
                $cart = CartService::updateCartInfo($cart);
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => 'voucher founded',
                    'cart' => $cart
                ]);
            }
        }

        $cart['voucher'] = null;
        $cart = CartService::updateCartInfo($cart);
        return response()->json([
            'success' => false,
            'status' => 404,
            'message' => 'voucher not found',
            'cart' => $cart
        ]);
    }

}

?>
