<div style="border: 3px dashed #ed792c; padding: 0 15px 0 15px;color: black;font-size: 18px">
    <div style="margin-top: -15px;">
        <h1 style="color: red;border-bottom: 1px solid #7c9bd6">NiceMeal.com</h1>
    </div>
    <div style=" font-size: 14px;margin-top: 15px;">
        <p>Hello Restaurant</p>
        <p>We have new review for the order <span style=" text-decoration: underline;font-weight: bold; font-size: 18px">{{$orderData->order_number}}</span>
            for <span style=" text-decoration: underline;font-weight: bold; font-size: 18px">{{$resData->name_en}}</span> restaurant
        </p>
        <div style="margin-top: 10px;">
            <h2 style="border-bottom: 1px solid #7c9bd6;border-top: 1px solid #7c9bd6;">Review Detail:</h2>
        </div>
        <p><b>Customer: Mr/Ms:</b>{{$userData->full_name}}</p>
        <p>
            <b>Food quantity:
                @if(round($reviewData->food_rate) == 1)
                    <span style="color:#FFC600;font-size: 16px;">&#9733;</span>
                @elseif(round($reviewData->food_rate) == 2)
                    <span style="color:#FFC600;font-size: 16px;">&#9733;&#9733;</span>
                @elseif(round($reviewData->food_rate) == 3)
                    <span style="color:#FFC600;font-size: 16px;">&#9733;&#9733;&#9733;</span>
                @elseif(round($reviewData->food_rate) == 4)
                    <span style="color:#FFC600;font-size: 16px;">&#9733;&#9733;&#9733;&#9733;</span>
                @else
                    <span style="color:#FFC600;font-size: 16px;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                @endif
            </b>
        </p>
        <p>
            <b>Service quantity:
                @if(round($reviewData->service_rate) == 1)
                    <span style="color:#FFC600;font-size: 16px;">&#9733;</span>
                @elseif(round($reviewData->service_rate) == 2)
                    <span style="color:#FFC600;font-size: 16px;">&#9733;&#9733;</span>
                @elseif(round($reviewData->service_rate) == 3)
                    <span style="color:#FFC600;font-size: 16px;">&#9733;&#9733;&#9733;</span>
                @elseif(round($reviewData->service_rate) == 4)
                    <span style="color:#FFC600;font-size: 16px;">&#9733;&#9733;&#9733;&#9733;</span>
                @else
                    <span style="color:#FFC600;font-size: 16px;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                @endif
            </b>
        </p>
        <p><b>Comment:</b>{{!empty($reviewData->comment) ? $reviewData->comment : 'No comment'}}</p>
        <p>All of reivews will be uploaded on website after 24 hours automatically.</p>
        <div style="margin-top: 5px">
            {!! Form::open(['method' => 'GET','url' => [$confirmLink]]) !!}
            <p>If review is ok please
                    <button type="submit" style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 14px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                        Confirmed
                    </button>
                to upload it on website
            </p>
            {!! Form::close() !!}
        </div>
        <div style="margin-top: 5px;">
            {!! Form::open(['method' => 'GET','url' => [$problemSolveLink]]) !!}
            <p>If you have good solution to make it better, please contact with customer and then,
                You can send request to change the review status by click on
                    <button type="submit" style="
                        background: #E76715;
                        color: white;
                        border: none;
                        font-size: 14px;font-weight: bold;
                        text-transform: uppercase; padding-top:10px;padding-bottom: 10px">
                        Problem Solved
                    </button>
            {!! Form::close() !!}
            </p>
            <p>Please discuss and try to solve problem togher for become better day by day.</p>
            <p>Many thanks and good luck at all.</p>
        </div>
        <div style="margin-top: 20px;">
            <h2 style="border-bottom: 1px solid #7c9bd6;border-top: 1px solid #7c9bd6;">Support Contact:</h2>
        </div>
        <p><span style="color:red;font-weight: bold">Email: </span>{{$resData->email}}</p>
        <p><span style="color:red;font-weight: bold">Phone number: </span>{{$resData->phone}}</p>
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
<p style="text-align: center; font-size:16px">&copy; 2019 NiceMeal.com</p>
