<?php

namespace App\Http\Controllers\Admin;

use App\Mail\NewOrderMail;
use App\Mail\OrderConfirmedMail;
use App\Mail\OrderRejectMail;
use App\Mail\SendMailable;
use App\Models\OrderDeliveryInfo;
use App\Models\OrderItem;
use App\Models\OrderTransaction;
use App\Models\ReviewToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderCustomerInfo;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderRejectReason;
use App\Models\Restaurant;
use App\Models\OrderItemCustomization;
use App\Models\Printer;
use App\Services\CommonService;
use DB, Log, Auth, Session;
use App\Traits\OrderLogTrait;
use Carbon\Carbon;
use App\Services\ExpoPushNotiService;

class OrdersController extends Controller
{
    use OrderLogTrait;
    CONST default_index = 'order';
    CONST required_method = [
        'edit',
        'update',
        'destroy',
        'show',
    ];
    CONST model = Order::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug=NULL)
    {
        $statuses = Order::ORDER_STATUS;
        $this->restaurant = Session::get('res');
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.orders.breadcrumbs.title'),
            'links' => [
                [
                    'href' => Session::has('res') ? url('admin/' . $this->restaurant->res_Slug . '/orders') : url('admin/orders'),
                    'text' => __('admin.orders.breadcrumbs.orders_index')
                ]
            ]
        ];
        session(['mainPage' => $request->fullUrl()]);

        // get search params
        $keyword = $request->get('q');
        $status = $request->get('status');
        $date_search = $request->get('date_from_to');
        $today = new \DateTime('now');
        $from = $today->format('Y-m-d');
        $to = $today->format('Y-m-d');
        if (!empty($date_search)) {
            $list_date = explode(' - ', $date_search);
            $from = $list_date[0] . ' 00:00:00';
            $to = $list_date[1] . ' 23:59:59';
        }

        $lang = Session::get('locale');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $orders = Order::select('orders.*')->orderBy('orders.status', 'asc')->orderBy('orders.id', 'desc');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $orders = $orders->whereHas('order_customer_infos', function ($query) use ($keyword) {
                $query->where('full_name', 'LIKE', $keyword);
                $query->orWhere('order_number', 'LIKE', $keyword);
                $query->orWhere('phone', 'LIKE', $keyword);
            });
        }
        $orders = $orders->whereBetween('orders.created_at', [$from, $to]);

        $listOrdersTransPayed = OrderTransaction::select('order_transactions.order_id')
            ->where('order_transactions.status','<>',0)->groupBy('order_transactions.order_id')->get()->toArray();

        $listOrdersTransNew = OrderTransaction::select('order_transactions.order_id')
            ->whereNotIn('order_transactions.order_id',$listOrdersTransPayed)->get()->toArray();

        // filter with search params
        if ($status != "") {
            $orders = $orders->where('orders.status', '=', $status);
            if ($status == 0) {
                if (!empty($listOrdersTransNew)) {
                    $orders = $orders->whereNotIn('orders.id', $listOrdersTransNew);
                }
            }
        } else {
            if (!empty($listOrdersTransNew)) {
                $orders = $orders->whereNotIn('orders.id', $listOrdersTransNew);
            }
        }

        if (Session::has('res')) {
            $restaurantId = $this->restaurant->id;
            $orders = $orders->where(function ($query) use ($restaurantId) {
                $query->orWhere("orders.restaurant_id", '=', $restaurantId);
            });
        } else {

        }

        $orders = $orders->paginate($perPage);
        return view('admin.orders.index', compact('orders', 'status', 'breadcrumbs', 'lang', 'statuses', 'from', 'to'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function live(Request $request)
    {
        $isAdminPage = count(func_get_args())==1;
        if ($isAdminPage) {
            $slug = NULL;
        }
        else {
            $slug = func_get_args()[0];
        }
        $this->restaurant = Session::get('res');
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.orders.breadcrumbs.title'),
            'links' => [
                [
                    'href' => Session::has('res') ? url('admin/' . $this->restaurant->res_Slug . '/live') : url('admin/live'),
                    'text' => __('admin.orders.breadcrumbs.orders_index')
                ]
            ]
        ];
        $now = new \DateTime('now');
        $from = $now->format('Y-m-d');
        $tomorrow = $now->modify('+1 day');
        $to = $tomorrow->format('Y-m-d');
        if (Session::has('res')) {
            $orders_new = Order::where('status', '=', 0)
                ->where('restaurant_id', '=', $this->restaurant->id)
                ->whereBetween('created_at', [$from, $to]);
        } else {
            $orders_new = Order::where('status', '=', 0)
                ->whereBetween('created_at', [$from, $to]);
        }

        $listOrdersTransPaySuccess = OrderTransaction::select('order_transactions.order_id')
            ->where('order_transactions.status','=',1)->groupBy('order_transactions.order_id')->get()->toArray();

        $listOrdersTransFail = OrderTransaction::select('order_transactions.order_id')
            ->whereNotIn('order_transactions.order_id',$listOrdersTransPaySuccess)->get()->toArray();

        if (!empty($listOrdersTransFail)) {
            $orders_new = $orders_new->whereNotIn('orders.id', $listOrdersTransFail)->get();
        } else {
            $orders_new = $orders_new->get();
        }

        if (Session::has('res')) {
            $orders_received = Order::where('status', '=', 1)->where('restaurant_id', '=', $this->restaurant->id)->whereBetween('created_at', [$from, $to])->offset(0)->limit(5)->get();
            $orders_admin_accepted = Order::where('status', '=', 2)->where('restaurant_id', '=', $this->restaurant->id)->whereBetween('created_at', [$from, $to])->offset(0)->limit(5)->get();
            $orders_accepted = Order::where('status', '=', 3)->where('restaurant_id', '=', $this->restaurant->id)->whereBetween('created_at', [$from, $to])->offset(0)->limit(5)->get();
            $orders_rejected = Order::where('status', '=', 4)->where('restaurant_id', '=', $this->restaurant->id)->whereBetween('created_at', [$from, $to])->offset(0)->limit(5)->get();
        } else {
            $orders_received = Order::where('status', '=', 1)->whereBetween('created_at', [$from, $to])->offset(0)->limit(5)->get();
            $orders_admin_accepted = Order::where('status', '=', 2)->whereBetween('created_at', [$from, $to])->offset(0)->limit(5)->get();
            $orders_accepted = Order::where('status', '=', 3)->whereBetween('created_at', [$from, $to])->offset(0)->limit(5)->get();
            $orders_rejected = Order::where('status', '=', 4)->whereBetween('created_at', [$from, $to])->offset(0)->limit(5)->get();
        }
        return view('admin.orders.live', compact('orders_new', 'orders_received', 'orders_admin_accepted', 'orders_accepted', 'orders_rejected', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $isAdminPage = count(func_get_args())==1;
        if ($isAdminPage) {
            $slug = NULL;
            $id = func_get_args()[0];
        }
        else {
            $slug = func_get_args()[0];
            $id = func_get_args()[1];
        }
        $breadcrumbs = [
            'title' => __('admin.orders.breadcrumbs.title'),
            'links' => [
                [
                    'href' => Session::has('res') ? url('admin/' . Session::get('res')->res_Slug . '/orders') : url('admin/orders'),
                    'text' => __('admin.orders.breadcrumbs.orders_index')
                ],
                [
                    'href' => '#',
                    'text' => __('admin.orders.breadcrumbs.show_order')
                ]
            ]
        ];

        $order = Order::findOrFail($id);
//        dd($order);
        // update status(status = new) when view order
        if ($order->status == 0) {
            $data['order_id'] = $order->id;
            $data['status'] = 1;
            $this->changeOrderStatus($data);
            $order->update(array('status' => 1));
        }

        $statuses = $order::STATUS_FILTER;
        if (Auth::user()->isRestaurant()) {
            $restaurantId = Session::get('res')->id;
            $order = Order::where('restaurant_id', $restaurantId)->findOrFail($id);
        }else{
            $order = Order::findOrFail($id);
        }

        $hasPrinter = (Printer::where('restaurant_id', '=', $order->restaurant_id)->count() > 0) ? 1 : 0;

        $order_items = OrderItem::where('order_id', '=', $order->id)
            ->join('dishes', 'dishes.id', '=', 'order_items.dish_id')
            ->select('order_items.*', 'dishes.name_en')
            ->get();

        $order_items_customization = OrderItemCustomization::where('order_id', '=', $order->id)
            ->join('customizations', 'customizations.id', '=', 'order_items_customizations.customization_id')
            ->join('customization_options', 'customization_options.id', '=', 'order_items_customizations.customization_option_id')
            ->select('order_items_customizations.*', 'customizations.name_en as custom_name', 'customization_options.name_en as option_name')
            ->get()->groupBy(['order_item_id', 'customization_id']);

        $previos_order = Order::where('user_id', '=', $order['user_id'])->where('restaurant_id', '=', $order->restaurant_id)->count() - 1;
        $reject_reasons = OrderRejectReason::all();
        if (empty($order_items)) {
            // show flash message
            return Session::has('res') ? redirect('/admin/' . Session::get('res')->res_Slug . 'orders') : redirect('/admin/orders');
        }


        try {
            $order_customer_info = OrderCustomerInfo::where('order_id', '=', $order->id)->firstOrFail();
            $order_delivery_info = OrderDeliveryInfo::where('order_id', '=', $order->id)->firstOrFail();
        } catch (\Exception $exception) {
            return Session::has('res') ? redirect('/admin/' . Session::get('res')->res_Slug . 'orders') : redirect('/admin/orders');
        }
        return view('admin.orders.show', compact('order', 'breadcrumbs', 'order_customer_info', 'order_delivery_info', 'order_items', 'statuses', 'reject_reasons', 'previos_order', 'order_items_customization', 'hasPrinter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $isAdminPage = count(func_get_args())==1;
        if ($isAdminPage) {
            $slug = NULL;
            $id = func_get_args()[0];
        }
        else {
            $slug = func_get_args()[0];
            $id = func_get_args()[1];
        }
        $breadcrumbs = [
            'title' => __('admin.orders.breadcrumbs.title'),
            'links' => [
                [
                    'href' => Session::has('res') ? url('admin/' . Session::get('res')->res_Slug . '/orders') : url('admin/orders'),
                    'text' => __('admin.orders.breadcrumbs.orders_index')
                ],
                [
                    'href' => '#',
                    'text' => __('admin.orders.breadcrumbs.edit_order')
                ]
            ]
        ];

        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $isAdminPage = count(func_get_args())==2;
        if ($isAdminPage) {
            $slug = NULL;
            $id = func_get_args()[1];
        }
        else {
            $slug = func_get_args()[1];
            $id = func_get_args()[2];
        }
        $requestData = $request->all();
        if ($requestData['status'] == 3) {
            $this->validation('orders', $request, [
                'reject_reason' => 'required'
            ]);
        }

        try {
            $order = Order::findOrFail($id);
        } catch (\Exception $exception) {
            return Session::has('res') ? redirect('admin/' . Session::get('res')->res_Slug . '/orders') : redirect('admin/orders');
        }

        $data['status'] = $requestData['status'];
        $data['notes'] = $requestData['notes'];
        $data['reject_reason'] = $requestData['reject_reason'];
        unset($requestData['_token']);

        Order::where('id', $id)->update($data);

        if ((int)$requestData['status'] == 1 || (int)$requestData['status'] == 3) {
            try {
                $orderCustomerInfo = OrderCustomerInfo::where('order_id', '=', $id)->firstOrFail();
//                $resultEmail = $this->sendMail($orderCustomerInfo->email,"Order No.: $order->order_number ".$order->status().".");
                $resultEmail = \Mail::to($orderCustomerInfo['email'])->send(new OrderConfirmedMail());
                $resultSMS = $this->sendSMS($orderCustomerInfo->phone, urlencode("Order No.: $order->order_number " . $order->status() . ".") . "%thong bao%");
            } catch (\Exception $exception) {
                \Illuminate\Support\Facades\Log::error($exception->getMessage());
            }
        }

        Session::flash('flash_message', trans('admin.orders.flash_messages.update'));
        return Session::has('res') ? redirect('admin/' . Session::get('res')->res_Slug . '/orders') : redirect('admin/orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $id)
    {
        Session::flash('flash_message', trans('admin.orders.flash_messages.can\'t_destroy'));
        return ession::has('res') ? redirect('admin/' . $slug . '/orders') : redirect('admin/orders');
    }


    private function sendMail($email, $subject, $message)
    {
        return \Mail::to($email)->send(new SendMailable([
            'email' => env('MAIL_FROM_ADDRESS'),
            'name' => env('MAIL_FROM_NAME'),
            'subject' => $subject,
            'message' => $message,
            'view_path' => 'emails.order'
        ]));
    }

    private function sendSMS($phoneNumber, $smsMessage)
    {
        return CommonService::sendSMS($phoneNumber, $smsMessage);
    }

    public function updateAdminNote(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        $order->admin_order_note = $request->input('admin_order_note');
        $order->save();
        return response()->json(['error' => false, 'message' => "Admin note updated"]);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->except('_token');
        try {
            if ($request->input('status') == 2) {
                Log::error("adminConfirmOrder");
                $this->adminConfirmOrder($data);
            } else if ($request->input('status') == 4) {
                $this->rejectOrder($data);
            } else if ($request->input('status') == 'done') {
                $this->orderDone($data);
            } else {
                $this->changeOrderStatus($data);
            }

        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => "Update order fail please  your log"]);
        }

        return response()->json(['error' => false, 'message' => "Status changed"]);
    }

    public function adminConfirmOrder($data)
    {

        try {
            $order = Order::join('users','users.id','=','orders.user_id')->select('orders.*','users.device_token','users.full_name')->findorFail($data['order_id']);
            $full_name = $order->full_name;
            $device_token = $order->device_token;
            $hasPrinter = (Printer::where('restaurant_id', '=', $order->restaurant_id)->count() > 0) ? 1 : 0;
            $printerStatus = DB::table('printers')->select('printer_status')->where('restaurant_id', '=', $order->restaurant_id)->first();
            if ($hasPrinter && $printerStatus->printer_status != 0) {
                $this->changeOrderStatus($data);
                $order = Order::findorFail($data['order_id']);
                $order->admin_accepted_at = Carbon::now()->toDateTimeString();
                $order->save();
                ExpoPushNotiService::pushNoti($device_token,"Accept Order","Hi $full_name, your order has beed accepted");
            } else {
                $data['status'] = '3';
                $this->confirmOrder($data);
                $order = Order::findorFail($data['order_id']);
                $order->admin_accepted_at = Carbon::now()->toDateTimeString();
                $order->confirm_delivery_time = $data['confirm_time'];
                $order->save();
                ExpoPushNotiService::pushNoti($device_token,"Accept Order","Hi $full_name, your order has beed accepted and will delivery at {$data['confirm_time']}");
            }

        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => "Update order fail please check your log"]);
        }
        return response()->json(['error' => false, 'message' => "Admin Accepted Order"]);
    }

    public function confirmOrder($data)
    {
        try {

            Log::error("confirmOrder");
            $this->changeOrderStatus($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => "Update order fail please check your log"]);
        }
        try {
            $orderCustomerInfo = OrderCustomerInfo::where('order_id', '=', $data['order_id'])->first();
            $order = Order::findOrFail($data['order_id']);
            $restaurant = Restaurant::join('restaurant_delivery_settings','restaurant_delivery_settings.restaurant_id','restaurants.id')
                ->join('districts','districts.id','restaurant_delivery_settings.district_id')
                ->select('restaurants.*','districts.slug as district_slug')
                ->where('restaurants.id',$order->restaurant_id)->first();
            $order->status = $data['status'];
            $data['district_slug'] = $restaurant->district_slug;
            $order->save();

            Log::error("sendMail");
            Log::error("sendMail" . $orderCustomerInfo['email']);
            // create token review order
            ReviewToken::insert(array(
                'order_id' => $order->id,
                'token' => hash_hmac('sha256', str_random(64), config('app.key')),
                'created_at' => new Carbon()
            ));
//            $this->sendMail($orderCustomerInfo['email'],"Your order has been confirmed at ".date('Y-m-d h:i:s'));
            \Mail::to($orderCustomerInfo['email'])->send(new OrderConfirmedMail($data));

            CommonService::sendSMS($orderCustomerInfo['phone'], 'Hello sir/madam, Your Order ' . $order->order_number . ' at ' . $restaurant->name_en . ' restaurant has been received with delivery time is about at ' . $data['confirm_time'] . '. Please wait for delivery man, he will come as soon as possible. Many thanks and hope you will enjoy.');
        } catch (\Exception $exception) {
            \Illuminate\Support\Facades\Log::error($exception->getMessage());
        }
        return response()->json(['error' => false, 'message' => "Order confirmed"]);
    }

    public function rejectOrder($data)
    {

        try {
            $this->changeOrderStatus($data);

        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => "Update order fail please check your log"]);
        }
        $res = Session::get('res');
        $order = Order::join('users','users.id','=','orders.user_id')->select('orders.*','users.device_token','users.full_name')->findorFail($data['order_id']);
        $full_name = $order->full_name;
        $device_token = $order->device_token;
        $reject_reason = isset($data['reject_reason']) ? $data['reject_reason'] : "";
        $order->reject_reason = $reject_reason;
        $order->save();
        try {
            $resName = Restaurant::where('id', $order->restaurant_id)->first()->name_en;
            $subject = '[Cancelled Order] From ' . $resName . ' restaurant';
            $orderCustomerInfo = OrderCustomerInfo::where('order_id', '=', $data['order_id'])->first();
            \Mail::to($orderCustomerInfo['email'])->send(new OrderRejectMail($data, $sendToAdmin = false, $subject));
            \Mail::to($res['email'])->send(new OrderRejectMail($data, $sendToAdmin = true, $subject));
            $restaurant = Restaurant::findOrFail($order->restaurant_id);
            ExpoPushNotiService::pushNoti($device_token,"Accept Order","Hi $full_name, your order has been rejected by ".Auth::user()->full_name." because $reject_reason");
            CommonService::sendSMS($orderCustomerInfo['phone'], 'Hello sir/madam, Your Order ' . $order->order_number . ' at ' . $restaurant->name_en . ' restaurant has been cancelled with reason ' . $data['reject_reason'] . '. Please try again to enjoy your meal. Many thanks');
        } catch (\Exception $exception) {
            \Illuminate\Support\Facades\Log::error($exception->getMessage());
        }
        return response()->json(['error' => false, 'message' => "Order confirmed"]);
    }

    public function orderDone($data)
    {

        try {
            $this->changeOrderStatus($data);

        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => "Update order fail please check your log"]);
        }

        $order = Order::findOrFail($data['order_id']);
        $order->status = Order::ORDER_STATUS[$data['status']];
        $order->save();
//        try{
//            $orderCustomerInfo = OrderCustomerInfo::where('order_id','=',$data['order_id'])->first();
////            \Mail::to($orderCustomerInfo['email'])->send(new OrderRejectMail($data));
////            $restaurant = Restaurant::findOrFail($order->restaurant_id);
////            CommonService::sendSMS($orderCustomerInfo['phone'],'Hello sir/madam, Your Order '.$order->order_number.' at '.$restaurant->name_en.' restaurant has been cancelled with reason '.$data['reject_reason'].'. Please try again to enjoy your meal. Many thanks');
//        }catch(\Exception $exception){
//            \Illuminate\Support\Facades\Log::error($exception->getMessage());
//        }
        return response()->json(['error' => false, 'message' => "Order confirmed"]);
    }

    public function confirmSendSMS(Request $request)
    {
        $selection = $request->get('sendToSMS');
        $smsContent = $request->get('sms-content');
        if ($selection == 1) {
            $customerPhoneNumber = $request->input('customer_phone');
            $this->sendSMS($customerPhoneNumber, $smsContent);
        } else {
            $optionalPhoneNumber = $request->get('optionalPhoneNumber');
            $this->sendSMS($optionalPhoneNumber, $smsContent);
        }

        return response()->json(['error' => false, 'message' => trans('admin.orders.statuses.success')]);
    }

    public function confirmSendMail(Request $request)
    {
        $selection = $request->get('sendToMail');
        $mailSubject = $request->input('mailSubject');
        $mailContent = $request->input('mailContent');
        if ($selection == 1) {
            $customerMail = $request->input('customer_mail');
            $this->sendMail($customerMail, $mailSubject, $mailContent);
        } else {
            $otherMail = $request->get('otherMail');
            $this->sendMail($otherMail, $mailSubject, $mailContent);
        }

        return response()->json(['error' => false, 'message' => trans('admin.orders.statuses.success')]);
    }

    public function confirmResendOrder(Request $request)
    {
        $order_id = $request->get('order_id');
        $order = Order::findOrFail($order_id);
        $order->status = 2;
        $order->printed = 0;
        $order->kitchen_accepted = 0;
        $order->save();
        return response()->json(['error' => false, 'message' => trans('admin.orders.statuses.success')]);
    }

    public function getOrders(Request $request)
    {
        $this->restaurant = Session::get('res');
        $now = new \DateTime('now');
        $from = $now->format('Y-m-d');
        $tomorrow = $now->modify('+1 day');
        $to = $tomorrow->format('Y-m-d');
        $queryData = $request->query->all();
        if(Session::has('res')){
            $orders = Order::where('status', '=', $queryData['status'])->where('restaurant_id', '=', $this->restaurant->id)->whereBetween('created_at', [$from, $to])->offset($queryData['offset'])->limit(5)->get();
        }else{
            $orders = Order::where('status', '=', $queryData['status'])->whereBetween('created_at', [$from, $to])->offset($queryData['offset'])->limit(5)->get();
        }
        if ($queryData['status'] == 0) {
            if(Session::has('res')){
                $orders = Order::where('status', '=', $queryData['status'])->where('restaurant_id', '=', $this->restaurant->id)->whereBetween('created_at', [$from, $to])->offset($queryData['offset'])->limit(5);
            }else{
                $orders = Order::where('status', '=', $queryData['status'])->whereBetween('created_at', [$from, $to])->offset($queryData['offset'])->limit(5);
            }
            $orders_transactions_array = OrderTransaction::select('order_transactions.order_id')->whereNull('order_transactions.transaction_id')->orWhere('order_transactions.status', 0)->get()->toArray();
            if (!empty($orders_transactions_array)) {
                $orders = $orders->whereNotIn('orders.id', $orders_transactions_array)->get();
            } else {
                $orders = $orders->get();
            }
        }
        $data = '';
        foreach ($orders as $order) {
            $customer_info = OrderCustomerInfo::where('order_id', '=', $order->id)->firstOrFail();
            $delivery_info = OrderDeliveryInfo::where('order_id', '=', $order->id)->firstOrFail();
            $province = \App\Models\Province::find($delivery_info->province_id);
            $district = \App\Models\District::find($delivery_info->district_id);
            $name_district = '';
            if (isset($district)) {
                $name_district = $district->name_en;
            }
            $paid = "Unpaid";
            if ($order->payment_method) {
                $paid = "Paid";
            }
            $data .= '<div class="m-demo"><div class="m-demo__preview"><div class="m-stack m-stack--ver m-stack--general"><div class="m-stack__item"><b>Time</b><br>' . \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('H:i') . '</div><div class="m-stack__item"><b>Customer</b><br>' . $customer_info->full_name . '</div><div class="m-stack__item"><b>City</b><br>' . $province->name_en . '</div><div class="m-stack__item"><b>Total</b><br>' . $order->totalAmountVND() . '</div></div><div class="m--space-15"></div><div class="m-stack m-stack--ver m-stack--general"><div class="m-stack__item"><b>Order Number</b><br><a href="' .(Session::has('res') ? url('/admin/' . Session::get('res')->res_Slug . '/orders/' . $order->id) : url('/admin/orders/' . $order->id)) . '">' . $order->order_number . '</a></div><div class="m-stack__item"><b>Phone</b><br>' . $customer_info->phone . '</div><div class="m-stack__item"><b>District</b><br>' . $name_district . '</div><div class="m-stack__item"><b>Paid/Unpaid</b><br><span class="m-badge m-badge--danger m-badge--wide">' . $paid . '</span></div></div><div class="m--space-15"></div><div class="m-stack m-stack--ver m-stack--general"><div class="m-stack__item"><b>Address</b><br>' . $delivery_info->full_address . '</div></div></div></div>';
        }

        return response()->json(['error' => false, 'data' => $data, 'count' => count($orders)]);

    }

    public function showConfirmOrderByEmail($token)
    {
        $order = Order::where('token', $token)->first();
        return view('admin.change_order_status.confirm', compact('order'));
    }

    public function changeToAccept(Request $request, $token)
    {
        $requestData = $request->all();
        $order = Order::where('token', $token)->first();
        $userEmail = OrderCustomerInfo::where('user_id', $order->user_id)->first()->email;
        $resName = Restaurant::where('id', $order->restaurant_id)->first()->name_en;
        $restaurant = Restaurant::join('restaurant_delivery_settings','restaurant_delivery_settings.restaurant_id','restaurants.id')
                ->join('districts','districts.id','restaurant_delivery_settings.district_id')
                ->select('restaurants.*','districts.slug as district_slug')
                ->where('restaurants.id',$order->restaurant_id)->first();
        $requestData['district_slug'] = $restaurant->district_slug;
        $requestData['status'] = 3;
        $requestData['admin_accepted_at'] = Carbon::now()->toDateTimeString();
        $requestData['confirm_delivery_time'] = $request->get('confirm_time');
        $order->update($requestData);
        ReviewToken::insert(array(
                'order_id' => $order->id,
                'token' => hash_hmac('sha256', str_random(64), config('app.key')),
                'created_at' => new Carbon()
            ));
        $data = [
            'order_id' => $order->id,
            'status' => $order->status,
            'confirm_time' => $order->confirm_delivery_time,
            'district_slug' => $restaurant->district_slug
        ];       
        $subject = '[Confirmed Order] From ' . $resName . ' restaurant';
        \Mail::to($userEmail)->send(new OrderConfirmedMail($data,$subject));
        Session::flash('flash_message', 'Order has been accepted!');
        return redirect('/');
    }

    public function showRejectOrderByEmail($token)
    {
        $order = Order::where('token', $token)->first();
        return view('admin.change_order_status.reject', compact('order'));
    }

    public function changeToReject(Request $request, $token)
    {
        $requestData = $request->all();
        $order = Order::where('token', $token)->first();
        $resEmail = Order::join('restaurants', 'restaurants.id', 'orders.restaurant_id')
            ->where('restaurants.id', $order->restaurant_id)
            ->first()->email;
        $resName = Restaurant::where('id', $order->restaurant_id)->first()->name_en;
        $userEmail = OrderCustomerInfo::where('user_id', $order->user_id)->first()->email;
        $requestData['status'] = 4;
        if ($request->get('reason') == 'other') {
            $requestData['reject_reason'] = $request->get('reason') . ': ' . $request->get('other_reason');
        } else {
            $requestData['reject_reason'] = $request->get('reason');
        }
        $order->update($requestData);
        $data = [
            'order_id' => $order->id,
            'reject_reason' => $order->reject_reason
        ];
        $subject = '[Cancelled Order] From ' . $resName . ' restaurant';
        \Mail::to($resEmail)->send(new OrderRejectMail($data, $sendToAdmin = true, $subject));
        \Mail::to($userEmail)->send(new OrderRejectMail($data, $sendToAdmin = false, $subject));

        Session::flash('flash_message', 'Order has been rejected!');
        return redirect('/');
    }
}
