<div style="border: 3px dashed #ed792c; padding: 0 15px 0 15px;color: black;font-size: 16px">
    <div style="margin-top: -15px">
        <h1 style="color: red;border-bottom: 1px solid #7c9bd6">NiceMeal.com</h1>
    </div>
    <div style=" font-size: 14px;margin-top: 15px;">
        <p>Hello Restaurant</p>
        <p>The order <span style=" text-decoration: underline;font-weight: bold; font-size: 18px">{{$orderNumb}}</span>
            placed from <span style=" text-decoration: underline;font-weight: bold; font-size: 18px">{{$restaurant->name_en}}</span>
            restaurant</p>
        <p>Total bill: <b style="font-size:18px">{{ $order->totalAmountVND() }}</b></p>
        <p>Payment Status: <b style="font-size:18px">{{ ($order->payment_method == 'cod_payment') ? "Order not paid" : "Order paid" }}</b></p>
        <div style="margin-top:20px">
            <h2 style="border-bottom: 1px solid #7c9bd6;border-top: 1px solid #7c9bd6;">Customer Info</h2>
        </div>
        <p><b>Mr/Ms: </b><span style=" text-decoration: underline;font-weight: bold;">{{ $order_customer_info->full_name }}</span></p>
        <p><b>Previous order: {{$previousOrder > 0 ? $previousOrder : 'No order'}}</b></p>
        <div style="margin-top: 5px;overflow-x:auto;">
            <table style="overflow-x:auto;">
                <tr>
                    <th style="text-align: left">
                        <a href=""><button style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 14px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                                Phone Call
                            </button></a>
                    </th>
                    <th style="text-align: left">
                        <a href=""> <button style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 14px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px;">
                                Send Email
                            </button></a>
                    </th>
                    <th style="text-align: left">
                        <a href=""> <button style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 14px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px;">
                                Text Message
                            </button></a>
                    </th>
                    <th>

                    </th>
                </tr>
            </table>
        </div>
        <div style="margin-top:15px">
            <h2 style="border-bottom: 1px solid #7c9bd6;border-top: 1px solid #7c9bd6;">Delivery Info</h2>
        </div>
        <p>Address:
            {{ $order_delivery_info->full_address }},
            @if(!isset($order_delivery_info->district_id))
            {{ App\Models\Ward::find($order_delivery_info->ward_id)->type_en }} {{ App\Models\Ward::find($order_delivery_info->ward_id)->name_en }}, {{ App\Models\District::find($order_delivery_info->district_id)->type_en }} {{ App\Models\District::find($order_delivery_info->district_id)->name_en }},
            {{ App\Models\Province::find($order_delivery_info->province_id)->type_en }} {{ App\Models\Province::find($order_delivery_info->province_id)->name_en }}.
            @endif
        </p>
        <p>Direction: {{$order->direction}}</p>
        <div style="margin-top:15px">
            <h2 style="border-bottom: 1px solid #7c9bd6;border-top: 1px solid #7c9bd6;">Order Note</h2>
        </div>
        <p><b>Request time: {{!empty($order->delivery_time) ? date('d-m-Y H:i', strtotime($order->delivery_time)) : 'As soon as possible'}}</b></p>
        <p><b>Bring the change for: </b></p>
        <p><b>Order request: {{$order->notes}}</b></p>
        @if($sendToAdmin==true)
        <div style="margin-top: 5px;overflow-x:auto;">
            <table style="overflow-x: auto ">
                <tr>
                    <th style="text-align: left">
                        <a href="{{$confirmLink}}"><button style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 14px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                            Accept Order
                        </button></a>
                    </th>
                    <th style="text-align: left">
                        <a href="{{$rejectLink}}"> <button style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 14px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px;">
                            Reject Order
                        </button></a>
                    </th>
                    <th style="text-align: left">
                        <button style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 14px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px;display:none">
                            Renew Order
                        </button>
                    </th>
                    <th>

                    </th>
                </tr>
            </table>
        </div>
        @endif
        <div style="margin-top:30px">
            <h2 style="border-bottom: 1px solid #7c9bd6;border-top: 1px solid #7c9bd6;">Order Detail:</h2>
        </div>
        <p>
            <table style="width:100%;border-collapse: collapse; color:black">
                @foreach($order_items as $key => $item)
                    <tr>
                        <td style="width: 75%;text-align: left;padding-bottom: 0">
                            <span>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ App\Models\Dish::find($item->dish_id)->name_en }}: X{{$item->quantity}}</span>
                            @php
                                $items_customizations = array();
                                if($item->have_customization) {
                                    $items_customizations = App\Models\OrderItemCustomization::where('order_id','=',$order->id)->where('order_item_id',$item->id)->get();
                                }
                            @endphp
                            @foreach($items_customizations as $index => $value)
                                @php
                                    $customizations =  App\Models\Customization::where("id",$value->customization_id)->get();
                                @endphp
                                @foreach($customizations as $i => $customization)

                                    @if($value->customization_option_id>0)
                                        @php
                                        $customizationOptions = App\Models\CustomizationOption::where("customization_id",$value->customization_id)->where("id",$value->customization_option_id)->get();
                                        @endphp

                                        @foreach($customizationOptions as $j => $customizationOption)
                                            <p style="color:black; text-indent: 25px">+ {{ $customizationOption->name_en }} - {{ number_format($value->price,0) }} VNĐ</p>
                                        @endforeach
                                    @else
                                        <span>{{ $customization->name_en }} - {{ number_format($customization->price,0) }} VNĐ</span>

                                    @endif

                                @endforeach

                            @endforeach
                        </td>
                        {{--<td style="width: 25%;text-align: left">{{ number_format($item->price,0) }} VNĐ</td>--}}
                        {{--<td>{{ $item->quantity }}</td>--}}
                        <td  style="width: 17%;text-align: left;vertical-align: top">{{ number_format($item->price * $item->quantity,0) }} VNĐ</td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold">
                    <td style="width: 25%;text-align: left;border-top: 2px solid black;padding: 25px 0 5px 20px">Sub Total:</td>
                    <td style="width: 25%;text-align: left;border-top: 2px solid black; padding-top: 17px;"> {{CommonService::formatPriceVND($order->sub_total_amount) }}</td>
                </tr>
                @if($order->discount > 0)
                    <tr style="font-weight: bold">
                        <td style="width: 25%;text-align: left;padding: 5px 0 5px 20px">Promotion:</td>
                        <td style="width: 25%;text-align: left"> {{CommonService::formatPriceVND($order->discount)}}</td>
                    </tr>
                @endif
                <tr style="font-weight: bold">
                    <td style="width: 25%;text-align: left;padding: 5px 0 5px 20px">Tax ({{$order->tax_rate}}%) </td>
                    <td style="width: 25%;text-align: left;">{{CommonService::formatPriceVND($order->tax)}}</td>
                </tr>
                <tr style="font-weight: bold">
                    <td style="width: 25%;text-align: left;border-bottom: 2px solid black;padding: 5px 0 25px 20px">Shipping Fee:</td>
                    <td style="width: 25%;text-align: left;border-bottom: 2px solid black; padding-bottom: 17px;"> {{CommonService::formatPriceVND($order->shipping_fee) }}</td>
                </tr>
                <tr style="font-weight: bold">
                    <td style="width: 25%;text-align: left;padding: 5px 0 5px 20px">Final Total:</td>
                    <td style="width: 25%;text-align: left"> {{$order->totalAmountVND()}}</td>
                </tr>
            </table>
        </p>
        <br/>
        <div style="margin-top: 30px;">
            <h2 style="border-bottom: 1px solid #7c9bd6;border-top: 1px solid #7c9bd6;">Support Contact:</h2>
        </div>
        <p><span style="color:red;font-weight: bold">Email: </span>{{ $restaurant->email }}</p>
        <p><span style="color:red;font-weight: bold">Phone number: </span>{{ $restaurant->phone }}</p>
    </div>
</div>
<div style="margin-top: 10px;overflow-x:auto;">
    <table>
        <tr>
            <th style="text-align: left">
                <a href="{{url('/')}}">
                    <button style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 16px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                        Order Food
                    </button>
                </a>
            </th>
            <th style="text-align: left">
                <a href="{{url('contact-us')}}">
                    <button style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 16px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                        Contact Us
                    </button>
                </a>
            </th>
            <th style="text-align: left">
                <button style="
                        display:none;
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 16px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                    Download App
                </button>
            </th>
            <th style="text-align: left">
                <button style="
                        display:none;
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 16px;
                        font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                    Subscribe
                </button>
            </th>
        </tr>
    </table>
</div>
<p style="text-align: center; font-size:16px">&copy; 2019 NiceMeal.com</p>
