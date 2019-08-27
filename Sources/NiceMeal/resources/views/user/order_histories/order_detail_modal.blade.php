<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="orderDetailForm" ng-submit="reOrderThis()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body ng-scope">
                    <div class="orderbox">
                        <div class="orderbox__header">
                            <div class="orderbox__choose">
                                <div class="choose__wrap"><span class="choose__text">Choose service:</span>

                                    <div class="checkbox" ng-repeat="(key,service) in services" ng-if="selectedOrder[key]">
                                        <label class="custom-control custom-checkbox" ng-click="selectService(key)">
                                            <input class="custom-control-input"  name="cartService" type="radio"
                                                   ng-value="key" ng-required="1" ng-checked="selectedOrder.order_type == key"/>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description"> <% service %></span>
                                        </label>
                                    </div>

                                </div>
                                <div class="choose__wrap"><span class="choose__text">Choose payment:</span>

                                    <div class="checkbox" ng-repeat="(key,payment) in payments" ng-if="selectedOrder[key]">
                                        <label class="custom-control custom-checkbox" ng-click="selectPayment(key)">
                                            <input class="custom-control-input" name="cartPayment" type="radio"
                                                   ng-value="key" ng-required="1" ng-checked="selectedOrder.payment_method == key" />
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description"> <% payment %></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="choose__wrap"><span class="choose__text">Check Bill</span>
                                    <div class="checkbox">
                                        <input disabled name="checkBill" ng-checked="selectedOrder.take_red_invoice" type="checkbox" value="1" ng-click="checkBill($event)">
                                    </div>

                                </div>
                            </div>
                            <div class="orderbox__pricemin"><span class="pricemin__text">Min order:</span> <span
                                        class="pricemin__price ng-binding">
                                   <% selectedOrder.minOrderAmount.formatCurrency() %> </span></div>
                        </div>
                        <div class="orderbox__content">
                            <ul class="orderbox__product">
                                <li class="product__item ng-scope" ng-repeat="(item_key,item) in selectedOrder['order_items']">
                                    <div class="product__amount">
                                        <input type="number" min="1" ng-model="item.quantity" ng-change="checkNegative(item_key)" ng-value="item.quantity" class="product__number ng-pristine ng-untouched ng-valid" ng-disabled="item.free_item==1">
                                    </div>
                                    <div class="product__quantity">X</div>
                                    <div class="product__body">
                                        <h3 class="product__title ng-binding">
                                            <% item.name %>
                                            <span class="pull-right">
                                                <% item.price.formatCurrency() %></span>
                                        </h3>
                                        <span ng-bind-html="item.description | trustHtml"></span>
                                        <div class="product__text ng-binding"></div>
                                        <div class="product__option ng-scope">
                                            <div class="col-12 ng-scope customizations" ng-repeat="(custom_key,custom_option) in item['order_items_customizations']">
                                                    - <% custom_option.option_name %> :
                                                    <% custom_option.quantity %> x
                                                    <% custom_option.price.formatCurrency() %>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="orderbox__order">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="order__note">
                                            <textarea cols="30" rows="10" placeholder="Order Note:" class="ng-pristine ng-untouched ng-valid"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="order__total">
                                            <p>Subtotal:<span class="ng-binding">
                                                <% selectedOrder.sub_total_amount.formatCurrency() %></span></p>
                                            <p ng-show="selectedOrder.discount > 0">Promotion:<span><% selectedOrder.discount.formatCurrency() %></span></p>
                                            <p ng-show="selectedOrder.tax > 0">Tax <% selectedOrder.tax_rate %>%:<span class="ng-binding">
                                                <% selectedOrder.tax.formatCurrency() %></span></p>
                                            <p>Delivery fee:<span class="ng-binding">
                                                <% selectedOrder.shipping_fee.formatCurrency() %></span></p>
                                            <p style="font-size: 16px" class="bigtotal">Order total:<span class="ng-binding">
                                                <% selectedOrder.total_amount.formatCurrency() %></span></p>
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <!-- <button type="submit" class="md-btn send-review-btn md-btn--md">
                                            SEND REVIEW
                                        </button> -->
                                        <button type="submit" class="md-btn md-btn--primary md-btn--md">
                                            RE-ORDER
                                        </button>
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
<style>
    .modal-ku {
        width: 750px;
        margin: auto;
    }
</style>