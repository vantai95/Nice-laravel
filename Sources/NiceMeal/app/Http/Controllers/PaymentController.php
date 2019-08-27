<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config,Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;

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
use App\Models\Promotion;
use App\Models\PromotionUsage;
use App\Models\OrderTransaction;
use App\Models\Setting;
use App\Services\CheckoutService;

use App\Mail\NewOrderMail;
use App\Mail\SendMailable;
use Illuminate\Support\Facades\Input;

class PaymentController extends Controller
{
    
    //    
    public function __construct()
    {
        /** PayPal api context **/
        $paypalConf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypalConf['client_id'],
            $paypalConf['secret'])
        );
        $this->_api_context->setConfig($paypalConf['settings']);

        $this->alepayConf = \Config::get('nganluong');        
    }
    public function processPayment(Request $request)
    {        
        Log::error("processPayment");
        //get order info        
        $data = $request->all();
        $paymentWith = $data['p_payment_with'];
        Log::error($paymentWith);
        $order = Order::where("id",$data['p_order_id'])->first();

        if($paymentWith == 'paypal'){
            $this->paymentWithPaypal($order);
        }else if($paymentWith == 'nganluong'){
            $this->paymentWithAlepay($order);
        }else{
            \Session::put('error', 'Unknown error occurred');
            return Redirect::to('/payment/payment-result');
        }
        
    }

    private function paymentWithPaypal($order){
        //get exchange_rate
        $exchange_rate = config('constants.EXCHANGE_RATE');
        $exchange = Setting::join('setting_keys','settings.key','=','setting_keys.name')
        ->where('setting_keys.name','exchange_rate')
        ->where('settings.restaurant_id',$order->restaurant_id)->first();
        if(!empty($exchange)){
            if($exchange->value>0)
                $exchange_rate = $exchange->value;
        }
        //calculate total amount
        $total_amount =$order->total_amount/$exchange_rate;// Todo: Need get setting from admin
        $total_amount = CommonService::formatPriceOnlinePayment($total_amount);

        //call paypal
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_name = 'Payment Online with order:'.$order->order_number.' of NiceMeal.com. '.CommonService::formatPriceVND($order->total_amount).' = '.$total_amount.' USD.';
        $item_1->setName($item_name) 
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($total_amount);
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($total_amount);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('NiceMeal.com');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(env('PAYMENT_CALLBACK_URL')) /** Specify return URL **/
            ->setCancelUrl(env('PAYMENT_CALLBACK_URL'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        // store transaction to db
        Log::error($transaction);
        $order_transaction = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'restaurant_id' => $order->restaurant_id,
            'payment_mode' => "paypal",
            'amount' => $total_amount,
            'status' => 0,
        ];  

        $order_transaction_id = OrderTransaction::create($order_transaction)->id;
        $order_transaction = OrderTransaction::findOrFail($order_transaction_id);
            
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                Log::error("Connection timeout");
                \Session::put('error', 'Connection timeout');
                $order_transaction->status=2;    
                $order_transaction->note='Connection timeout';    
                $order_transaction->update();  
                $order->status = 9;//paymentfail       
                $order->update();   
                echo '<meta http-equiv="refresh" content="0;url=' . url('/payment/payment-status'). '">';
            } else {
                Log::error("Some error occur, sorry for inconvenient");
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                $order_transaction->status=2;    
                $order_transaction->note='Some error occur, sorry for inconvenient';    
                $order_transaction->update();     
                $order->status = 9;//paymentfail       
                $order->update();    
                echo '<meta http-equiv="refresh" content="0;url=' . url('/payment/payment-status'). '">';
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        Log::error("paypal_payment_id");
        Log::error($payment->getId());

        Session::put('paypal_payment_id', $payment->getId());
        log::error($redirect_url);
        if (isset($redirect_url)) {
            /** redirect to paypal **/            
            $order_transaction->transaction_id=$payment->getId();  
            $order_transaction->update();                             
            $paymentId = Session::get('paypal_payment_id');
            echo '<meta http-equiv="refresh" content="0;url=' . $redirect_url. '">'; 
            exit();
        }
        \Session::put('error', 'Unknown error occurred');
        Log::error("Unknown error occurred");                
        $order_transaction->status=2;    
        $order_transaction->transaction_id=$payment->getId();    
        $order_transaction->note='Unknown error occurred';    
        $order_transaction->update();     
        $order->status = 9;//paymentfail       
        $order->update();   
        echo '<meta http-equiv="refresh" content="0;url=' . url('/payment/payment-status'). '">';
    }

    private function paymentWithAlepay($order){       
        require(app_path() . '\Libraries\Alepay.php');
        $customer_data = OrderCustomerInfo::where("order_id",$order->id)->first();
        $alepay = new \Alepay($this->alepayConf);  
        $data = array();  
        $data['cancelUrl'] = env('PAYMENT_CALLBACK_URL');
        $data['amount'] = intval(preg_replace('@\D+@', '', $order->total_amount));
        $data['orderCode'] = $order->order_number;
        $data['currency'] = 'VND';//$params['currency'];
        $orderDescription = 'Payment Online with order:'.$order->order_number.' of NiceMeal.com. '.CommonService::formatPriceVND($order->total_amount);        
        $data['orderDescription'] = $orderDescription;//$params['orderDescription'];
        $data['totalItem'] = 1;//intval($params['totalItem']);
        $data['checkoutType'] = 3; // Thanh toán trả góp + nội địa + quốc tế
        $data['buyerName'] = $customer_data['full_name'];//trim($params['buyerName']);
        $data['buyerEmail'] = $customer_data['email'];//trim($params['buyerEmail']);
        $data['buyerPhone'] = $customer_data['phone'];//trim($params['phoneNumber']);
        if($customer_data['address']=='')
            $customer_data['address'] = 'Hồ Chí Minh';
        $data['buyerAddress'] = $customer_data['address'];//trim($params['buyerAddress']);
        $data['buyerCity'] = 'Hồ Chí Minh';//trim($params['buyerCity']);
        $data['buyerCountry'] = 'Việt Nam';//trim($params['buyerCountry']);
        $data['month'] = 3;
        $data['paymentHours'] = 1; //48 tiếng :  Thời gian cho phép thanh toán (tính bằng giờ)        
    
        foreach ($data as $k => $v) {
            if (empty($v)) {
                $alepay->return_json("NOK", "Bắt buộc phải nhập/chọn tham số [ " . $k . " ]");
            }
        }
        $data['allowDomestic'] = true;  
    
        //Save token
        $order_transaction = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'restaurant_id' => $order->restaurant_id,
            'payment_mode' => "nganluong",
            'amount' => $order->total_amount,
            'status' => 0,
        ];  
        $order_transaction_id = OrderTransaction::create($order_transaction)->id;
        $order_transaction = OrderTransaction::findOrFail($order_transaction_id);
        $result = $alepay->sendOrderToAlepay($data); // Khởi tạo
     
        if (isset($result) && !empty($result->checkoutUrl)) {
            //Save token
            $order_transaction->status=0;    
            $order_transaction->transaction_id=$result->token;    
            $order_transaction->update();    
            //$alepay->return_json('OK', 'Thành công', $result->checkoutUrl);
            Session::put('alepay_token', $result->token);
            echo '<meta http-equiv="refresh" content="0;url=' . $result->checkoutUrl. '">';
        } else {  
                        
            $order_transaction->status=2;    
            $order_transaction->note=$result->errorDescription;    
            $order_transaction->update();
            \Session::put('error', $result->errorDescription);
            Log::error($result->errorDescription);             
            echo '<meta http-equiv="refresh" content="0;url=' . url('/payment/payment-status'). '">';
            
        }
    }

    public function processPaymentResult(Request $request) {
        $requestData = $request->all();
        if(!$requestData) {
            return Redirect::to('/');
        }
        $alepay_token = Session::get('alepay_token');                 
        $paymentId = Session::get('paypal_payment_id');
        if($alepay_token!=''){           
            require(app_path() . '\Libraries\Alepay.php');            
            $alepay = new \Alepay($this->alepayConf);
            $utils = new \AlepayUtils();
            $encryptKey = $this->alepayConf['encryptKey'];            
            $result = $utils->decryptCallbackData($_REQUEST['data'], $encryptKey);
            $order_transaction = OrderTransaction::where("transaction_id",$alepay_token)->first();            
            $order = Order::where("id",$order_transaction->order_id)->first();
           
            $obj_data = json_decode($result);
            if ($obj_data->errorCode === '000') {
                \Session::put('success', 'Payment success');    
                Log::error("Payment success");                                
                $order_transaction->status=1;       
                $order_transaction->note='Payment success';    
                $order_transaction->update();    
                return Redirect::to('/payment/payment-status');
            }else{
                $errorMessage = $this->getErrorMessageFromAlepay($obj_data->errorCode);
                \Session::put('error', 'Payment failed '.$errorMessage);    
                Log::error("Payment failed ".$errorMessage);                        
                $order_transaction->status=2;       
                $order_transaction->note='Payment failed '.$errorMessage;    
                $order_transaction->update(); 
                $order->status = 9;//paymentfail       
                $order->update();       
                return Redirect::to('/payment/payment-status');
            }

    
        }else{
            /** Get the payment ID before session clear **/
            $paymentId =isset( $requestData['paymentId'])?$requestData['paymentId']:Session::get('paypal_payment_id');
            Log::error("paymentId = ".$paymentId); 
            Session::put('paypal_payment_id', $paymentId);   
            $order_transaction = OrderTransaction::where("transaction_id",$paymentId)->first();
            $order = Order::where("id",$order_transaction->order_id)->first();
            /** clear the session payment ID **/
            if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
                \Session::put('error', 'Payment failed');    
                Log::error("Payment failed");                        
                $order_transaction->status=2;       
                $order_transaction->note='Payment failed';    
                $order_transaction->update(); 
                $order->status = 9;//paymentfail       
                $order->update();       
                return Redirect::to('/payment/payment-status');
            }
            $payment = Payment::get($paymentId, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId(Input::get('PayerID'));
            /**Execute the payment **/
            $result = $payment->execute($execution, $this->_api_context);
            Log::error("Result of payment");
            Log::error($result);
            if ($result->getState() == 'approved') {
                \Session::put('success', 'Payment success');    
                Log::error("Payment success");                                
                $order_transaction->status=1;       
                $order_transaction->note='Payment success';    
                $order_transaction->update();    
                return Redirect::to('/payment/payment-status');
            }
            \Session::put('error', 'Payment failed'); 
            Log::error("Payment failed");                
                    
            $order_transaction->status=2;       
            $order_transaction->note='Payment failed';    
            $order_transaction->update();     
            $order->status = 9;//paymentfail       
            $order->update();   
            return Redirect::to('/payment/payment-status');
        }
        
    }

    public function getPaymentStatus(){
        $paymentId = Session::get('alepay_token');
        if($paymentId==''){
            $paymentId = Session::get('paypal_payment_id');
        }
        Log::info($paymentId);
        $verified =0;
        if($paymentId){
            Session::forget('alepay_token');
            Session::forget('paypal_payment_id');
            $order = Order::join("order_transactions",'orders.id',"order_transactions.order_id")
            ->where("order_transactions.transaction_id",$paymentId)->select("orders.*")
            ->first();

            $restaurant = Restaurant::where("id",$order->restaurant_id)->first();
            $countOrder = DB::select("SELECT
            count(orders.id) total_orders
            FROM orders
            WHERE user_id = $order->user_id AND restaurant_id = $restaurant->id
            ")[0]->total_orders;

            $countOrderOtp = true;
            if($countOrder > $restaurant->otp) {
                $countOrderOtp = false;
            }
            $orderId = $order->id;
            $order['order_total'] = $order->total_amount;
            $otpVerify = CheckoutService::otpVerifyOrNot($order->user_id,$restaurant,$order);
            $order = array_except($order,['order_total']);
            $customer_data = OrderCustomerInfo::where("order_id",$order->id)->first();
            $user_data = [
                'full_name' => $customer_data['full_name'],
                'email' => $customer_data['email'],
                'address'=> $customer_data['address'],
                'phone' => $customer_data['phone'],
                'gender' => $customer_data['gender']
            ];
            $time = time();

            $orderTransaction = OrderTransaction::where("order_id",$order->id)->orderBy("id",'desc')->first();
            $showErrorMessage = 0;
            //dd($otpVerify);
            if($orderTransaction->status!=1){
                $showErrorMessage = 1;   
                $newOtp='';
                $message = $orderTransaction->note;
                Session::flash('flash_error', "Not found transaction id. Please try again!");
                return view('user.payment.status',compact('paymentId','order','otpVerify','restaurant','newOtp','orderId','orderTransaction','showErrorMessage','verified','message','countOrderOtp'));
            }  
            $newOtp=''; 
            if($otpVerify[0]>0){ 
                $newOtp = CommonService::generateOTP();
                $token = md5($orderId.date('Y-m-d H:i:s', $time + (env('TOKEN_EXPIRED_TIME')/1000)));
                $newOtpExpiredAt = date('Y-m-d H:i:s', $time + (env('TIME_SHOW_POPUP')/1000) );
                $order->update([
                    'token' => $token,
                    'otp' => $newOtp,
                    'otp_expired_at' => $newOtpExpiredAt
                ]);
                Log::info('Send success!');
                //send SMS to customer and email to restaurant
                //send email to admin of restaurant
                CheckoutService::sendCheckoutEmail($otpVerify,$user_data,$newOtp,$restaurant,$token,$orderId);
                $verified =0;
            }
            return view('newuser.views.payment.status',compact('paymentId','order','otpVerify','restaurant','newOtp','orderId','orderTransaction','showErrorMessage','verified','countOrderOtp'));
            return view('user.payment.status',compact('paymentId','order','otpVerify','restaurant','newOtp','orderId','orderTransaction','showErrorMessage','verified','countOrderOtp'));
        }
        
        Session::flash('flash_error', "Not found transaction id. Please try again!");
        Log::error("Not found transaction id. Please try again");
        return Redirect::to('/');
    }

    function confirmOnlinePaymentOtp(Request $request){
        $paymentId = Session::get('paypal_payment_id');
        $order_transaction = OrderTransaction::where("transaction_id",$paymentId)->first();
        $otp = $request->input('otp');
        $order_id = $request->input('order_id');
        $order = Order::where("id",$order_id)
            ->where('otp',Order::OTP_PREFIX.$otp)
            ->first();

        if(!$order){
            return response()->json([
                'error'=>true,
                'message'=> 'OTP not found!'
            ]);
        }
        if(strtotime($order->otp_expired_at) < time()){
            return response()->json([
                'error'=>true,
                'message'=> 'OTP expired'
            ]);
        }else{
            if(!$order->otp_verified){
                if($order->otp == Order::OTP_PREFIX.$otp){
                    $order->otp_verified = 1;
                    $order->save();
                    return response()->json(['error'=>0]);
                }else{
                    return response()->json([
                        'error'=>true,
                        'message'=> 'OTP is not correct'
                    ]);
                }
            }
        }
    }

    function resendOnlinePaymentOTP(Request $request){
        $paymentId = Session::get('paypal_payment_id');
        $order_transaction = OrderTransaction::where("transaction_id",$paymentId)->first();
        $order_id = $request->input('order_id');
        $order = Order::where("id",$order_id)->first();
        if(!$order){
            Session::flash('error_message','Order not exist, please contact your restaurant to confirm');
            return redirect('/');
        }
        $orderId = $order->id;
        return CheckoutService::doResendOtp($orderId);

    }

    public function test(){
        return view('user.payment.test');
    }

    public function getErrorMessageFromAlepay($errorCode){
        $errorMessage = '';
        $messageList = [ '000' => trans('payment.nganluong.000')];
        for($i=101;$i<233;$i++){
           $messageList[''.$i] = trans('payment.nganluong.'.$i);
        }
        $messageList[999] = trans('payment.nganluong.999');
        return $messageList["$errorCode"];
    }


}
