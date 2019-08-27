@extends('layouts.app')
@section('content')
    <div class="container payment-test-page">
        <div class=" row payment-test-form">
            <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="/payment/process-payment">
                {{ csrf_field() }}
                <h2>Payment Form</h2>
                <p>Demo PayPal form - Integrating paypal in laravel</p>
                <p>
                    <label class="w3-text-blue"><b>Enter Amount</b></label>
                    <input class="col-lg-12 col-md-12 col-12" name="amount" type="text">
                </p>
                <button class="btn pay-button btn-success">Pay with PayPal</button></p>
            </form>
        </div>

        @if ($message = Session::get('success'))
            <div class="w3-panel w3-green w3-display-container">
                <span onclick="this.parentElement.style.display='none'"
                      class="w3-button w3-green w3-large w3-display-topright">&times;</span>
                <p class="text-success">{!! $message !!}</p>
            </div>
            <?php Session::forget('success');?>
        @endif

        @if ($message = Session::get('error'))
            <div class="w3-panel w3-red w3-display-container">
                <span onclick="this.parentElement.style.display='none'"
                  class="w3-button w3-red w3-large w3-display-topright">&times;</span>
                <p class="text-danger">{!! $message !!}</p>
            </div>
            <?php Session::forget('error');?>
        @endif
    </div>
@endsection

