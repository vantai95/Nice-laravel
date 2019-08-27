@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @php
        $now = new \DateTime('now');
        $from = $now->format('Y-m-d');
        $tomorrow = $now->modify('+1 day');
        $to = $tomorrow->format('Y-m-d');
        $unconfirm_order_cod =\Session::has('res') ? 
            App\Models\Order::select('orders.*')
            ->whereIn('orders.status',[0,1])
            ->where('orders.restaurant_id','=',$res->id)
            ->whereBetween('orders.created_at',[$from,$to])
            ->where('payment_method','cod_payment')->count(): 
            App\Models\Order::whereIn('orders.status',[0,1])
            ->whereBetween('orders.created_at',[$from,$to])
            ->where('payment_method','cod_payment')->count();
       
 
       $unconfirm_order_online =\Session::has('res') ? 
            App\Models\Order::join('order_transactions','order_transactions.order_id','orders.id')
            ->select('orders.status','order_transactions.status','orders.payment_method','orders.restaurant_id')
            ->whereIn('orders.status',[0,1])
            ->where('orders.payment_method','online_payment')
            ->where('order_transactions.status',1)
            ->where('orders.restaurant_id','=',$res->id)
            ->whereBetween('orders.created_at',[$from,$to])
            ->count()
            : 
            App\Models\Order::join('order_transactions','order_transactions.order_id','orders.id')
            ->select('orders.status','order_transactions.status','order.payment_method')
            ->whereIn('orders.status',[0,1])
            ->where('order.payment_method','online_payment')
            ->where('order_transactions.status',1)
            ->whereBetween('orders.created_at',[$from,$to])
            ->count();

        $count_confirm = \Session::has('res') ? App\Models\Order::whereIn('status',[2,3,4])->where('restaurant_id','=',$res->id)->whereBetween('created_at',[$from,$to])->count() : App\Models\Order::whereIn('status',[2,3,4])->whereBetween('created_at',[$from,$to])->count();
    @endphp
    <div class="m-content">
        {{--Unconfirm--}}
        <div class="m-accordion m-accordion--default m-accordion--toggle-arrow" id="m_accordion_1" role="tablist">

            <!--begin::Item-->
            <div class="m-accordion__item m-accordion__item--metal">
                <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_1_head" data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="false">
                    <span class="m-accordion__item-title">UnConfirm <span class="text-danger">({{ $unconfirm_order_cod + $unconfirm_order_online}})</span></span>
                    <span class="m-accordion__item-mode"></span>
                </div>
                <div class="m-accordion__item-body collapse show" id="m_accordion_1_item_1_body" role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1">
                    <div class="m-portlet m-portlet--tabs">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-tools">
                                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a id="m_uc_tag_new" class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_1_1" role="tab" aria-selected="true">
                                            <i class="la la-plus"></i> New <span id="m_count_new" class="text-danger">({{ count($orders_new) }})</span>
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a id="m_uc_tag_received" class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_1_2" role="tab" aria-selected="false">
                                            <i class="la la-envelope"></i> Received <span id="m_count_received" class="text-danger">({{ count($orders_received) }})</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body" id="m_un_confirm">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="m_tabs_1_1" role="tabpanel">
                                    <div class="m-portlet__body" id="m_content_orders_new">
                                        @foreach($orders_new as $index => $new)
                                            @php
                                                $customer_info = \App\Models\OrderCustomerInfo::where('order_id','=',$new->id)->firstOrFail();
                                                $delivery_info = \App\Models\OrderDeliveryInfo::where('order_id','=',$new->id)->firstOrFail();
                                                $province = \App\Models\Province::find($delivery_info->province_id);
                                                $district = \App\Models\District::find($delivery_info->district_id);
                                            @endphp
                                            <div class="{{$index > 4 ? 'm-demo d-none' : 'm-demo'}}">
                                                <div class="m-demo__preview">
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Time</b><br>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $new->created_at)->format('H:i') }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Customer</b><br>{{ $customer_info->full_name }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>City</b><br>{{ $province->name_en }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Total</b><br>{{ $new->totalAmountVND() }}
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Order Number</b><br><a href="{{\Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders/'. $new->id) : url('/admin/orders/'. $new->id) }}">{{ $new->order_number }}</a>
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Phone</b><br>{{ $customer_info->phone }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>District</b><br>{{ $district->name_en ?? '' }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Paid/Unpaid</b><br><span class="m-badge m-badge--danger m-badge--wide">
                                                                @if($new->payment_method == 'online_payment')
                                                                    Paid
                                                                @else
                                                                    Unpaid
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Address</b><br>{{ $delivery_info->full_address }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($orders_new))
                                    <div class="m-portlet__foot" id="m_foot_orders_new">
                                        <button id="btnReadMoreNew" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Read more</button>
                                    </div>
                                    @endif
                                </div>
                                <div class="tab-pane" id="m_tabs_1_2" role="tabpanel">
                                    <div class="m-portlet__body" id="m_content_orders_received">
                                        @foreach($orders_received as $received)
                                            @php
                                                $customer_info = \App\Models\OrderCustomerInfo::where('order_id','=',$received->id)->firstOrFail();
                                                $delivery_info = \App\Models\OrderDeliveryInfo::where('order_id','=',$received->id)->firstOrFail();
                                                $province = \App\Models\Province::find($delivery_info->province_id);
                                                $district = \App\Models\District::find($delivery_info->district_id);
                                            @endphp
                                            <div class="m-demo">
                                                <div class="m-demo__preview">
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Time</b><br>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $received->created_at)->format('H:i') }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Customer</b><br>{{ $customer_info->full_name }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>City</b><br>{{ $province->name_en }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Total</b><br>{{ $received->totalAmountVND() }}
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Order Number</b><br><a href="{{\Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders/'. $received->id) : url('/admin/orders/'. $received->id) }}">{{ $received->order_number }}</a>
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Phone</b><br>{{ $customer_info->phone }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>District</b><br>{{ $district->name_en ?? "" }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Paid/Unpaid</b><br><span class="m-badge m-badge--danger m-badge--wide">                                                              
                                                                @if($received->payment_method == 'online_payment')
                                                                    Paid
                                                                @else
                                                                    Unpaid
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Address</b><br>{{ $delivery_info->full_address }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($orders_received))
                                        <div class="m-portlet__foot" id="m_foot_orders_received">
                                            <button id="btnReadMoreReceived" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Read more</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Item-->

            <!--begin::Item-->
            <div class="m-accordion__item m-accordion__item--primary">
                <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_2_head" data-toggle="collapse" href="#m_accordion_1_item_2_body" aria-expanded="false">
                    <span class="m-accordion__item-title">Confirm <span class="text-danger">({{ $count_confirm }})</span></span>
                    <span class="m-accordion__item-mode"></span>
                </div>

                <div class="m-accordion__item-body collapse" id="m_accordion_1_item_2_body" role="tabpanel" aria-labelledby="m_accordion_1_item_2_head" data-parent="#m_accordion_1">
                    <div class="m-portlet m-portlet--tabs">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-tools">
                                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a id="m_c_tag_accepted" class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_2_1" role="tab" aria-selected="true">
                                            <i class="la la-check"></i> Admin Accepted <span id="m_count_admin" class="text-danger">({{ count($orders_admin_accepted) }})</span>
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a id="m_c_tag_accepted" class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_2_2" role="tab" aria-selected="true">
                                            <i class="la la-check"></i> Accepted <span id="m_count_accepted" class="text-danger">({{ count($orders_accepted) }})</span>
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a id="m_c_tag_rejected" class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_2_3" role="tab" aria-selected="false">
                                            <i class="la la-close"></i> Rejected <span id="m_count_rejected" class="text-danger">({{ count($orders_rejected) }})</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body" id="m_confirm">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="m_tabs_2_1" role="tabpanel">
                                    <div class="m-portlet__body" id="m_content_orders_admin">
                                        @foreach($orders_admin_accepted as $admin_accepted)
                                            @php
                                                $customer_info = \App\Models\OrderCustomerInfo::where('order_id','=',$admin_accepted->id)->firstOrFail();
                                                $delivery_info = \App\Models\OrderDeliveryInfo::where('order_id','=',$admin_accepted->id)->firstOrFail();
                                                $province = \App\Models\Province::find($delivery_info->province_id);
                                                $district = \App\Models\District::find($delivery_info->district_id);
                                            @endphp
                                            <div class="m-demo">
                                                <div class="m-demo__preview">
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Time</b><br>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $admin_accepted->created_at)->format('H:i') }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Customer</b><br>{{ $customer_info->full_name }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>City</b><br>{{ $province->name_en }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Total</b><br>{{ $admin_accepted->totalAmountVND() }}
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Order Number</b><br><a href="{{ \Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders/'. $admin_accepted->id) : url('admin/orders/'.$admin_accepted->id) }}">{{ $admin_accepted->order_number }}</a>
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Phone</b><br>{{ $customer_info->phone }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>District</b><br>{{ $district->name_en ?? "" }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Paid/Unpaid</b><br><span class="m-badge m-badge--danger m-badge--wide">
                                                                @if($admin_accepted->payment_method == 'online_payment')
                                                                    Paid
                                                                @else
                                                                    Unpaid
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Address</b><br>{{ $delivery_info->full_address }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($orders_admin_accepted))
                                        <div class="m-portlet__foot" id="m_foot_orders_admin">
                                            <button id="btnReadMoreAdmin" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Read more</button>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane" id="m_tabs_2_2" role="tabpanel">
                                    <div class="m-portlet__body" id="m_content_orders_accepted">
                                        @foreach($orders_accepted as $accepted)
                                            @php
                                                $customer_info = \App\Models\OrderCustomerInfo::where('order_id','=',$accepted->id)->firstOrFail();
                                                $delivery_info = \App\Models\OrderDeliveryInfo::where('order_id','=',$accepted->id)->firstOrFail();
                                                $province = \App\Models\Province::find($delivery_info->province_id);
                                                $district = \App\Models\District::find($delivery_info->district_id);
                                            @endphp
                                            <div class="m-demo">
                                                <div class="m-demo__preview">
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Time</b><br>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $accepted->created_at)->format('H:i') }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Customer</b><br>{{ $customer_info->full_name }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>City</b><br>{{ $province->name_en }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Total</b><br>{{ $accepted->totalAmountVND() }}
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Order Number</b><br><a href="{{\Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders/'. $accepted->id) : url('admin/orders/'.$accepted->id) }}">{{ $accepted->order_number }}</a>
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Phone</b><br>{{ $customer_info->phone }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>District</b><br>{{ $district->name_en ?? "" }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Paid/Unpaid</b><br><span class="m-badge m-badge--danger m-badge--wide">
                                                                @if($accepted->payment_method == 'online_payment')
                                                                    Paid
                                                                @else
                                                                    Unpaid
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Address</b><br>{{ $delivery_info->full_address }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($orders_accepted))
                                        <div class="m-portlet__foot" id="m_foot_orders_accepted">
                                            <button id="btnReadMoreAccepted" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Read more</button>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane" id="m_tabs_2_3" role="tabpanel">
                                    <div class="m-portlet__body" id="m_content_orders_rejected">
                                        @foreach($orders_rejected as $rejected)
                                            @php
                                                $customer_info = \App\Models\OrderCustomerInfo::where('order_id','=',$rejected->id)->firstOrFail();
                                                $delivery_info = \App\Models\OrderDeliveryInfo::where('order_id','=',$rejected->id)->firstOrFail();
                                                $province = \App\Models\Province::find($delivery_info->province_id);
                                                $district = \App\Models\District::find($delivery_info->district_id);
                                            @endphp
                                            <div class="m-demo">
                                                <div class="m-demo__preview">
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Time</b><br>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rejected->created_at)->format('H:i') }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Customer</b><br>{{ $customer_info->full_name }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>City</b><br>{{ $province->name_en }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Total</b><br>{{ $rejected->totalAmountVND() }}
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Order Number</b><br><a href="{{\Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders/'. $rejected->id) : url('admin/orders/'.$rejected->id) }}">{{ $rejected->order_number }}</a>
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Phone</b><br>{{ $customer_info->phone }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>District</b><br>{{ $district->name_en ?? "" }}
                                                        </div>
                                                        <div class="m-stack__item">
                                                            <b>Paid/Unpaid</b><br><span class="m-badge m-badge--danger m-badge--wide">
                                                                @if($rejected->payment_method == 'online_payment')
                                                                    Paid
                                                                @else
                                                                    Unpaid
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="m--space-15"></div>
                                                    <div class="m-stack m-stack--ver m-stack--general">
                                                        <div class="m-stack__item">
                                                            <b>Address</b><br>{{ $delivery_info->full_address }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($orders_rejected))
                                        <div class="m-portlet__foot" id="m_foot_orders_rejected">
                                            <button id="btnReadMoreRejected" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Read more</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Item-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        $(document).ready(function () {
            let base_url_orders = "{{\Session::has('res') ? url('/admin/'.$res->res_Slug) : url('/admin/') }}";
            let num_new = num_received = num_admin = num_accepted = num_rejected = 1;
            // new
            $('#btnReadMoreNew').click(function () {
                if($('#m_content_orders_new').children().hasClass("d-none")) {
                    $('#m_content_orders_new').children().removeClass("d-none");
                    $('#m_foot_orders_new').css('display','none');
                } else {
                    $('#m_foot_orders_new').css('display','none');
                }
            });

            // received
            $('#btnReadMoreReceived').click(function () {
                mApp.blockPage({overlayColor:"#000000",type:"loader",state:"success",message:"Please wait..."});
                $.ajax({
                    url: base_url_orders + '/get-orders?status=1&offset='+ (num_received * 5)
                }).done(function (data) {
                    num_received += 1;
                    mApp.unblockPage();
                    if(data.data) {
                        let count = parseInt($('#m_count_received').html()[1]);
                        $('#m_count_received').html(`(${count + data.count})`);
                        let m_content_orders_received = $('#m_content_orders_received');
                        m_content_orders_received.html(m_content_orders_received.html() + data.data);
                    }
                    if(data.count < 5) {
                        $('#m_foot_orders_received').css('display','none');
                    }
                }).fail(function (errorCode,statusText) {
                    // error
                    mApp.unblockPage();
                });
            });

            // admin
            $('#btnReadMoreAdmin').click(function () {
                mApp.blockPage({overlayColor:"#000000",type:"loader",state:"success",message:"Please wait..."});
                $.ajax({
                    url: base_url_orders + '/get-orders?status=2&offset='+ (num_admin * 5)
                }).done(function (data) {
                    num_admin += 1;
                    mApp.unblockPage();
                    if(data.data) {
                        let count = parseInt($('#m_count_admin').html()[1]);
                        $('#m_count_admin').html(`(${count + data.count})`);
                        let m_content_orders_admin = $('#m_content_orders_admin');
                        m_content_orders_admin.html(m_content_orders_admin.html() + data.data);
                    }
                    if(data.count < 5) {
                        $('#m_foot_orders_admin').css('display','none');
                    }
                }).fail(function (errorCode,statusText) {
                    // error
                    mApp.unblockPage();
                });
            });

            // accepted
            $('#btnReadMoreAccepted').click(function () {
                mApp.blockPage({overlayColor:"#000000",type:"loader",state:"success",message:"Please wait..."});
                $.ajax({
                    url: base_url_orders + '/get-orders?status=3&offset='+ (num_accepted * 5)
                }).done(function (data) {
                    num_accepted += 1;
                    mApp.unblockPage();
                    if(data.data) {
                        let count = parseInt($('#m_count_accepted').html()[1]);
                        $('#m_count_accepted').html(`(${count + data.count})`);
                        let m_content_orders_accepted = $('#m_content_orders_accepted');
                        m_content_orders_accepted.html(m_content_orders_accepted.html() + data.data);
                    }
                    if(data.count < 5) {
                        $('#m_foot_orders_accepted').css('display','none');
                    }
                }).fail(function (errorCode,statusText) {
                    // error
                    mApp.unblockPage();
                });
            });

            // rejected
            $('#btnReadMoreRejected').click(function () {
                mApp.blockPage({overlayColor:"#000000",type:"loader",state:"success",message:"Please wait..."});
                $.ajax({
                    url: base_url_orders + '/get-orders?status=4&offset='+ (num_rejected * 5)
                }).done(function (data) {
                    num_rejected += 1;
                    mApp.unblockPage();
                    if(data.data) {
                        let count = parseInt($('#m_count_rejected').html()[1]);
                        $('#m_count_rejected').html(`(${count + data.count})`);
                        let m_content_orders_rejected = $('#m_content_orders_rejected');
                        m_content_orders_rejected.html(m_content_orders_rejected.html() + data.data);
                    }
                    if(data.count < 5) {
                        $('#m_foot_orders_rejected').css('display','none');
                    }
                }).fail(function (errorCode,statusText) {
                    // error
                    mApp.unblockPage();
                });
            });
        });
    </script>
@endsection