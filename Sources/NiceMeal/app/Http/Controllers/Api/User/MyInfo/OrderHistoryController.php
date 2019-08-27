<?php

namespace App\Http\Controllers\Api\User\MyInfo;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemCustomization;
use App\Models\UserCustomerInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tax;
use App\Models\Restaurant;
use App\Models\RestaurantDeliverySetting;
use App\Serives\CartService;


class OrderHistoryController extends Controller
{

    /**
     * @api {GET} /api/my-order-histories My Order Histories
     * @apiName My Order Histories
     * @apiVersion 1.0.0
     * @apiDescription My Order Histories
     * @apiGroup ORDER HISTORIES
     *
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     * @apiHeader {String} Authorization Access Token
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "order": [
     *               {
     *                   "id": 1,
     *                   "order_number": "NM1",
     *                   "total_amount": 2105020,
     *                   "sub_total_amount": 2086020,
     *                   "discount": null,
     *                   "tax": null,
     *                   "shipping_fee": 19000,
     *                   "payment_method": "cod_payment",
     *                   "order_type": "delivery",
     *                   "status": 3,
     *                   "notes": "",
     *                   "tax_type": null,
     *                   "tax_rate": 0,
     *                   "take_red_invoice": 0,
     *                   "restaurant_name": "Oh!MyMeal",
     *                   "district_id": 760,
     *                   "ward_id": 26740,
     *                   "delivery_cost": 19000,
     *                   "minOrderAmount": 990000,
     *                   "restaurant_slug": "oh-my-meal",
     *                   "online_payment": 0,
     *                   "cod_payment": 1,
     *                   "delivery": 1,
     *                   "pickup": 0,
     *                   "order_items": [
     *                       {
     *                           "id": 1,
     *                           "name": null,
     *                           "dish_id": 681,
     *                           "price": 499000,
     *                           "quantity": 4,
     *                           "order_id": 1,
     *                           "order_items_customizations": []
     *                       },
     *                       {
     *                           "id": 2,
     *                           "name": null,
     *                           "dish_id": 801,
     *                           "price": 45000,
     *                           "quantity": 1,
     *                           "order_id": 1,
     *                           "order_items_customizations": [
     *                               {
     *                                   "customization_id": 71,
     *                                   "custom_name": "Protect Environment",
     *                                   "customization_option_id": 331,
     *                                   "option_name": "dsadas",
     *                                   "price": 10,
     *                                   "order_item_id": 2,
     *                                   "order_id": 1
     *                               },
     *                               {
     *                                   "customization_id": 81,
     *                                   "custom_name": "Extra",
     *                                   "customization_option_id": 422,
     *                                   "option_name": "321321",
     *                                   "price": 0,
     *                                   "order_item_id": 2,
     *                                   "order_id": 1
     *                               }
     *                           ]
     *                       },
     *                       {
     *                           "id": 3,
     *                           "name": "Test 1",
     *                           "dish_id": 802,
     *                           "price": 45000,
     *                           "quantity": 1,
     *                           "order_id": 1,
     *                           "order_items_customizations": [
     *                               {
     *                                   "customization_id": 71,
     *                                   "custom_name": "Protect Environment",
     *                                   "customization_option_id": 311,
     *                                   "option_name": "Thit",
     *                                   "price": 10,
     *                                   "order_item_id": 3,
     *                                   "order_id": 1
     *                               }
     *                           ]
     *                       }
     *                   ]
     *               },
     *           ]
     *       }
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success" : false
     *       "error_code": "RESTAURANT02"
     *       "message": "Error, please check you params"
     *     }
     */
    public function myHistories(Request $request){
        $user = $request->user();
        $lang = $request->header('language');

        $ordersHistory = Order::join('restaurants', 'restaurants.id', 'orders.restaurant_id')
            ->join('order_delivery_info', 'order_delivery_info.order_id', '=', 'orders.id')
            ->join('restaurant_delivery_settings', function ($join) {
                $join->on('restaurant_delivery_settings.restaurant_id', '=', 'orders.restaurant_id')
                    ->on('restaurant_delivery_settings.district_id', '=', 'order_delivery_info.district_id');
            })
            ->select('orders.id', 'orders.order_number','orders.total_amount','orders.sub_total_amount','orders.discount',
                'orders.tax','orders.shipping_fee','orders.payment_method','orders.order_type',
                'orders.status','orders.notes','orders.tax_type','orders.tax_rate','orders.take_red_invoice','orders.created_at',
                "restaurants.name_$lang as restaurant_name",'order_delivery_info.district_id',"restaurants.id as restaurant_id",
                'order_delivery_info.ward_id','restaurant_delivery_settings.delivery_cost',
                'restaurant_delivery_settings.min_order_amount as minOrderAmount','restaurants.slug as restaurant_slug',
                'restaurants.online_payment','restaurants.cod_payment','restaurants.delivery','restaurants.pickup'
            )
            ->where('orders.user_id',$user->id)->with(['order_items' => function($query) use ($lang){
                $query->select('order_items.id',"dishes.name_$lang as name",'order_items.dish_id','order_items.price',
                'order_items.quantity','order_items.order_id')->leftJoin('dishes','dishes.id','=','order_items.dish_id');
            },'order_items.order_items_customizations' => function($query) use ($lang){
                $query->select(
                    "order_items_customizations.id",
                    "order_items_customizations.customization_id","customizations.name_$lang as custom_name",
                    "order_items_customizations.customization_option_id","customization_options.name_$lang as option_name",
                    "order_items_customizations.price","order_items_customizations.order_item_id","order_items_customizations.order_id",
                    "order_items_customizations.quantity"
                )->leftJoin('customizations','customizations.id','=','order_items_customizations.customization_id')
                ->leftJoin('customization_options','customization_options.id','=','order_items_customizations.customization_option_id');
            }])->get();

        
        return response()->json([
            'success' => true,
            'order' => $ordersHistory,
        ]);
    }

    public function reOrder(Request $request){
        $old_order_info = $request->input('old_order_info');
        $restaurant_slug = $old_order_info['restaurant_slug'];
        
        $tax_info = Tax::where('restaurant_id','=',$old_order_info['restaurant_id'])->first();
        $cart = CartService::initCart([
            'restaurant' => $restaurant_slug,
            'restaurant_id' => $old_order_info['restaurant_id'],
        ]);

        $items = $old_order_info['order_items'];
        foreach($items as $item){
            $cart = CartService::doAdd($cart,$item);
        }
        $delivery_fee = RestaurantDeliverySetting::where('restaurant_id','=',$old_order_info['restaurant_id'])
        ->where('district_id','=',$old_order_info['district_id'])->first();
        $cart['delivery_fee'] = $delivery_fee['delivery_cost'];
        $cart['payment'] = $old_order_info['payment_method'];
        $cart['service'] = $old_order_info['order_type'];
        $cart = CartService::updateCartInfo($cart);
        return response()->json([
            'success'=> true,
            'cart'=> $cart
        ]);
    }
}
