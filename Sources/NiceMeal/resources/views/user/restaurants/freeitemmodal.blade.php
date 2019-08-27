<div class="modal fade" id="freeItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form ng-submit="proceedToCheckout()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body ng-scope">
                    <div class="orderbox">
                        <div class="orderbox__header"><h5 text>Select your free items</h5></div>
                        <div class="orderbox__content">
                            <ul class="orderbox__product">
                                <li ng-repeat="promotion in cart.free_item_promotions" ng-class="promotion.id">
                                    <p ng-if="promotion.apply_to == 3">Your bill reached mount from <b><% promotion.min_order_value %></b> to <b><% promotion.max_order_value %></b>. So you can choice 1 free item</p>
                                    <p ng-if="promotion.apply_to != 3">You bought <% promotion.free_item_quantity %> items have promotion <b><% promotion.name_en %></b>. So can choice maximum <% promotion.free_item_quantity %> free items</p>
                                    <select ng-class="promotion.id" ng-model="promotion.selected_free_item_id" ng-change="changeFreeItem(promotion, promotion.selected_free_item_id)">
                                        <option value="">-- Choose your option --</option>
                                        <option ng-repeat="dish in promotion.dishes" ng-value="dish.id"><% dish.name %>
                                    </select>
                                    <div class="col-lg-12 option-item" ng-repeat="dish in promotion.selected_free_items">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8" style="padding-top: 12px;">
                                                <p><% dish.name %></p>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-10" style="margin-left: 10px;">
                                                        <input type="number" ng-value="dish.quantity" ng-model="dish.quantity" ng-change="setFreeItemValue(this, promotion, dish)" min="0">
                                                    </div>
                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">
                                                        <span class="btn-del-product" style="color:red" ng-click="deleteFreeItem(promotion, dish.id)">
                                                            <i class="fa fa-times-circle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="orderbox__order">
                                <div class="row">
                                    <div class="col-md-7">
                                    </div>

                                    <div class="col-md-5">
                                        <div class="order__total">
                                            @if(isset($is_checkout_page))
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
                                            @endif
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
<style>
    .modal-ku {
        width: 750px;
        margin: auto;
    }

</style>

