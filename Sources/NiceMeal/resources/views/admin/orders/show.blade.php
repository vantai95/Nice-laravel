@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="card px-2">
                <div class="card-body">
                    <div class="container-fluid text-center">
                        <h3 >#{{ $order->order_number }}</h3>
                        <p> Check out time : {{ $order->created_at }}</p>
                        <hr>
                    </div>    
                    <div class="row justify-content-center status-bar mb-3">                       
                            @php
                                $is_new = $is_received = $is_waiting_admin_accepted = $is_waiting_kitchen_accepted = $is_admin_accepted = $is_accepted = $is_rejected = $is_finished = $is_canceled = false;
                                switch ($order->status) {
                                    case 0:
                                        $is_new = true;
                                    break;
                                    case 1:                                        
                                        $is_new = $is_received = $is_waiting_admin_accepted = true;                                        
                                    break;
                                    case 2:
                                        $is_new = $is_received = $is_admin_accepted = $is_waiting_kitchen_accepted = true;
                                    break;
                                    case 3:
                                        $is_new = $is_received = $is_admin_accepted = $is_accepted = true;
                                    break;
                                    case 4:
                                        $is_new = $is_received  = $is_rejected = true;
                                    break;
                                    case 5:
                                        $is_new = $is_received = $is_admin_accepted = $is_accepted = true;
                                    break;
                                    case 6:
                                        $is_new = $is_received = $is_admin_accepted = $is_accepted = true;
                                    break;
                                    case 7:
                                        $is_new = $is_received = $is_admin_accepted = $is_accepted = $is_finished = true;
                                    break;
                                    default:
                                        $is_new = $is_received = $is_admin_accepted = $is_canceled = true;
                                        if($order->kitchen_accepted){
                                            $is_accepted = true;
                                        }
                                    break;
                                }
                            @endphp
                           
                            <button
                                    @if($is_new)
                                    type="button"
                                    class="btn btn-sm m-btn--pill m-btn--air @if($order->status === 0) btn-info @else btn-success @endif"
                                    @else
                                    type="button"
                                    class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                    @endif
                            >
                                New 
                            </button>
                            <button
                                    @if($is_received)
                                    class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                    @else
                                    class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-metal"
                                    @endif
                                    style="border: 0px;"
                            >
                                <span class="fa fa-angle-double-right"></span>
                            </button>
                           
                            <button
                                    type="button"
                                    @if($is_received)
                                    class="btn btn-sm m-btn--pill m-btn--air @if($order->status === 1) btn-success @else btn-success @endif"
                                    @else
                                    class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                    @endif
                            >
                                Received
                            </button>
                            @if($is_received && $order->status < 2)
                            <button
                                    @if($is_waiting_admin_accepted)
                                    class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                    @else
                                    class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-metal"
                                    @endif
                                    style="border: 0px;"
                            >
                                <span class="fa fa-angle-double-right"></span>
                            </button>
                            <button
                                    type="button"
                                    id="btnConfirm"
                                    @if($is_waiting_admin_accepted)
                                    class="btn btn-sm m-btn--pill m-btn--air @if($order->status <= 2) btn-info @else btn-success @endif"
                                    @else
                                    class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                    @endif
                            >
                            Waiting Admin Accept
                            </button>
                            @endif

                            @if($is_admin_accepted)
                                <button class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                    style="border: 0px;">
                                        <span class="fa fa-angle-double-right"></span>
                                </button>
                                <button type="button"                                
                                        class="btn btn-sm m-btn--pill m-btn--air btn-success btn">                                
                                        Admin Accepted
                                    </button>
                            @endif
                            @if($is_waiting_kitchen_accepted)
                                <button class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                    style="border: 0px;">
                                        <span class="fa fa-angle-double-right"></span>
                                </button>
                                <button type="button"
                                        class="btn btn-sm m-btn--pill m-btn--air  btn-info">
                                        Waiting Kitchen Accept
                                    </button>
                            @endif
                            @if($is_accepted)
                                <button class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                    style="border: 0px;">
                                        <span class="fa fa-angle-double-right"></span>
                                </button>
                                <button type="button"
                                        class="btn btn-sm m-btn--pill m-btn--air btn-success btnCancel">
                                    Accepted 
                                </button>
                                @if($order->status == 3)
                                    <button class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                        style="border: 0px;">
                                            <span class="fa fa-angle-double-right"></span>
                                    </button>
                                    <button type="button"
                                            class="btn btn-sm m-btn--pill m-btn--air">
                                        Finish
                                    </button>
                                @endif
                            @endif
                            @if($is_rejected)                           
                                    <button
                                            @if($is_rejected)
                                            class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                            @else
                                            class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-metal"
                                            @endif
                                            style="border: 0px;"
                                    >
                                        <span class="fa fa-angle-double-right"></span>
                                    </button>
                                    <button
                                            type="button"
                                            @if($is_rejected)
                                            class="btn btn-sm m-btn--pill m-btn--air @if($order->status === 4) btn-info @else btn-metal @endif"
                                            @else
                                            class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                            @endif
                                    >
                                        Rejected
                                    </button>                           
                            @endif
                            @if($is_canceled)                           
                                    <button class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                            style="border: 0px;"
                                    >
                                        <span class="fa fa-angle-double-right"></span>
                                    </button>
                                    <button
                                            type="button"
                                            class="btn btn-sm m-btn--pill m-btn--air btn-info "
                                            
                                    >
                                    Canceled
                                    </button>                           
                            @endif
                    </div>
                        
                    <div class="row">
                       
                        <div class="col-lg-4">
                            <h5 class="mt-3">Contact info</h5>
                            <p>Customer: Mr/Ms. {{ $order_customer_info->full_name }}</p>
                            <p>OTP Verified : <span class="m-badge @if(is_null($order->otp_verified)) m-badge--danger @else m-badge--success @endif m-badge--wide">@if(is_null($order->otp_verified)) Not Verified @else Verified @endif</span></p>
                            <p>Previous Order: <b>{{$previos_order}}</b></p>
                            <p>Customer note: <b>{{ $order->notes }}</b></p>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="mt-3">Delivery Info</h5>       
                            @if($order_delivery_info->ward_id !='')                     
                            <p>Address: <b>{{$order_delivery_info->full_address.', '}}{{ App\Models\Ward::find($order_delivery_info->ward_id)->type_en }} {{ App\Models\Ward::find($order_delivery_info->ward_id)->name_en }}, {{ App\Models\District::find($order_delivery_info->district_id)->type_en }} {{ App\Models\District::find($order_delivery_info->district_id)->name_en }},
                                <br> {{ App\Models\Province::find($order_delivery_info->province_id)->type_en }} {{ App\Models\Province::find($order_delivery_info->province_id)->name_en }}.</b></p>                            
                            @endif
                            <p>Delivery note: <b>{{ $order->direction }}</b></p>
                            <p class="text-left mb-2">Delivery Time: <b>{{ $order->final_delivery_time }}</b></p> 
                            
                        </div>
                        
                        <div class="col-lg-4">
                            <h5 class="mt-3">Order note</h5>
                            <p>Request Time: <b>{{ $order->created_at }}</b></p>
                            @if($order->payment_method == "cod_payment")
                            <p>Payment Amount: <b>
                                @if($order->amount_user_have>0)
                                    {{ number_format($order->amount_user_have,0) }} VNĐ
                                @endif
                            </b></p> 
                            @endif
                            <p>Payment Status: <b> @if($order->payment_method == "online_payment") Paid  @else Order not paid @endif </b></p>
                            <p>Order request: <b>{{$order->order_type}}</b></p>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-lg-12"><h5>Order detail</h5></div>
                        <div class="table-responsive w-100">
                            <table class="table">
                                <thead>
                                <tr class="bg-dark text-white">
                                    <th>#</th>
                                    <th>Dish name</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order_items as $key => $item)
                                    <tr class="text-right">
                                        <td class="text-left">{{ $key + 1 }}</td>
                                        <td class="text-left" style="line-height: 10px;">
                                            @php
                                                $item_cost = 0;
                                                $item_cost += $item->price;
                                            @endphp
                                            <p>{{ $item->name_en }} ({{ $item->quantity }} * {{ \App\Services\CommonService::formatPriceVND($item_cost) }}) <b>{{ ($item->free_item == 1) ? ' - Free Item' : '' }}</b></p>
                                            <hr/>
                                            @if($order_items_customization->count() > 0 && $item->free_item == 0)
                                                @isset($order_items_customization[$item->id])
                                                    @foreach($order_items_customization[$item->id] as $custom_key => $item_custom)
                                                        <p>{{ $item_custom->first()->custom_name }} : </p>
                                                        @foreach($order_items_customization[$item->id][$custom_key] as $option_key => $item_option)
                                                            @php
                                                                $item_cost += $item_option->price * $item_option->quantity;
                                                            @endphp
                                                            
                                                            <p>- {{$item_option->option_name}} : 
                                                                {{ $item_option->quantity }}   
                                                                x {{ ($item_option->price != 0) ? \App\Services\CommonService::formatPriceVND($item_option->price) : $item_option->price." VNĐ" }}
                                                            </p>
                                                        @endforeach
                                                    @endforeach
                                                @endisset
                                            @endif
                                        </td>
                                       
                                        <td>{{ number_format($item_cost * $item->quantity,0) }} VNĐ</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">                               
                            <p>Admin note: </p>                    
                            <div class="form-group">
                                <textarea class="form-control" id="admin-order-note" cols="100" rows="5">{{ $order->admin_order_note }}</textarea>
                                <button type="button" onclick="saveAdminNote()" class="btn btn-primary float-right mt-4 ml-2">Save note</button>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <p class="text-right mb-2">Sub - Total amount: {{CommonService::formatPriceVND($order->sub_total_amount) }}</p>
                            @if($order->discount > 0)
                            <p class="text-right mb-2">Promotion: {{CommonService::formatPriceVND($order->discount) }}</p>
                            @endif
                            @if($order->tax_type != '')
                            <p class="text-right mb-2">Tax({{$order->tax_rate}}%): {{CommonService::formatPriceVND($order->tax)}}</p>
                            @endif
                            <p class="text-right">Shipping Fee: {{CommonService::formatPriceVND($order->shipping_fee) }}</p>
                            <h4 class="text-right mb-5">Total : {{ $order->totalAmountVND() }}</h4>
                        </div>
                        <hr>
                    </div>
                    <div class="container-fluid w-100">
                        @if($order->status==2)
                        <div data-toggle="modal" data-target="#ResendOrderconfirm" class="btn btn-outline-primary m-btn m-btn--icon mt-4">
                            <span>
                                <i class="fa fa-file"></i>
                                <span>Resend Order to Printer</span>
                            </span>
                        </div>
                        @endif
                        <div data-toggle="modal" data-target="#Callconfirm" class="btn btn-outline-primary m-btn m-btn--icon mt-4">
                            <span>
                                <i class="fa fa-phone"></i>
                                <span>Call</span>
                            </span>
                        </div>
                        <div data-toggle="modal" data-target="#Mailconfirm" class="btn btn-outline-primary m-btn m-btn--icon mt-4">
                            <span>
                                <i class="fa fa-envelope"></i>
                                <span>Mail</span>
                            </span>
                        </div>
                        <div data-toggle="modal" data-target="#SMSconfirm" class="btn btn-outline-primary m-btn m-btn--icon mt-4">
                            <span>
                                <i class="fa fa-comment"></i>
                                <span>SMS</span>
                            </span>
                        </div>
                        <a href="{{ \Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders') : url('admin/orders') }}" class="btn btn-default float-right mt-4">
                            Back to list
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.orders.confirm_popup')
    @include('admin.orders.accept_popup')
    @include('admin.orders.reject_popup')
    @include('admin.orders.cancel_popup')
    @include('admin.orders.sms_popup',['phone'=>$order_customer_info->phone])
    @include('admin.orders.mail_popup',['mail'=>$order_customer_info->email])
    @include('admin.orders.call_popup',['phone'=>$order_customer_info->phone])
    @include('admin.orders.resendorder_popup')
@endsection

@section('extra_scripts')
    @include('admin.orders.script')
@endsection
