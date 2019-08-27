<div style="border: 3px dashed #ed792c; padding: 0 15px 0 15px;color: black;font-size: 18px">
    <div style="margin-top: -15px;">
        @if($isTakeawayDomain)
        <h1 style="color: red;border-bottom: 1px solid #7c9bd6">VnTakeaway.com</h1>
        @else
        <h1 style="color: red;border-bottom: 1px solid #7c9bd6">NiceMeal.com</h1>
        @endif
    </div>
    <div style=" font-size: 14px;margin-top: 15px;">
        <p>Hello Sir/Madam</p>
        @if($isTakeawayDomain)
        <p>Welcome to VnTakeaway.com</p>
        @else        
        <p>Welcome to NiceMeal.com</p>
        @endif
        <p>Now you can login to your account by:</p>
        <p>Email: <span style="text-decoration: underline;color: blue;">{{$userInfo->email}}</span></p>
        {!! Form::open(['method' => 'POST','url' => ['/active-account/'.$accountToken]]) !!}
            <p>Please
                <button type="submit" style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 16px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">Active
                </button>
                your account to enjoy with us,
            </p>
            <p>Many thanks and have a NiceMeal</p>
            
        {!! Form::close() !!}
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
@if($isTakeawayDomain)
    <p style="text-align: center;font-size: 16px;">&copy; 2019 VnTakeaway.com</p>
@else
    <p style="text-align: center;font-size: 16px;">&copy; 2019 NiceMeal.com</p>
@endif