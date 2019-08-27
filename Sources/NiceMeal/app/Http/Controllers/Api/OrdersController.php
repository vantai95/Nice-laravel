<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemCustomization;
use App\Models\OrderCustomerInfo;
use App\Models\Role;
use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\UsersRestaurant;
use App\Models\Printer;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App, DB;

class OrdersController extends Controller
{

    const AK = [
        'accepted' => 'Accepted',
        'rejected' => 'Rejected'
    ];

    const TRANS = [
        'delivery' => 1,
        'collection' => 2,
        'reservation' => 3,
        'verified' => 4,
        'not_verify' => 5,
        'order_paid' => 6,
        'order_not_paid' => 7
    ];

    /**
     * @api {GET} /api/order/polling-order Polling Order
     * @apiName PollingOrder
     * @apiVersion 1.0.0
     * @apiDescription Get order detail for printer
     * @apiGroup PRINTER
     *
     * @apiParam {String} a restaurant id
     * @apiParam {Number} u printer name
     * @apiParam {String} p printer token
     *
     * @apiParamExample Request-Example:
     *     {
     *       "a": 1
     *       "u": printer1
     *       "p": tjrnu9VlGpsI7gj0
     *     }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success" : true,
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success" : false
     *       "error_code": "ExampleC0de"
     *       "message": "Error, please check you params"
     *     }
     */
    public function pollingOrder(Request $request) {
        try {
            \Log::error('pollingOrder');
            $requestData = $request->all();

            if ($this->authenticate($request)) {

                // update printer status
                $printer = Printer::where('restaurant_id', $requestData['a'])
                    ->where('name', $requestData['u'])
                    ->where('token', $requestData['p'])
                    ->first();
                $printer->last_time_success = Carbon::now();
                $printer->printer_status = 1;
                $printer->save();

                $restaurant = Restaurant::where('id', '=', $requestData['a'])->first();
                $order = Order::where('restaurant_id', '=', $restaurant->id)
                    ->where('status', '=', Order::ORDER_STATUS['admin_accepted'])
                    ->where('printed', '=', false)
                    ->orderBy('created_at', 'asc')->first();
                if (!$order) return;

                $serialNum = $order->id; // 1
                $translations = ($order->order_type == 'delivery') ? $this::TRANS['delivery'] : $this::TRANS['collection']; // 2. Delivery
                $orderId = $order->order_number; // 3
                $items = ''; // 4
                $orderItems = OrderItem::where('order_id', '=', $order->id)->get();
                foreach ($orderItems as $key => $orderItem) {
                    $dish = Dish::where('id', '=', $orderItem->dish_id)->first();
                    $split = ($key == 0) ? '' : ';';
                    $item = $orderItem->quantity . ';' . $dish->name_en . ';' . App\Services\CommonService::formatPrice($orderItem->price);
                    $orderItemCuss = OrderItemCustomization::where('restaurant_id', '=', $restaurant->id)
                        ->where('order_id', '=', $order->id)->get();
                    $itemCus = '';
                    foreach ($orderItemCuss as $keyO => $cus) {
                        $cusOption = DB::table('customization_options')->where('id', '=', $cus->customization_option_id)->first();
                        $itemCus = $itemCus . '%%  + ' . $cus->quantity . ' x ' . $cusOption->name_en . ' : ' . App\Services\CommonService::formatPrice($cus->price);
                    }
                    $item = $item . $itemCus;
                    $items = $items . $split . $item;
                }
                $deliveryFee = App\Services\CommonService::formatPrice($order->shipping_fee); // 5
                $fee = 0; // 6
                $total = App\Services\CommonService::formatPrice($order->total_amount); // 7
                $cus = User::where('id', '=', $order->user_id)->first();
                $cusVerified = $cus->email_verified ? $this::TRANS['verified'] : $this::TRANS['not_verify']; // 8
                $cusName = $cus->full_name; // 9
                $cusAddr = $cus->address  . '%%Delivery at : ' . (new Carbon($order->delivery_time))->format('H:i');// 10
                $now = Carbon::now();
                $request = (new Carbon($order->delivery_time))->format('d-m-Y h:i A'); // 11
                $preOrder = Order::where('restaurant_id', '=', $restaurant->id)->where('status', '<>', Order::ORDER_STATUS['new'])->where('id', '<>', $order->id)->orderBy('created_at', 'asc')->first();
                $preOrderId = ($preOrder) ? $preOrder->id : ''; // 12
                $paidStatus = $this::TRANS['order_not_paid']; // 13
                $payCard = ($order->payment_method == 'cod_payment') ? 'cod:' : ''; // 14
                $cusPhone = $cus->phone; // 15
                $comment = $order->notes; // 16
                $response = '#' . $serialNum . '*' . $translations . '*' . $orderId . '*' . $items . '*' . $deliveryFee . '*' .
                    $fee . ';' . $total . ';' . $cusVerified . ';' . $cusName . ';' . $cusAddr . ';' . $request . ';' .
                    $preOrderId . ';' . $paidStatus . ';' . $payCard . ';' . $cusPhone . ';*' . $comment . '#';

                // update database
                $order->printed = 1;
                $order->save();

                return response($response)
                    ->withHeaders([
                        'Content-Type' => 'text/plain',
                    ]);
            }
        }
        catch(\Exception $exception) {
//            CommonService::getError($exception);
            \Log::error($exception);
        }
    }

    public function orderCallback(Request $request) {
        \Log::error('orderCallback');
        $requestData = $request->all();

        if ($this->authenticate($request)) {
            // update database
            $order = Order::where('order_number', '=', $requestData['o'])
                ->where('status', Order::ORDER_STATUS['admin_accepted'])
                ->first();
            if (!$order) return;

            $data = [
                'order_id' => Order::where('order_number', '=', $requestData['o'])->first()->id,
                'reject_reason' => $order->reject_reason,
            ];
            $orderCustomerInfo = OrderCustomerInfo::where('order_id','=',$order->id)->first();
            $restaurant = Restaurant::findOrFail($order->restaurant_id);
            if ($requestData['ak'] == $this::AK['accepted'])
            {
                $order->cooking_time = $requestData['dt'];
                $order->kitchen_accepted = true;
                $order->status = Order::ORDER_STATUS['accepted'];
                $timeNow = Carbon::parse(Carbon::now()->format('Y-m-d H:i:00'));
                $cookTime = new Carbon($order->cooking_time);
                $adminAcceptedTime = Carbon::parse((new Carbon($order->admin_accepted_at))->format('Y-m-d H:i:00'));
                $confirmDeliTime = new Carbon($order->confirm_delivery_time);
                $totalTime = $confirmDeliTime->diffInMinutes($adminAcceptedTime) + $cookTime->diffInMinutes($timeNow);
                $order->final_delivery_time = $adminAcceptedTime->addMinutes($totalTime)->format('H:i');
                $order->save();

                try{
                    // send mail
                    $data['confirm_time'] = $order->final_delivery_time;
                    \Mail::to($orderCustomerInfo['email'])->send(new App\Mail\OrderConfirmedMail($data));
                    CommonService::sendSMS($orderCustomerInfo['phone'],'Hello sir/madam, Your Order '.$order->order_number.' at '.$restaurant->name_en.' restaurant has been received with delivery time is about at '.$data['confirm_time'].'. Please wait for delivery man, he will come as soon as possible. Many thanks and hope you will enjoy.');
                }catch(\Exception $exception){
                    CommonService::getError($exception);
                }
            }
            else if ($requestData['ak'] == $this::AK['rejected']) {
                $order->status = Order::ORDER_STATUS['rejected'];
                $order->reject_reason = $requestData['m'];
                $order->save();
                try{
                    $resName = Restaurant::where('id',$order->restaurant_id)->first()->name_en;
                    $subject = '[Cancelled Order] From '.$resName.' restaurant';
                    \Mail::to($orderCustomerInfo['email'])->send(new App\Mail\OrderRejectMail($data,$sendToEmail = false,$subject));
                    CommonService::sendSMS($orderCustomerInfo['phone'],'Hello sir/madam, Your Order '.$order->order_number.' at '.$restaurant->name_en.' restaurant has been cancelled with reason '.$data['reject_reason'].'. Please try again to enjoy your meal. Many thanks');
                }catch(\Exception $exception){
                    CommonService::getError($exception);
                }
            }

            // return response
            return response('')
                ->withHeaders([
                    'Content-Type' => 'text/plain',
                ]);
        }
    }

    public function authenticate(Request $request) {
        $requestData = $request->all();

        return Printer::where('restaurant_id', $requestData['a'])
            ->where('name', $requestData['u'])
            ->where('token', $requestData['p'])
            ->exists();
    }

}
