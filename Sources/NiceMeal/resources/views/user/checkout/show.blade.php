@extends('layouts.app')
@section('content')

<div class="md-content hidden" ng-controller="CheckoutCtrl">

    @include('user.social-tools')

    <!-- hero -->
    <section class="hero" style="background-image:url();">
        <div class="md-tb">
            <div class="md-tb__cell">
                <div class="container">
                    <div class="hero__page">
                        <div class="row">
                            <div class="col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-3 ">
                                <h1 class="hero__page_title">Ready to eat?</h1>
                                <p class="hero__page_text">Where do you want your order to be delivered?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero__menu">
            <div class="container">
                <div class="hero__menu_wrap">
                    <div class="hero__left">
                        <a ng-click="backToOrderPage()"><i class="fa fa-long-arrow-left"></i>Back</a>
                    </div>
                    <div class="hero__right" data-toggle="modal" data-target="#cartModal">
                        <div class="hero__card">
                            <a class="add-to-order">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="cart-number">
                                    <% cart.total_item %> </span>
                            </a>
                        </div>
                        <span class="hero__total">Total: <% cart.order_total.formatCurrency() %><span></span></span>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End / hero -->


    <!-- Section -->
    <section class="md-section">
        <div class="container">

            <form ng-submit="synchronizeCart()" name="checkoutForm">
                <div class="row">
                    <div class="col-lg-8 ">
                        <div class="main-content">

                            <div class="form-wrap">
                                <h3 class="form-wrap__title">Contact info:</h3>
                                <div class="form-wrap__inner">

                                    <!-- form-item -->
                                    <div class="form-item form-item--half ui-select-box">
                                        <label class="form__label">Title<span>*</span></label>
                                        <select class="select2" style="width:100%;"
                                            ng-model="checkoutData.title" required>
                                            <option value="" disabled selected>--Choose your title--</option>
                                            <option ng-repeat="(key,value) in title" value="<% key %>">
                                                <% value %>
                                            </option>
                                        </select>
                                    </div>
                                    <!-- End / form-item -->


                                    <!-- form-item -->
                                    <div class="form-item form-item--half" ng-class="{'has-error': checkoutForm.full_name.$dirty && checkoutForm.full_name.$invalid}">
                                        <label class="form__label">Full name<span>*</span></label>
                                        <input class="form-control" type="text" name="full_name" placeholder="Enter your full name"
                                            required ng-model="checkoutData.full_name" ng-value="321321">
                                    </div><!-- End / form-item -->


                                    <!-- form-item -->
                                    <div class="form-item form-item--half" ng-class="{'has-error': checkoutForm.email.$dirty && checkoutForm.email.$invalid}">
                                        <label class="form__label">Email<span>*</span></label>
                                        <input class="form-control" type="email" name="email" placeholder="Enter your email address"
                                            required ng-model="checkoutData.email" {{Auth::check() ? 'disabled' : ''}}>
                                    </div><!-- End / form-item -->


                                    <!-- form-item -->
                                    <div class="form-item form-item--half" ng-class="{'has-error': checkoutForm.phone.$dirty && checkoutForm.phone.$invalid}">
                                        <label class="form__label">phone<span>*</span></label>
                                        <input class="form-control" type="tel" name="phone" id="customer_phone" onkeypress="return isNumber(event)" placeholder="Enter your phone"
                                            required ng-model="checkoutData.phone" ng-value=>
                                    </div><!-- End / form-item -->

                                </div>
                            </div>

                            <!--Pick-->
                            <div class="form-wrap" ng-if="cart.service === 'pickup'">
                                <h3 class="form-wrap__title">Pick up info:</h3>
                                <div class="form-wrap__inner">

                                    <div class="form-item form-item">
                                        <label class="form__label">Pick up at<span>*</span></label>
                                        <input disabled style="width:50%"
                                            class="form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched"
                                            type="text" ng-value="restaurant.name_en">
                                    </div>

                                    <div class="form-item">
                                        <label class="form__label">Restaurant address<span>*</span></label>
                                        <input disabled
                                            class="form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched"
                                            type="text" ng-value="restaurant.address_en">
                                    </div>

                                </div>
                            </div>
                            <!--End pick-->

                            <!--Delivery-->
                            <div class="form-wrap" ng-if="cart.service === 'delivery'">
                                <h3 class="form-wrap__title">Delivery info:</h3>
                                <div class="form-wrap__inner">

                                    <!-- form-item -->
                                    <div class="form-item form-item--half ui-select-box">
                                        <label class="form__label">Residence type<span>*</span></label>
                                        <select ng-init="checkoutData.residencetype.value = 'house'" class="select2"
                                            ng-model="checkoutData.residencetype.value" style="width:100%;">
                                            <option ng-repeat="(key,value) in residencetype" ng-value="key">
                                                <% value %>
                                            </option>
                                        </select>
                                    </div>
                                    <!-- End / form-item -->

                                    <!-- form-item -->
                                    <div class="form-item" ng-class="{'has-error': checkoutForm.address.$dirty && checkoutForm.address.$invalid}">
                                        <label class="form__label">Full address<span>*</span></label>
                                        <input class="form-control" type="text" name="address" placeholder="Enter your full address"
                                            required ng-model="checkoutData.address.full_address">
                                    </div><!-- End / form-item -->

                                    <!-- form-item -->
                                    <div class="form-item form-item--half ui-select-box" ng-class="{'has-error': checkoutForm.district.$dirty && checkoutForm.district.$invalid}">
                                        <label class="form__label">District<span>*</span></label>
                                        <select ng-required="true" ng-init="checkoutData.district = restaurant.district_id"
                                        ng-model="checkoutData.district" class="select2" required style="width:100%;">

                                            <option ng-value="restaurant.district_id"><% restaurant.districtName %></option>
                                        </select>
                                    </div><!-- End / form-item -->

                                    @php
                                        $wardSelected = empty(Request::get("ward")) ? "''" : Request::get("ward");
                                    @endphp
                                    <!-- form-item -->
                                    <div class="form-item form-item--half ui-select-box" ng-class="{'has-error': checkoutForm.ward.$dirty && checkoutForm.ward.$invalid}">
                                        <label class="form__label">Ward<span>*</span></label>
                                        <select ng-required="true" ng-init=" checkoutData.ward = {{ $wardSelected }}" ng-model="checkoutData.ward" class="select2" style="width:100%">
                                            <option value="" disabled selected>--Select ward--</option>
                                            <option ng-repeat="ward in delivery_ward[checkoutData.district]" ng-value="ward.id">
                                                <% ward.type %> <% ward.name %>
                                            </option>
                                        </select>
                                    </div><!-- End / form-item -->


                                    <div ng-if="checkoutData.residencetype.value === 'building'">
                                        <!-- form-item -->
                                        <div class="form-item form-item--half" ng-class="{'has-error': checkoutForm.building_name.$dirty && checkoutForm.building_name.$invalid}">
                                            <label class="form__label">Building name<span>*</span></label>
                                            <input class="form-control" type="text" name="building_name" placeholder="Enter your building name"
                                                required ng-model="checkoutData.building_name">
                                        </div><!-- End / form-item -->


                                        <!-- form-item -->
                                        <div class="form-item form-item--half">
                                            <label class="form__label">Block tower</label>
                                            <input class="form-control" type="text" name="block_tower" placeholder="Enter your block tower"
                                                ng-model="checkoutData.block_tower">
                                        </div>
                                        <!-- End / form-item -->


                                        <!-- form-item -->
                                        <div class="form-item form-item--half" ng-class="{'has-error': checkoutForm.floor.$dirty && checkoutForm.floor.$invalid}">
                                            <label class="form__label">Floor<span>*</span></label>
                                            <input class="form-control" type="text" name="floor" placeholder="Floor number"
                                                required ng-model="checkoutData.floor">
                                        </div><!-- End / form-item -->


                                        <!-- form-item -->
                                        <div class="form-item form-item--half" ng-class="{'has-error': checkoutForm.room.$dirty && checkoutForm.room.$invalid}">
                                            <label class="form__label">Room<span>*</span></label>
                                            <input class="form-control" type="text" name="room" placeholder="Enter your room"
                                                required ng-model="checkoutData.room">
                                        </div><!-- End / form-item -->
                                    </div>


                                    <div ng-if="checkoutData.residencetype.value === 'compound'">
                                        <!-- form-item -->
                                        <div class="form-item form-item--half" ng-class="{'has-error': checkoutForm.compound_name.$dirty && checkoutForm.compound_name.$invalid}">
                                            <label class="form__label">Compound name<span>*</span></label>
                                            <input class="form-control" type="text" name="compound_name" placeholder="Compound"
                                                required ng-model="checkoutData.compound_name">
                                        </div><!-- End / form-item -->


                                        <!-- form-item -->
                                        <div class="form-item form-item--half">
                                            <label class="form__label">House number</label>
                                            <input class="form-control" type="text" name="house_number" placeholder="House number"
                                                ng-model="checkoutData.house_number">
                                        </div><!-- End / form-item -->
                                    </div>


                                    <div ng-if="checkoutData.residencetype.value === 'hotel'">
                                        <!-- form-item -->
                                        <div class="form-item form-item--half" ng-class="{'has-error': checkoutForm.hotel_name.$dirty && checkoutForm.hotel_name.$invalid}">
                                            <label class="form__label">Hotel name<span>*</span></label>
                                            <input class="form-control" type="text" name="hotel_name" placeholder="The Reverie Saigon"
                                                required ng-model="checkoutData.hotel_name">
                                        </div><!-- End / form-item -->


                                        <!-- form-item -->
                                        <div class="form-item form-item--half" ng-class="{'has-error': checkoutForm.room.$dirty && checkoutForm.room.$invalid}">
                                            <label class="form__label">Room</label>
                                            <input class="form-control" type="text" name="room" placeholder="324"
                                                ng-model="checkoutData.room">
                                        </div><!-- End / form-item -->
                                    </div>

                                </div>
                            </div>
                            <!--End delivery-->

                            <div class="form-wrap">
                                <h3 class="form-wrap__title">Note:</h3>
                                <div class="form-wrap__inner">
                                    <div class="form-item">
                                        <label class="form__label">Direction:</label>
                                        <textarea class="form-control" name="direction" cols="30" rows="10" ng-model="checkoutData.direction"></textarea>
                                    </div>
                                    <div ng-if="isOnlinePayment() !=1 " class="form-item form-item--half ui-select-box" ng-class="{'has-error': checkoutForm.payment_amount.$dirty && checkoutForm.payment_amount.$invalid}">
                                        <label class="form__label">Payment amount<span>*</span></label>
                                        <select ng-init="checkoutData.payment_amount = ''" class="select2" style="width:100%"
                                            ng-model="checkoutData.payment_amount" ng-change="changePaymentAmount()" required>
                                                <option value="" disabled selected>--Choose Payment Amount--</option>
                                                <option value="0">Pay exact total bill</option>
                                                <option value="1">Other</option>
                                        </select>
                                    </div>


                                    <div ng-if="isOnlinePayment() !=1 && checkoutData.payment_amount == '1'" class="form-item form-item--half" ng-class="{'has-error': checkoutForm.payment_amount_value.$dirty && checkoutForm.payment_amount_value.$invalid}">
                                        <label class="form__label">You will pay with:<span>*</span></label>
                                        <input type="text" id="payment_amount_value"  ng-required="true" input-currency
                                               ng-init="checkoutData.payment_amount_value = ''"
                                               ng-model="checkoutData.payment_amount_value" ng-value="checkoutData.payment_amount_value" name="payment_amount_value" ng-change="checkPaymentValue()">
                                        <p ng-show="!validatePaymentAmount(checkoutData.payment_amount_value,cart.order_total)" class="checkout-payment">Payment Amount need large than total value</p>
                                    </div>

                                    <div ng-show="cart.service === 'delivery'" class="form-item form-item--half"
                                             ng-class="{'has-error': checkoutForm.delivery_time.$invalid}">
                                            <label class="form__label">Delivery time<span>*</span></label>
                                        <select ng-required="cart.service === 'delivery'" ng-init="checkoutData.delivery_time = ''" ng-model="checkoutData.delivery_time" class="select2" style="width:100%" >
                                            <option value="" disabled selected>--Select delivery time--</option>
                                            <option value="asap">As soon as possible</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    {{-- --------------Timepicker-------------- --}}
                                    <div class="form-item form-item--half" ng-show="checkoutData.delivery_time == 'other'">
                                        <label class="form__label">Choose time<span>*</span></label>
                                        <input type="text" id="specific_time" ng-model="checkoutData.specific_time" name="specific_time" ng-required="cart.service === 'delivery'">
                                        <p ng-show="!validateTime(checkoutData.delivery_time,checkoutData.specific_time)" style="color: red">Delivery time must be at least 30 minute</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-wrap" ng-if="todoRemoveThisWhenOnlinePaymentIsApplied && checkoutData.residencetype.value === 'building'">
                                <h3 class="form-wrap__title">Credit card info:</h3>
                                <div class="form-wrap__inner">

                                    <div class="form-item form-item--split-3">
                                        <label class="form__label">Expiration month<span>*</span></label>
                                        <input class="form-control" type="number" name="exp_month" placeholder="mm"
                                            required ng-model="checkoutData.exp_month">
                                    </div>

                                    <div class="form-item form-item--split-3">
                                        <label class="form__label">Expiration year<span>*</span></label>
                                        <input class="form-control" type="number" name="exp_year" placeholder="yyy"
                                            required ng-model="checkoutData.exp_year">
                                    </div>

                                    <div class="form-item form-item--split-3 form-item-card">
                                        <label class="form__label">Security code<span>*</span></label>
                                        <input class="form-control" type="number" name="cvc" placeholder="432" required
                                            ng-model="checkoutData.cvc">
                                        <div class="card"><img ng-src="" alt="">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            @if(!Auth::check())
                            <div class="form-wrap">
                                <h3 class="form-wrap__title">Create your account here</h3>
                                <div class="form-wrap__inner">
                                    <div class="form-item form-item--half">
                                        <label class="form__label">Your Password<span>*</span></label>
                                        <input class="form-control" type="password" id="password-field"
                                        ng-required="true" name="password" ng-model="checkoutData.password.password">
                                        <p class="text-danger" id="message-valid-password">@lang('b2c.checkout.message_valid_password')</p>
                                    </div>
                                    <div class="form-item form-item--half">
                                        <label class="form__label">Confirm Password<span>*</span></label>
                                        <input class="form-control"
                                        ng-required="true"
                                         type="password" name="confirmpassword" ng-model="checkoutData.password.confirm">
                                    </div>
                                </div>

                            </div>
                            @endif

                            <div class="form-wrap">
                                <h3 class="form-wrap__title">Input your promotion code here</h3>
                                <div class="form-wrap__inner">
                                    <div class="form-item col-md-9">
                                        <input class="form-control" type="text" name="voucher_code" ng-model="voucher_code">
                                        <p ng-show="cart.voucher &&
                                                    cart.voucher.min_order_value <= cart.sub_total &&
                                                    cart.sub_total <= cart.voucher.max_order_value" style="color: green;">
                                            Your promotion: <% cart.voucher.name %></p>
                                        <p ng-show="checked_voucher && voucher_code && !cart.voucher" style="color: red">Promotion code invalid!</p>
                                    </div>
                                    <a class="md-btn md-btn--danger md-btn--sm md-btn--danger col-md-3" style="height: 50px; line-height: 35px" ng-disabled="!voucher_code" ng-click="checkVoucher()">Check</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 ">
                        <div class="sidebar-right">

                            <!-- widget -->
                            <div class="widget">
                                <h2 class="widget__title">Min order: <span class="price">
                                        <% restaurant.minOrderAmount.formatCurrency() %></span></h2>
                                <div class="widget__content">

                                    <!-- widget-order -->
                                    <div class="widget-order">
                                        <div class="widget-order__item">
                                            <span class="widget-order__title">Choose service</span>
                                            <div class="widget-order__check_wrap">

                                                <div class="checkbox" ng-repeat="(key,value) in orderServices">
                                                    <label class="custom-control custom-checkbox" ng-click="selectService(key,{{$restaurant->deliveryCost}})">
                                                        <input class="custom-control-input" required name="Services" type="radio" ng-checked="checkService(key)"
                                                            ng-value="key" />
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">
                                                            <% value %></span>
                                                    </label>
                                                </div>

                                            </div>
                                            <span class="widget-order__title">Choose payment</span>
                                            <div class="widget-order__check_wrap">

                                                <!-- checkbox -->
                                                <div class="checkbox" ng-repeat="(key,value) in orderPayments">
                                                    <label class="custom-control custom-checkbox" ng-click="selectPayment(key)">
                                                        <input class="custom-control-input" required name="Payments" type="radio" ng-checked="checkPayment(key)"
                                                            ng-value="key" />
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">
                                                            <% value %></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="payment-online-detail" ng-if="cart.payment == 'online_payment'">
                                                <span class="widget-order__title">Choose payment getway</span>

                                                    <div class="row">
                                                            @if($showPayPal)
                                                            <div <?php if($showPayPal) {
                                                                echo "ng-init='choosePaypal()'";
                                                            } ?>  class="col-lg-6 payment-logo">
                                                                <img id="payment-paypal" ng-click="choosePaypal()" src="{{ url('b2c-assets/img/paypal.png') }}" />
                                                            </div>
                                                            @endif
                                                            @if($showNganLuong)
                                                            <div <?php if($showNganLuong) {
                                                                echo "ng-init='chooseAlepay()'";
                                                            } ?>  class="col-lg-6 payment-logo " >
                                                                <img id="payment-aleypay" ng-click="chooseAlepay()"  src="{{ url('b2c-assets/img/ngan-luong.jpg') }}" />
                                                            </div>
                                                            @endif
                                                            @if($showPayPal)
                                                            <p class="col-lg-12" ng-show="cart.payment_with == 'paypal'">
                                                            Exchange rate: 23.000 đ = 1 $
                                                            <br/>Your total: 230.000 đ = 23 $
                                                            <br/>(not included transaction fee)
                                                            </p>
                                                            @endif
                                                    </div>
                                            </div>
                                            @if($restaurant->take_red_bill)
                                            <div class="widget-order__title ">
                                                <label>
                                                Take Red Invoice
                                                <input name="checkBill" ng-checked="cart.checkbill" type="checkbox" value="1" ng-click="checkBill($event)">
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="widget-order__item">
                                            <div class="widget-order__product"><div class="widget-order__product_list" ng-repeat="(key,item) in cart.items">
                                                <input class="product__number" style="width: 60px !important" type="number" ng-required="1"
                                                    ng-model="item.quantity" ng-model-options="{ debounce: 100 }" min="0" disabled="disabled">
                                                <span class="product__period">x</span>
                                                    <h4 class="product__name">
                                                    <% item.name %>
                                                    </h4>
                                                    <div class="product__footer product__footer-width">
                                                    <span style="margin-left:-20px" class="product__price"><% item.price.formatCurrency() %></span>
                                                    </div>
                                                    <div class="product__subscription">
                                                    <div ng-repeat="option in item.options">
                                                        <strong>- <% option.option_name %>: <% option.quantity %> x <% option.price.formatCurrency() %></strong>
                                                    </div>
                                                    </div>
                                                    <b style="margin-left: 25%"><% (item.free_item==1) ? 'Free Item' : '' %></b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-order__item">
                                            <div class="widget-order__total">
                                                <p>Subtotal:<span><% cart.sub_total.formatCurrency() %></span></p>
                                                <p ng-show="cart.promotion > 0">Promotion:<span><% cart.promotion.formatCurrency() %></span></p>
                                                <p>Tax
                                                    <% cart.tax %>%: <span><% cart.tax_bill.formatCurrency() %></span></p>
                                                <p>Delivery fee:<span><% cart.delivery_fee.formatCurrency() %></span></p>
                                                <p class="disable" ng-if="hasNewPrice">
                                                    Total: <span></span>
                                                </p>
                                                <p class="bigtotal">
                                                    Total: <span><% cart.order_total.formatCurrency() %></span>
                                                </p>
                                                <textarea name="order_note" cols="30" rows="10" placeholder="Order Note:"
                                                    ng-model="cart.order_note"
                                                    ng-change="saveCart()" ng-model-options="{ debounce: 200 }"></textarea>
                                            </div>
                                        </div>
                                        <div class="widget-order__item">
                                            <div class="widget-order__btn_order">
                                                <a class="md-btn md-btn--danger md-btn--sm md-btn--outline-danger" data-toggle="modal"
                                                    data-target="#cartModal">Full Detail</a>
                                            </div>
                                        </div>
                                        <div class="widget-order__item">
                                            <div class="widget-order__note">
                                                <label>

                                                    <!-- checkbox -->
                                                    <div class="checkbox">
                                                        <label class="custom-control custom-checkbox">
                                                            <input class="custom-control-input ng-pristine ng-untouched ng-valid ng-empty" type="checkbox" name="subscribe" ng-model="checkoutData.subscribe">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description"></span>
                                                        </label>
                                                    </div><!-- End / checkbox -->
                                                    I would like to receive newest informations about best deals!
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                @if(CommonService::isTakeawayDomain())

                                                    <button type="button" id="finishBtn" class="md-btn md-btn--danger md-btn--sm md-btn--block" ng-disabled="cart.selection.length <= 0 || subTotal < restaurant.min_order_amount || (checkoutData.delivery_time == 'other' && !validateTime(checkoutData.delivery_time,checkoutData.specific_time))" data-toggle="modal" data-target="#takeawayModal">
                                                    Finish
                                                </button>
                                                 @else
                                                <button type="submit" id="finishBtn" class="md-btn md-btn--danger md-btn--sm md-btn--block" ng-disabled="cart.selection.length <= 0 || subTotal < restaurant.min_order_amount || (checkoutData.delivery_time == 'other' && !validateTime(checkoutData.delivery_time,checkoutData.specific_time))">
                                                    Finish
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div><!-- End / widget-order -->

                                </div>
                            </div><!-- End / widget -->

                        </div>
                    </div>
                </div>
            </form>

            <form id="payment_form" method="post" action="/payment/process-payment">
                {{ csrf_field() }}
                <input type="hidden" size="20" value="<% cart.payment_with %>" name="p_payment_with" id="p_payment_with">
                <input type="hidden" size="20" value="" name="p_order_id" id="p_order_id">
            </form>
        </div>
    </section>
    <!-- End / Section -->

    @include('user.restaurants.cartmodal',['cart'=>$cart,'is_checkout_page'=>true])
    @include('user.checkout.otpmodal')
    @include('user.checkout.vouchermodal')
</div>


@endsection
@section('extra_scripts')
    <!-- <script type="text/javascript">
        $(document).ready(function() {
            console.log('526');
            $('.payment-logo img#payment-aleypay').click();
        });
    </script> -->

    <script src="/b2c-assets/js/cart/cart.js"></script>
    <script src="/b2c-assets/js/checkout/show.js"></script>
    <script src="/b2c-assets/js/checkout/progressbar.js"></script>
    <script>
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        setTimeout(function(){
            $scope = angular.element('[ng-controller=CheckoutCtrl]').scope();
            $scope.requesting = 0;
            $scope.restaurant = {!! $restaurant !!};
            $scope.title = {!! $title !!};
            $scope.residencetype = {!! $residencetype !!};
            $scope.districts = {!! $districts !!};
            $scope.wards = {!! $wards !!};
            $scope.payment_amount = {!! $payment_amount !!};
            $scope.orderServices = {!! $orderServices !!};
            $scope.orderPayments = {!! $orderPayments !!};
            $scope.countOrder = {{ $countOrder }};
            $scope.delivery_ward = {!! $delivery_ward !!};
            $scope.delivery_time = {!! $delivery_time !!};
            $scope.checkoutData.title = "";
            $scope.checkoutData.full_name = "";
            $scope.checkoutData.email = "";
            $scope.checkoutData.phone = "";
            $scope.checkPaymentValue = function() {
                var orderTotal = $scope.cart.order_total;
                var paymentVal = $scope.checkoutData.payment_amount_value;

                if(orderTotal > paymentVal) {
                    $('#finishBtn').prop('disabled', true);
                } else {
                    $('#finishBtn').prop('disabled', false);
                }
            };



            @if(Auth::check())
                $scope.checkoutData.register = 0;
                $scope.checkoutData.title = "{{ $alter_info->gender }}";
                $scope.checkoutData.full_name = "{{$alter_info->full_name}}";
                $scope.checkoutData.email = "{{$alter_info->email}}";
                $scope.checkoutData.phone = Number("{{$alter_info->phone}}");
            @else
                $scope.checkoutData.register = 1;
            @endif

            @if($preorder != null)
                $scope.preorder = {!! $preorder !!};
                $scope.checkoutData.address = {};
                $scope.checkoutData.address.full_address = "{{ $preorder->full_address }}";
            @endif

            $scope.cart = {!! $cart !!};
            $scope.init();
        }, 200);

        $(document).ready(function () {
            $('#password-field').on('blur', function() {
                var passVal = checkStrongPassword($('#password-field').val());

                if(passVal == true ) {
                    $('#message-valid-password').css('display','none');
                    $('#finishBtn').prop('disabled', false);
                } else {
                    $('#message-valid-password').css('display','block');
                    $('#finishBtn').prop('disabled', true);
                }
            });

             $( "#takeawaybtn" ).bind( "click", function() {
                alert( $( this ).text() );
                });

                $('.modal-child').on('show.bs.modal', function () {
                    var modalParent = $(this).attr('data-modal-parent');
                    $(modalParent).css('opacity', 0);
                });

                $('.modal-child').on('hidden.bs.modal', function () {
                    var modalParent = $(this).attr('data-modal-parent');
                    $(modalParent).css('opacity', 1);
                });


        });

    </script>
@endsection
