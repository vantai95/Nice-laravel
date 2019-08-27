<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemCustomization;
use App\Models\OrderTransaction;
use App\Models\UserCustomerInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Restaurant;

class UserController extends Controller
{
    public function index()
    {
        $lang = Session::get('locale');
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            return redirect('/');
        }

        $alterProfiles = UserCustomerInfo::where('user_id', $user->id)->get();

        $userField = collect(array_keys($user->only(['id', 'full_name', 'email', 'address', 'phone', 'birth_day'])));
        $alterProfileField = collect(array_keys($user->only(['id', 'user_id', 'email', 'address', 'phone'])));

        return view('user.info.info_layout', compact('user', 'userField', 'lang', 'alterProfiles', 'alterProfileField'));
    }

    public function updateProfile(Request $request, $id)
    {
        $requestData = $request->all();

        $user = User::findOrFail($id);

        $user->full_name = $request->post('full_name');
        $user->birth_day = $request->post('birth_day');
        $user->phone = $request->post('phone');
        $user->address = $request->post('address');

        $user->update($requestData);

        return response()->json(['profile' => $user]);
    }

    // Alter profile
    public function addAlterProfile(Request $request)
    {
        $requestData = $request->all();

        $requestData['email'] = $request->post('email');
        $requestData['phone'] = $request->post('phone');
        $requestData['address'] = $request->post('address');
        $requestData['user_id'] = Auth::user()->id;

        $alterProfile = UserCustomerInfo::create($requestData);

        return response()->json(['alter_profile' => $alterProfile]);
    }

    public function updateAlterProfile(Request $request, $id)
    {
        $requestData = $request->all();

        $alterProfile = UserCustomerInfo::findOrFail($id);

        $alterProfile->email = $request->post('email');
        $alterProfile->phone = $request->post('phone');
        $alterProfile->address = $request->post('address');

        $alterProfile->update($requestData);

        return response()->json(['alter_profile' => $alterProfile]);
    }

    public function deleteAlterProfile($id)
    {
        $alterProfile = UserCustomerInfo::findOrFail($id);
        $alterProfile->delete();

        return response()->json(['alter_profile' => $alterProfile]);
    }

    // order history
    public function orderHistoryIndex()
    {
        $lang = Session::get('locale');
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            return redirect('/login');
        }

        $ordersHistory = Order::join('restaurants', 'restaurants.id', 'orders.restaurant_id')
            ->join('order_delivery_info', 'order_delivery_info.order_id', '=', 'orders.id')
            ->leftJoin('restaurant_delivery_settings', function ($join) {
                $join->on('restaurant_delivery_settings.restaurant_id', '=', 'orders.restaurant_id')
                    ->on('restaurant_delivery_settings.district_id', '=', 'order_delivery_info.district_id');
            })
            ->leftJoin('districts','districts.id','=','restaurant_delivery_settings.district_id')
            ->select('orders.id', 'orders.order_number','orders.total_amount','orders.sub_total_amount','orders.discount',
                'orders.tax','orders.shipping_fee','orders.payment_method','orders.order_type',
                'orders.status','orders.notes','orders.tax_type','orders.tax_rate','orders.take_red_invoice','orders.created_at',
                "restaurants.name_$lang as restaurant_name",'order_delivery_info.district_id',"districts.slug as district_slug","restaurants.id as restaurant_id",
                'order_delivery_info.ward_id','restaurant_delivery_settings.delivery_cost',
                'restaurant_delivery_settings.min_order_amount as minOrderAmount','restaurants.slug as restaurant_slug',
                'restaurants.online_payment','restaurants.cod_payment','restaurants.delivery','restaurants.pickup'
            )
            ->where('orders.user_id',$user->id)->with(['order_items' => function($query) use ($lang){
                return $query->select('order_items.id',"dishes.name_$lang as name",'order_items.dish_id','order_items.price',
                'order_items.quantity','order_items.order_id','order_items.free_item')->leftJoin('dishes','dishes.id','=','order_items.dish_id');
            },'order_items.order_items_customizations' => function($query) use ($lang){
                return $query->select(
                    "order_items_customizations.customization_id","customizations.name_$lang as custom_name",
                    "order_items_customizations.customization_option_id","customization_options.name_$lang as option_name",
                    "order_items_customizations.price","order_items_customizations.order_item_id","order_items_customizations.order_id",
                    "order_items_customizations.quantity"
                )->leftJoin('customizations','customizations.id','=','order_items_customizations.customization_id')
                ->leftJoin('customization_options','customization_options.id','=','order_items_customizations.customization_option_id');
            }]);
        $listOrdersTransPayed = OrderTransaction::select('order_transactions.order_id')
            ->where('order_transactions.status','<>',0)->groupBy('order_transactions.order_id')->get()->toArray();

        $listOrdersTransNew = OrderTransaction::select('order_transactions.order_id')
            ->whereNotIn('order_transactions.order_id',$listOrdersTransPayed)->get()->toArray();

        if (!empty($listOrdersTransNew)) {
            $ordersHistory = $ordersHistory->whereNotIn('orders.id', $listOrdersTransNew)->get()->keyBy('id');
        } else {
            $ordersHistory = $ordersHistory->get()->keyBy('id');
        }

        $order_status = collect(Order::STATUS_FILTER);
        $services = collect(Restaurant::SERVICES_FILTER);
        $payments = collect(Restaurant::PAYMENTS_FILTER);

        return view('user.order_histories.order_history_layout', compact('user', 'ordersHistory', 
        'services', 'payments','order_status'));
    }

}
