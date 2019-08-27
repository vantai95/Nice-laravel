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
                                    {!! Form::open(['method'=>'post','url' => '/change-to-reject/'.$order->token]) !!}
                                    <div class="your-location__inner form-group row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-2">
                                            <h6>Reject Reason</h6>
                                        </div>
                                        <div class="col-lg-5">
                                            <select name="reason" class="form-control" id="reason">
                                                @foreach(\App\Models\OrderRejectReason::select('id','name_en')->get() as $reason)
                                                    <option value="{{ $reason->name_en }}">{{ $reason->name_en }}</option>
                                                @endforeach
                                                <option value="other">Other reason</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="your-location__inner form-group row" id="other_reason_section">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-2">
                                        </div>
                                        <div class="col-lg-5">
                                            {!! Form::text('other_reason', null, ['class' => 'form-control','id' => 'other_reason']) !!}
                                        </div>
                                    </div>
                                    <div class="your-location__inner form-group row">
                                        <div class="col-lg-12 ml-lg-auto">
                                            {!! Form::submit('Confirm', ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                                            <a href="" class="btn btn-default">Cancel</a>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                @elseif($order->status == 3)
                                    <div class="your-location__inner">
                                        <h6>You can not reject this order because of this order has been accepted.</h6>
                                    </div>
                                    <div class="your-location__inner form-group row">
                                        <div class="col-lg-12 ml-lg-auto">
                                            <a href="{{url('/')}}" class="btn btn-default">Back</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="your-location__inner">
                                        <h6>This order has been rejected!</h6>
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
        $('#other_reason_section').hide();
        $('#reason').change(function () {
            var val = $(this).val();
            if (val == "other") {
                $('#other_reason_section').show();
                $('#other_reason').prop("required", true);
            } else {
                $('#other_reason_section').hide();
                $('#other_reason').prop("required", false);
            }
        })
    </script>
@endsection
