@extends('layouts.content_only')
@section('content')

    <div class="mg-t-100">
        <!-- your-location -->
        <div class="md-tb">
            <div class="md-tb__cell">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="your-location__inner">
                                <div class="your-location__logo">
                                    <a href="#"><img src="/b2c-assets/img/logox2.png" alt=""></a>
                                </div>
                            </div>
                            <div class="your-location__inner">
                                <h5>Order Number: {{$order->order_number}}</h5>
                            </div>
                            @if(strtotime($order->token_expired) > time())
                                @if($order->status == 0 || $order->status == 1)
                                    {!! Form::open(['method'=>'post','url' => '/change-to-accept/'.$order->token]) !!}
                                    <div class="your-location__inner form-group row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-2">
                                            <h6>Time</h6>
                                        </div>
                                        <div class="col-lg-5" id="picker_section">
                                            {!! Form::text('confirm_time', null, ['class' => 'timepicker form-control ','id' => 'confirm_time']) !!}
                                        </div>
                                    </div>
                                    <div class="your-location__inner form-group row">
                                        <div class="col-lg-12 ml-lg-auto">
                                            {!! Form::submit('Confirm', ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                                            <a href="{{url('/')}}" class="btn btn-default">Back</a>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                @elseif($order->status == 2)
                                    <div class="your-location__inner">
                                        <h6>This order has been confirmed
                                            at: {{date('d-m-Y H:i', strtotime($order->admin_accepted_at))}}</h6>
                                        <h6>Time
                                            confirmed: {{date('H:i', strtotime($order->confirm_delivery_time))}}</h6>
                                    </div>
                                    <div class="your-location__inner form-group row">
                                        <div class="col-lg-12 ml-lg-auto">
                                            <a href="{{url('/')}}" class="btn btn-default">Back</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="your-location__inner">
                                        <h6>This order has been accepted</h6>
                                    </div>
                                    <div class="your-location__inner form-group row">
                                        <div class="col-lg-12 ml-lg-auto">
                                            <a href="{{url('/')}}" class="btn btn-default">Back</a>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="your-location__inner">
                                    <h6>Token has been expired</h6>
                                </div>
                                <div class="your-location__inner form-group row">
                                    <div class="col-lg-12 ml-lg-auto">
                                        <a href="{{url('/')}}" class="btn btn-default">Back</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End / your-location -->

        @include('user.social-tools')

    </div>

@endsection

@section('extra_scripts')
    <script>
        $('.timepicker').timepicker({
            format: 'HH:mm',
            showMeridian: false,
            minuteStep: 1,
        });
    </script>
@endsection
