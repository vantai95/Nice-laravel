@extends('newuser.components.layouts.fixed-sidebar.sample.dropdown-only',['header' => $header, 'type' => $type, 'ngController' => 'CartCtrl'])

@section('dropdownandsearch-sample-dropdown')
    <select class="form-control" name="">
        <option value="redlobster">Red Lobster</option>
        <option value="kingcrab">King Crab</option>
    </select>
@overwrite

@section('dropdownandsearch-sample-content')
    <div class="fixed-sidebar-content-cart-min-order">
        <div class="min-order-detail row">
            <span class="detail-text" style="float:left">Min order</span>
            <span class="detail-price cart-text-float"><% cart.min_order_amount.formatCurrency() %></span>
        </div>
        <div class="min-order-description row" style="font-style:italic; padding-bottom: 5px;">
            Apply for subtotal
        </div>
    </div>
    @include('newuser.components.layouts.fixed-sidebar.cart.item')
    <div class="empty-item-text" ng-if="cart.items.length === 0">
        <a href="#" class="text-danger">Let's have a NiceMeal now</a>
    </div>
    <hr style="border-color: #b3b3b3;">
    <div class="font-size-11">
        <span>Subtotal: <span class="cart-text-float"><% cart.sub_total.formatCurrency() %></span></span>
        <br>
        <span>Promotion: <span class="cart-text-float"><% cart.promotion.formatCurrency() %></span></span>
        <br>
        <span><a id="add-promotion" ng-click="togglePromotion()" class="add-more"
                 href="#">Enter promotion code</a></span>
        <br>
        <span><b>EATMORE23</b> <span style="float:right;font-weight: bold">X</span></span>
        <br>
        <span>Delivery fee: <span class="cart-text-float"><% cart.delivery_fee %></span></span>
    </div>
    <hr style="border-color: #b3b3b3;">
    <div class="font-size-11">
        <div>
            <i class="fa fa-info info-icon-custom" aria-hidden="true"></i>
            <span style="text-decoration: underline;padding-left: 5px">VAT</span>
            <span class="cart-text-float"><% cart.tax_bill.formatCurrency() %></span>
        </div>
        <div style="margin-top: 10px;">
            <span class="provide-vat-text">Provide VAT Invoice</span>
            <div class="item">
                <input type="checkbox" id="toggle_today_summary" name="" value="" >
                <div class="toggle" ng-click="toggleVAT()">
                    <label for="toggle_today_summary" ng-class="{'label-switch' : cart.checkbill == 1 }">
                        <i ng-class="{'i-tag-switch' : cart.checkbill == 1}"></i>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr style="border-color: #b3b3b3;">
    <div>
        <span style="font-size: 13px; font-weight: bold">Final Total: <span
                    class="cart-text-float"><% cart.order_total.formatCurrency() %></span></span>
        <p ng-if="cart.sub_total < cart.min_order_amount" class="text-danger" style="font-size: 12px">Your order must be greater than or equal min order amount</p>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            @if(!$isCheckoutPage)
                <button class="btn btn-place-order btn-status-active" ng-disabled="cart.items.length==0 || cart.sub_total < cart.min_order_amount" ng-click="proceedToCheckout()" {{$isRestaurantPage ? '' : 'disabled'}}>
                    Place Order
                </button>
            @else
                <button class="btn btn-place-order btn-status-active" ng-click="orderNow()">
                    Finish Order
                </button>
            @endif
        </div>
    </div>

    <!--Promotion input form -->
    <div class="promotion-input-form" id="promotion-form">
        <div class="row">
            <div class="col-lg-12 promotion-input-title">
                Enter promotion code
            </div>
            <div class="col-lg-12" style="margin-bottom: 10px;">
                <input class="form-control resize-input-promotion" type="text" placeholder="For ex: SKUHY23">
            </div>
            <div class="add-more" style="margin: 0 20px 20px 20px">
                <a href="#">Add more</a>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 btn-apply-pd">
                    <button class="btn btn-apply">
                        Apply
                    </button>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 btn-cancel-pd">
                    <button class="btn btn-cancel" id="cancel-btn" ng-click="cancelInputPromotion()">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@overwrite
