<div style="border: 3px dashed #ed792c; padding: 0 15px 0 15px;color: black;font-size: 18px">
    <div style="margin-top: -15px;">
        <h1 style="color: red;border-bottom: 1px solid #7c9bd6">NiceMeal.com</h1>
    </div>
    <div style=" font-size: 14px;margin-top: 15px;">
        @if(!$sendToAdmin)
            <p>Hello Sir/Madam</p>
            <p>The order <span style=" text-decoration: underline;font-weight: bold; font-size: 18px">{{$order->order_number}}</span>
                cancelled by <span style=" text-decoration: underline;font-weight: bold; font-size: 18px">{{$restaurant->name_en}}</span>
                restaurant</p>
            <p>Reason: <b style="font-size:18px">{{$data['reject_reason']}}</b></p>
            <p>Please try to <a href="{{$orderLink}}" style="text-decoration: none">
                    <button style=" width: 24%;
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 16px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                        Order Again
                    </button>
                </a> for a nice meal!!!
            </p>
        @else
            <p>Hello Restaurant</p>
            <p>The order <span
                        style=" text-decoration: underline;font-weight: bold; font-size: 16px">{{$order->order_number}}</span>
                has been rejected</p>
            <p>Reason: <b style="font-size:18px">{{$data['reject_reason']}}</b></p>
        @endif
        <div style="margin-top: 30px;">
            <h2 style="border-bottom: 1px solid #7c9bd6;border-top: 1px solid #7c9bd6;">Support Contact:</h2>
        </div>
        <p><span style="color:red;font-weight: bold">Email: </span>{{ $restaurant->email }}</p>
        <p><span style="color:red;font-weight: bold">Phone number: </span>{{ $restaurant->phone }}</p>
    </div>
</div>
<div style="margin-top: 10px;overflow-x:auto;">
    <table >
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
            <th style="text-align: left; display: none">
                <button style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 16px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                    Download App
                </button>
            </th>
            <th style="text-align: left; display: none">
                <button style="
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
<p style="text-align: center;font-size: 16px;">&copy; 2019 NiceMeal.com</p>
