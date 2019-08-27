<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-hidden="true">

    <form ng-submit="chooseFreeItems()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body ng-scope">
                    <div class="orderbox">
                        <div class="orderbox__header">
                            <div class="orderbox__choose">
                                <div class="choose__wrap"><span class="choose__text">Choose service:</span>

                                    <div class="checkbox" ng-repeat="(key,value) in orderServices">
                                        <label class="custom-control custom-checkbox" ng-click="selectService(key,restaurant.deliveryCost)">
                                            <input class="custom-control-input" name="cartService" type="radio"
                                                ng-value="key" ng-required="1" ng-checked="checkService(key)" />
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">
                                                <% value %></span>
                                        </label>
                                    </div>

                                </div>
                                <div class="choose__wrap"><span class="choose__text">Choose payment:</span>

                                    <div class="checkbox" ng-repeat="(key,value) in orderPayments">
                                        <label class="custom-control custom-checkbox" ng-click="selectPayment(key)">
                                            <input class="custom-control-input" name="cartPayment" type="radio"
                                                ng-required="1" ng-checked="checkPayment(key)" ng-value="key" />
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">
                                                <% value %></span>
                                        </label>
                                    </div>

                                </div>
                                @if($restaurant->take_red_bill)
                                <div class="choose__wrap"><span class="choose__text">Take red invoice</span>
                                    <div class="checkbox">
                                        <input name="checkBill" ng-checked="cart.checkbill" type="checkbox" value="1" ng-click="checkBill($event)">
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="orderbox__pricemin">
                                    <span class="pricemin__text">Min order:</span>
                                    <span class="pricemin__price ng-binding"><% restaurant.minOrderAmount.formatCurrency() %></span>
                            </div>
                        </div>
                        <div class="orderbox__content">
                            <ul class="orderbox__product">
                                <li class="product__item ng-scope" ng-repeat="(key,item) in cart.items">
                                    <div class="product__amount">
                                        @isset($is_checkout_page)
                                            <input type="number"  style="width: 70px !important" class="product__number ng-pristine ng-untouched ng-valid" ng-value="item.quantity" disabled="disabled">
                                        @else
                                            <input type="number" style="width: 70px !important" class="product__number ng-pristine ng-untouched ng-valid" ng-change="dishAmountChange(item.quantity, key);"
                                                ng-model="item.quantity" ng-min="1" ng-model-options="{ debounce: 100 }" ng-disabled="item.free_item">
                                        @endisset
                                    </div>
                                    <div class="product__quantity">X</div>
                                    <div class="product__body">
                                        <h3 class="product__title ng-binding">
                                            <% item.name %>
                                            <span class="pull-right"><% item.price.formatCurrency() %></span>
                                        </h3>
                                        <div class="product__text ng-binding" ng-bind-html="item.dish.description | trustHtml"></div>
                                        <div class="product__option ng-scope">
                                            <div class="col-12 ng-scope customizations" ng-repeat="option in item.options">
                                                <span>- <% option.option_name %> :</span>
                                                <span><% option.quantity %> x <% option.price.formatCurrency() %></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product__footer">
                                        <div class="product__footer-price"><input type="text" class="product__number"
                                                value="10">
                                            <span class="peroid"><i class="fa fa-close"></i></span> <span class="ng-binding">149.000₫</span>
                                        </div>
                                        @unless(isset($is_checkout_page))
                                            <span class="btn-del-product" ng-click="subtractFromCart(key)"><i class="fa fa-times-circle"></i></span>
                                        @endunless
                                    </div>
                                </li>
                            </ul>
                            <div class="orderbox__order">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="order__note row"><textarea cols="30" rows="10" placeholder="Order Note:"
                                                ng-model="cart.order_note" ng-change="saveCart()" ng-model-options="{ debounce: 200 }"
                                                class="ng-pristine ng-untouched ng-valid"></textarea>
                                        </div>
                                        <div class="orderbox_alert row" ng-if="cart.sub_total <= 0 || cart.sub_total < {{ $restaurant->minOrderAmount }}">
                                                <span>Please add more item to reach the minimum order value</span>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="order__total">
                                            <p>Subtotal:<span class="ng-binding">
                                                    <% cart.sub_total.formatCurrency() %></span></p>
                                            <p ng-show="cart.promotion > 0">Promotion:<span><% cart.promotion.formatCurrency() %></span></p>
                                            <p>Tax <% cart.tax %>%: <span><% cart.tax_bill.formatCurrency() %></span></p>
                                            <p>Delivery fee:<span class="ng-binding">
                                                <% cart.delivery_fee.formatCurrency() %></span></p>
                                            <p class="bigtotal">Total:<span class="ng-binding">
                                                    <% cart.order_total.formatCurrency() %></span></p>


                                                 @isset($is_checkout_page)
                                                    <button type="button"
                                                        data-dismiss="modal"
                                                        class="md-btn md-btn--primary md-btn--md"
                                                        ng-disabled="cart.sub_total <= 0 || cart.sub_total < {{ $restaurant->minOrderAmount }}"
                                                        disabled="disabled">
                                                        ORDER NOW
                                                    </button>
                                                @else
                                                    <button type="submit"
                                                        class="md-btn md-btn--primary md-btn--md"
                                                        ng-disabled="cart.sub_total <= 0 || cart.sub_total < {{ $restaurant->minOrderAmount }}"
                                                        disabled="disabled">
                                                        ORDER NOW
                                                    </button>
                                                @endisset

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="close-order-box close-popup" data-dismiss="modal">x</div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<div  class="modal fade modal-child " data-backdrop-limit="1" id="takeawayModal" tabindex="-1" role="dialog" aria-hidden="true" data-modal-parent="#cartModal">
<div class="modal-dialog">
    <div class="modal-content"><div class="modal-header">NOTICES</div>
        <div class="modal-body">
        <p>
        Hello expats community,
        <br/>
        The website is being updated day by day
        <br/>
        Please send your ideas and feedbacks to us via <a href="mailto:contact.VnTakeaway@gmail.com"><b>vntakeaway@gmail.com</b></a>
        <br/>
        We are working to create a new place to ordering food delivery for expats.
        <br/>
        See you very soon in next month</p></div>
        </div>
        <button title="Close (Esc)" class="mfp-close ng-isolate-scope" type="button" data-dismiss="modal">×</button>
    </div>
</div>
<style>
    .modal-ku {
        width: 750px;
        margin: auto;
    }

</style>
