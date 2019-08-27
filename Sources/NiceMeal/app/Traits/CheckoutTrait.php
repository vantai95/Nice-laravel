<?php
namespace App\Traits;
use App\Models\OrderLog;
use App\Models\Order;
use App\Models\OrderCustomerInfo;
use App\Models\OrderDeliveryInfo;
use App\Models\OrderItemCustomization;
use App\Models\OrderItem;
use App\Mail\CheckoutToMail;
use App\Mail\NewOrderMail;
use App\Mail\SendMailable;
use App\Models\Restaurant;
use App\Models\UserCustomerInfo;
use App\Services\CommonService;
use Session, Log, Exception, Auth, DB;
use App\Models\User;
use App\Mail\ActiveAccountMail;

trait CheckoutTrait{

    public function createOrder($cart,$data,$user_id,$otp_verify = false,$otp = ""){

        $time = time();
        $order_data = [
            'shipping_fee'=>$cart['delivery_fee'],
            'sub_total_amount'=> round($cart['sub_total']),
            'total_amount'=>$cart['order_total'],
            'payment_method' => $cart['payment'],
            'notes' => isset($cart['order_note'])? $cart['order_note'] : "",
            'order_type'=> $cart['service'],
            'direction' => isset($data['direction']) ? $data['direction'] : "",
            'status'=>0,
            'delivery_time'=> ($data['delivery_time'] == 'asap') ? null : date('Y-m-d H:i:s',strtotime($data['specific_time'])),
            'amount_user_have'=> isset($data['payment_amount']) ? $data['payment_amount'] : 0,
            'otp_expired_at'=> date('Y-m-d H:i:s', $time + (env('TIME_SHOW_POPUP')/1000) ),
            'created_at'=>date('Y-m-d H:i:s',$time),
            'restaurant_id'=>$cart['restaurant_id'],
            'user_id' => $user_id,
            'tax_type' => is_int($cart['tax_type']) ? ($cart['tax_type'] == 1 ? 'exclusive' : 'inclusive') : '',
            'tax_rate' => $cart['tax'] != "" ? $cart['tax'] : 0,
            'take_red_invoice' => $cart['checkbill'],
            'token_expired' => date('Y-m-d H:i:s', $time + (env('TOKEN_EXPIRED_TIME')/1000)),
            'tax' => round($cart['tax_bill'])
        ];
        $otp_created_at = null;
        if($otp_verify){
            $order_data['otp'] = Order::OTP_PREFIX.$otp;
            $otp_created_at = date('Y-m-d H:i:s',$time);
        }
        $order_data['discount'] = $this->calPromotion($cart);
        $order_id = Order::create($order_data)->id;
        $token = md5(date('Y-m-d H:i:s',$time).'NM'.$order_id);
        DB::update("UPDATE orders SET orders.order_number = 'NM$order_id',orders.token = '$token' WHERE orders.id = $order_id");
        $order_customer_info_data = [
            'restaurant_id' => $cart['restaurant_id'],
            'order_id' => $order_id,
            'user_id' => $user_id,
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ];
        OrderCustomerInfo::create($order_customer_info_data);

        $order_delivery_info_data = [
            'restaurant_id' => $cart['restaurant_id'],
            'order_id' => $order_id,
            'user_id' => $user_id,
            'province_id' => 1,
            'residencetype' => (isset($data['residencetype']['value'])) ?  $data['residencetype']['value'] :"",
            'full_address' => (isset($data['address']['full_address'])) ?  $data['address']['full_address'] : "",
            'district_id' => (isset($data['district'])) ?  $data['district'] :"",
            'ward_id' => (isset($data['ward'])) ?  $data['ward'] : ""
        ];

        OrderDeliveryInfo::create($order_delivery_info_data);

        $order_items_customizations_data = [];

        foreach($cart['items'] as $key => $value){
            $have_customization = 0;
            $order_items_data = [
                'restaurant_id' =>  $cart['restaurant_id'],
                'order_id' => $order_id,
                'dish_id' => $value['id'],
                'price' => $value['price'],
                'quantity'=> $value['quantity'],
                'have_customization' => count($value['options']),
                'free_item' => $value['free_item']
            ];
            $order_item_id = OrderItem::create($order_items_data)->id;
            foreach($value['options'] as $option){
                $order_items_customizations_row = [
                    'restaurant_id' => $cart['restaurant_id'],
                    'order_id' => $order_id,
                    'order_item_id' => $order_item_id,
                    'customization_id' => $option['custom_id'],
                    'customization_option_id' => $option['option_id'],
                    'price' => $option['price'],
                    'customization_price' => 0,
                    'quantity' => $option['quantity']
                ];
                array_push($order_items_customizations_data,$order_items_customizations_row);
            }
        } 
        OrderItemCustomization::insert($order_items_customizations_data);

        return [$token,$order_id,$otp_created_at];
    }

    public function userCheck($data,$restaurant){
        if($data['register']){
            $checkUser = User::where('email','=',$data['email'])->first();
            if(!$checkUser){
                $currentTime = time();
                $accountToken = md5(date('Y-m-d H:i:s',$currentTime).$data['email']);
                $user_id = User::create([
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'address'=> (isset($data['address']['full_address'])) ?  $data['address']['full_address'] : "",
                    'password' => bcrypt($data['password']['password']),
                    'phone' => $data['phone'],
                    'gender' => $data['title'],
                    'account_token' => $accountToken
                ])->id;
                $userInfo = User::where('id',$user_id)->first();
                
                $isTakeawayDomain = CommonService::isTakeawayDomain();
                \Mail::to($data['email'])->send(new ActiveAccountMail($userInfo,$restaurant,$accountToken,$isTakeawayDomain));
            }else{
                $user_id = $checkUser->id;
            }
        }else{
            $user_id = Auth::user()->id;
        }
        
        $info_count = UserCustomerInfo::where('user_id','=',$user_id)->where('email','=',$data['email'])->where('phone','=',$data['phone'])->count();
        if($info_count == 0){
            UserCustomerInfo::create([
                'user_id' => $user_id,
                'email' => $data['email'],
                'phone' => $data['phone'],
                'gender' => $data['title'],
                'address'=> (isset($data['address']['full_address'])) ?  $data['address']['full_address'] : "",                    
            ]);
        }
        return [$user_id];
    }

    public function otpVerifyOrNot($user_id,$restaurant,$cart){
        $otp_verify = false;
        $countOrder = DB::select("SELECT
            count(orders.id) total_orders
            FROM orders 
            WHERE user_id = $user_id AND restaurant_id = $restaurant->id
        ")[0]->total_orders;
            
        if($restaurant->otp != null && $restaurant->otp_value != null){
            $otp_verify = ($countOrder < $restaurant->otp || $cart['sub_total'] > $restaurant->otp_value) ? 1 : 0;
        }
        return [$otp_verify];
    }

    public function sendCheckoutEmail($otp_verify,$user_data,$otp,$restaurant,$token,$order_id){
        try{
            if($otp_verify){
                \Mail::to($user_data['email'])->send(new CheckoutToMail($user_data,$otp,$restaurant));
                CommonService::sendSMS($user_data['phone'],'Hello sir/madam, NM-'.$otp.' is your OTP number for confirmation.');
                Log::error('send otp success');
            }
            //send email to admin of restaurant
            $sendToAdmin = true;
//                $confirmLink = url('/admin/'.$restaurant['slug'].'/orders/'.$order_id);
            $link = [
                'confirm'=>url('/confirm-order/'.$token),
                'reject'=>url('/reject-order/'.$token),
            ];
//                $confirmLink = url('confirm-test');
             \Mail::to($restaurant->email)->send(new NewOrderMail($user_data,$restaurant,$order_id,$sendToAdmin,$link));

            
        }catch(\Exception $exception){
            \Illuminate\Support\Facades\Log::error($exception->getMessage());
        }
    }

    public function doResendOtp($order_id){
        $otp = CommonService::generateOTP();
        $order = Order::find($order_id);
        $order_customer_info = OrderCustomerInfo::where('order_id','=',$order_id)->first();
        
        if($order->otp_resend_times == env('OTP_RESEND_LIMIT')){
            return response()->json([
                'success' => false,
                'error'=> true,
                'message' => 'Cannot resend OTP for this order because out of limit times'
            ]);
        }else{
            $order->otp = Order::OTP_PREFIX.$otp;
            $order->otp_expired_at = date('Y-m-d H:i:s', time() + (env('TIME_SHOW_POPUP')/1000) );
            $order->otp_resend_times = $order->otp_resend_times + 1;
            $order->save();

            \Mail::to($order_customer_info->email)->send(new SendMailable([
                'email' => env('MAIL_FROM_ADDRESS'),
                'name' => env('MAIL_FROM_NAME'),
                'subject' => 'Order',
                'message' => "Your new OTP is: ".$otp,
                'view_path' => 'emails.order'
            ]));
            $otp_created_at = date('Y-m-d H:i:s');
            $send_left = env('OTP_RESEND_LIMIT') - $order->otp_resend_times;
            return response()->json([
                'success' => true,
                'error'=> false,
                'send_left' => $send_left,
                'message' => 'Resend OTP successfully please check in your mail box',
                'otp_created_at' => $otp_created_at
            ]);
        }
    }
}