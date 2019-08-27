@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row md-content payment-status-page" ng-controller="PaymentCtrl">
            @if ($message = Session::get('success'))
                <div class="w3-panel w3-green w3-display-container">
                    <h6>Your Order <span class="text-danger"> {{ $order->order_number }} </span> is {!! $message !!}.
                      Thank you for ordering</h6>
                    <div>
                        <span class="continue-ordering-text">
                            <a href="/">Continue ordering</a>
                        </span>
                    </div>
                </div>
                <?php Session::forget('success');?>
            @endif

            @if ($message = Session::get('error'))
                <div class="w3-panel w3-red w3-display-container">
                    <p>Your Order <span class="text-danger">{{ $order->order_number }}</span> is cancel
                        because {!! $message !!}</p>
                    <p> Click <a href="/" class="text-danger"><u>here</u></a> to home page</p>
                    <p> Click
                        <button class="btn btn-danger" onclick="rePayment();">Try Again</button>
                        to try payment again
                    </p>
                </div>
                <?php Session::forget('error');?>
            @endif

            <form id="payment_form" method="post" action="/payment/process-payment">
                {{ csrf_field() }}

                <input type="hidden" size="20" value="{{ $orderTransaction->payment_mode }}" name="p_payment_with" id="p_payment_with">                
                <input type="hidden" size="20" value="{{ $order->id }}" name="p_order_id" id="p_order_id">
            </form>
            @if($newOtp || $countOrderOtp)
                @include('user.payment.otp_modal')
            @endif
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script src="/b2c-assets/js/checkout/payment.js"></script>
    <script>
        function rePayment() {
            $('#payment_form').submit();
        }

        setTimeout(function () {
            $scope = angular.element('[ng-controller=PaymentCtrl]').scope();
            $scope.restaurant = {!! $restaurant !!};
            $scope.order = {!! $order !!};
            $scope.order_id = {!! $orderId !!};
            $scope.showErrorMessage = {!! $showErrorMessage !!};
            $scope.verified = {!! $verified !!};
          
            
            $scope.init();
        }, 200)
    </script>
@endsection