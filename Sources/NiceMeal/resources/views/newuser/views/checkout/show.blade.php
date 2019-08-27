@extends('newuser.layouts.app')
@section('content')
@php
    $wardSelected = empty(Request::get("ward")) ? "''" : Request::get("ward");
@endphp
<div class="checkout-page" ng-controller="CheckoutCtrl">
    <form ng-submit="synchronizeCart()" name="checkoutForm" id="checkoutForm">
        @include('newuser.components.checkout.contact')
        @include('newuser.components.checkout.'.$cookieService.'.main')
        @include('newuser.components.checkout.tax_info')
        @include('newuser.components.checkout.payment')
    </form>
    <form id="payment_form_newuser" method="post" action="/payment/process-payment">
        @csrf
        <input type="hidden" size="20" value="" name="p_payment_with" id="p_payment_with">
        <input type="hidden" size="20" value="" name="p_order_id" id="p_order_id">
    </form>
    @include('newuser.components.popup.checkout.time_base.main')
    @include('newuser.components.popup.popup_otp')
</div>
@endsection
@push('extra_scripts')
<script src="/b2c-assets/js/newuser/checkout/checkout.js"></script>
<script src="/b2c-assets/js/newuser/checkout/checkout-ctrl.js"></script>
<script type="text/javascript">
angular.element(document).ready(function(){
    $checkoutScope = angular.element('[ng-controller=CheckoutCtrl]').scope();
    $checkoutScope.checkoutData = {};
    $checkoutScope.checkoutData.payment_date = 'asap';
    $checkoutScope.checkoutData.delivery_date = 'asap';
    $checkoutScope.checkoutData.pickup_date = 'asap';
    // contact
    $checkoutScope.checkoutData.email = '';
    $checkoutScope.checkoutData.name = '';
    $checkoutScope.checkoutData.title = '';
    $checkoutScope.checkoutData.phone = '';
    $checkoutScope.checkoutData.messaging = '';
    $checkoutScope.checkoutData.other_app = '';
    $checkoutScope.checkoutData.app_contact_info = '';
    // delivery info
    $checkoutScope.checkoutData.residencetype = 'house';
    $checkoutScope.checkoutData.address = {};
    $checkoutScope.checkoutData.address.full_address = '';
    $checkoutScope.checkoutData.address.direction = '';
    $checkoutScope.checkoutData.delivery_ward = '';
    $checkoutScope.checkoutData.delivery_district = '';

    // note
    $checkoutScope.checkoutData.delivery_time = 'asap';
    // tax
    $checkoutScope.checkoutData.tax_id = '';
    $checkoutScope.checkoutData.tax_name = '';
    $checkoutScope.checkoutData.tax_contact = '';
    $checkoutScope.checkoutData.tax_address = '';
    // payment
    $checkoutScope.checkoutData.payment_prepare = '';

    $checkoutScope.title = @json($title);
    $checkoutScope.messagingApp = @json($messagingApp);
    $checkoutScope.districts = @json($districts);
    $checkoutScope.residencetypes = @json($residencetype);
    $checkoutScope.restaurant = @json($restaurant);
    $checkoutScope.delivery_ward = @json($delivery_ward);
    $checkoutScope.res_deli_setting = $checkoutScope.getResDeliSetting();
    $checkoutScope.timeLeft = 0;
    @if(Auth::check())
        $checkoutScope.checkoutData.register = 0;
    @else
        $checkoutScope.checkoutData.register = 1;
    @endif
    $checkoutScope.init();
})
</script>
@endpush