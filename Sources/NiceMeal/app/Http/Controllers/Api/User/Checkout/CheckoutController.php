<?php

namespace App\Http\Controllers\Api\User\Checkout;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App;
use Lang;
use Session, Log, Exception, Auth, DB;
use App\Models\District,App\Models\Ward,App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Customization;
use App\Models\DishCustomization;
use App\Models\CustomizationOption;
use App\Services\CommonService;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderCustomerInfo;
use App\Models\OrderDeliveryInfo;
use App\Models\OrderItem;
use App\Models\UserCustomerInfo;
use App\Models\OrderItemCustomization;
use App\Mail\CheckoutToMail;
use App\Mail\NewOrderMail;
use App\Mail\SendMailable;
use App\Services\TBDService;
use App\Services\TBPService;
use App\Services\CheckoutService;
use App\Models\OrderTransaction;

class CheckoutController extends Controller
{

    /**
     * @api {POST} /api/checkout Order checkout
     * @apiName Order checkout
     * @apiVersion 1.0.0
     * @apiDescription Order checkout
     * @apiGroup ORDER
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     *
     *
     * @apiParamExample Request-Example:
     *       {
     *       "info": {
     *           "payment_amount": "100000",
     *           "delivery_time": "asap",
     *           "title": "1",
     *           "full_name": "admin",
     *           "email": "mantm3101.1@gmail.com",
     *           "phone": 906448224,
     *           "register": 0,
     *           "address": {
     *               "full_address": "dsadsadsa"
     *           },
     *           "specific_time": "12:52",
     *           "residencetype": {
     *               "value": "house"
     *           },
     *           "district": 760,
     *           "ward": 26740,
     *           "direction": "dsadsadsa"
     *       },
     *       "cart": {
     *           "items": [
     *               {
     *                   "dish": {
     *                       "dish_name": "[WB-1] SHIRAZ (750ml)",
     *                       "id": 651,
     *                       "price": 499000
     *                   },
     *                   "quantity": 2,
     *                   "custom": {},
     *                   "option": {},
     *                   "option_quantity": {}
     *               },
     *               {
     *                   "dish": {
     *                       "dish_name": "[WB-2] CABERNET SAUVIGNON (750ml)",
     *                       "id": 661,
     *                       "price": 499000
     *                   },
     *                   "quantity": 2,
     *                   "custom": {
     *                       "1": {
     *                           "custom_name": "Size",
     *                           "id": 1,
     *                           "price": 0
     *                       },
     *                       "11": {
     *                           "custom_name": "[SPE-3] Gravy sauce",
     *                           "id": 11,
     *                           "price": 0
     *                       }
     *                   },
     *                   "option": {
     *                       "1": {
     *                           "option_name": "abc 123",
     *                           "customization_id": 1,
     *                           "id": 1,
     *                           "price": 10000
     *                       },
     *                       "41": {
     *                           "option_name": "dsadas dsadas",
     *                           "customization_id": 11,
     *                           "id": 41,
     *                           "price": 10000
     *                       }
     *                   },
     *                   "option_quantity": {
     *                       "1": 1,
     *                       "41": 1
     *                   }
     *               }
     *           ],
     *           "sub_total": 2036000,
     *           "payment": "cod_payment",
     *           "order_note": "",
     *           "restaurant": "oh-my-meal",
     *           "service": "delivery",
     *           "delivery_fee": 19000,
     *           "order_total": 2055000,
     *           "total_item": 4,
     *           "tax": 50,
     *           "checkbill": 0,
     *           "tax_type": 1
     *       }
     *   }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success" : true,
     *          "data":{
     *             "token":"0x2E49Cff4906d8f4890fb08E287f6179781F6165C",
     *             "name":"Nguyen Phan",
     *             "email":"nguyenptt@imt-soft.com",
     *             "id":1
     *           }
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success" : false
     *       "error_code": "USER03"
     *       "message": "Error, please check you params"
     *     }
     */
    function finishOrder(Request $request){
            $data = $request->post('info');
            $cart = $request->post('cart');
            $restaurant = Restaurant::where('restaurants.slug','=',$cart['restaurant'])->first();

            $order_id = 0;
            $otp_verify = 0;
            $otp_created_at = null;
            $dishes_changed = [];
            $dishes_disappear =[];

            $dish_id_in_cart = collect($cart['items'])->where('free_item', 0);


            //When cart empty don't check out


            //check time base display
            $dishes_disappear = TBDService::checkMultipleDishes($dish_id_in_cart);
            if(count($dishes_disappear) > 0){
                return response()->json([
                    'success' => false,
                    'message' => "These dishes aren't available right now, please click apply synchronize your cart data",
                    'dishes_disappear'=>true,
                    'dishes_disappear_list' => $dishes_disappear]);
            }
            //end check

            //check time base pricing changed

            $dishes_changed = TBPService::timeBasePricingMultiDish($dish_id_in_cart);
            if(count($dishes_changed) > 0){
                return response()->json([
                    'success' => false,
                    'message' => "The price of these dishes was changed, please click apply synchronize your cart data",
                    'dishes_changed'=>true,
                    'dishes_changed_list' => $dishes_changed]);
            }
            //end check
            DB::transaction(function() use ($data,$cart,$restaurant, &$order_id, &$otp_verify, &$otp_created_at,$request){
                $otp = CommonService::generateOTP();
                $input_user = $request->user('api');
                [$user_id] = CheckoutService::userCheck($data,$restaurant,$input_user);

                [$otp_verify] = CheckoutService::otpVerifyOrNot($user_id,$restaurant,$cart);

                [$token,$order_id,$otp_created_at] = CheckoutService::createOrder($cart,$data,$user_id,$otp_verify,$otp);

                $user_data = [
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'address'=> (isset($data['address']['full_address'])) ?  $data['address']['full_address'] : "",
                    'phone' => $data['phone'],
                    'gender' => $data['title']
                ];
                if($cart['payment']!='online_paymnent')
                    CheckoutService::sendCheckoutEmail($otp_verify,$user_data,$otp,$restaurant,$token,$order_id);
            });
            return response()->json(['success' => true,
                                    'order_id'=>$order_id,
                                    'send_left' => intval(env('OTP_RESEND_LIMIT')),
                                    'otp_verify'=>$otp_verify,
                                    'otp_created_at' => $otp_created_at]);
    }

    /**
     * @api {POST} /api/confirm-otp Confirm OTP
     * @apiName Confirm OTP
     * @apiVersion 1.0.0
     * @apiDescription Confirm OTP
     * @apiGroup ORDER
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     *
     *
     * @apiParamExample Request-Example:
     *      {
     *           "order_id": 26,
     *           "otp": 425774
     *      }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success" : true,
     *          "message": "OTP confirmed successfully"
     *        }
     *
     * @apiErrorExample Order not found:
     *     HTTP/1.1 404 Not Found
     *     {
     *          "success": false,
     *          "message"=> "Order not found"
     *     }
     * @apiErrorExample Order not found:
     *     HTTP/1.1 404 Not Found
     *     {
     *          "success": false,
     *          "message"=> "Order not found"
     *     }
     * @apiErrorExample OTP expired:
     *     HTTP/1.1 404 Not Found
     *     {
     *          "success": false,
     *          "message"=> "OTP expired"
     *     }
     * @apiErrorExample OTP is not correct:
     *     HTTP/1.1 404 Not Found
     *     {
     *          "success": false,
     *          "message"=> "OTP is not correct"
     *     }
     */
    function confirmotp(Request $request){

        $order_id = $request->input('order_id');
        $otp = $request->input('otp');
        $order = Order::where('id',$order_id)->where('otp',Order::OTP_PREFIX.$otp)->first();

        if($order == null){
            return response()->json([
                'success'=>false,
                'message'=> 'OTP is not correct'
            ]);
        }

        if(strtotime($order->otp_expired_at) < time()){
            return response()->json([
                'success'=>false,
                'message'=> 'OTP expired'
            ]);
        }else{
            if(!$order->otp_verified){
                if($order->otp == Order::OTP_PREFIX.$otp){
                    $order->otp_verified = 1;
                    $order->save();
                    return response()->json([
                        'success'=>true,
                        'message'=> 'OTP confirmed successfully'
                    ]);
                }else{
                    return response()->json([
                        'success'=>false,
                        'message'=> 'OTP is not correct'
                    ]);
                }
            }
        }
    }
    function checkVoucher(Request $request){
        $lang = $request->header("language");
        $voucher_code = $request->input('voucher_code');
        $cart = $request->input('cart');
        return CheckoutService::checkVoucher($cart,$voucher_code,$lang);
    }

    function resendOtp(Request $request){
        $order_id = $request->input('order_id');
        return CheckoutService::doResendOtp($order_id);
    }

    /**
     * @api {POST} /api/save-payment-info Save Payment Info
     * @apiName Save Payment Info
     * @apiVersion 1.0.0
     * @apiDescription Save Payment Info
     * @apiGroup ORDER
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     *
     *
     * @apiParamExample Request-Example:
     *      {
     *           "order_id": 26,
     *           "order_number": "NM-425774",
     *           "restaurant_id": "1",
     *           "payment_mode": "paypal",
     *           "transaction_id": "XXX",
     *           "amount": "50",
     *           "status": 0
     *      }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success" : true,
     *          "message": "Save Payment success"
     *        }
     *
     * @apiErrorExample Can not save info:
     *     HTTP/1.1 404 Not Found
     *     {
     *          "success": false,
     *          "message"=> "Error, please check you params"
     *     }
     */
    function savePaymentInfo(Request $request){
        try
        {
            $lang = $request->header("language");
            $order_id = $request->input('order_id');
            $restaurant_id = $request->input('restaurant_id');
            $payment_mode = $request->input('payment_mode');
            $transaction_id = $request->input('transaction_id');
            $amount = $request->input('amount');
            $status = $request->input('status');

            $order = Order::where("id",$order_id)->first();
            if(empty($order)){
                return response()->json([
                    "success" => false,
                    "error_code" => "PAYMENTERROR01",
                    "message" => "Cannot find this order"
                ]);
            }
            $order_number = $order->order_number;
            $orderTransaction = OrderTransaction::where("order_id",$order_id)
                                        ->where("restaurant_id",$restaurant_id)
                                        ->where("transaction_id",$transaction_id)
                                        ->orderBy('id','desc')
                                        ->first();
            if(empty($orderTransaction)){
                //create
                $order_transaction = [
                    'order_id' => $order_id,
                    'order_number' => $order_number,
                    'restaurant_id' => $restaurant_id,
                    'payment_mode' => $payment_mode,
                    'transaction_id' => $transaction_id,
                    'amount' => $amount,
                    'status' => $status,
                ];
                OrderTransaction::create($order_transaction);
            }else{
                //update
                $orderTransaction->status = $status;
                $orderTransaction->update();
                if($status == 2){
                  $order->status = 9;
                  $order->save();
                }
            }
            return response()->json([
                'success'=>true,
                'message'=> 'Save Payment success'
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "error_code" => "PAYMENTERROR01",
                "message" => "Error, please check you params"
            ]);
        }
    }
}
