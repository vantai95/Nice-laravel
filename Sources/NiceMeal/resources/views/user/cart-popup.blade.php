<div class="modal-body">
  <div class="orderbox">
    <div class="orderbox__header">
      <div class="orderbox__choose">
        <div class="choose__wrap">
          <span class="choose__text">Choose service:</span>
          <div class="checkbox" ng-repeat="item in orderServiceItems">
            <label class="custom-control custom-checkbox"
                   ng-click="saveCart()">
              <input class="custom-control-input"
                     type="radio"
                     ng-model="cart.cart_info.delivery_type"
                     ng-value="item.value">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">{{item.description}}</span>
            </label>
          </div>
        </div>
        <div class="choose__wrap">
          <span class="choose__text">Choose payment:</span>
          <div class="checkbox" ng-repeat="item in orderPaymentItems">
            <label class="custom-control custom-checkbox"
                   ng-click="saveCart()">
              <input class="custom-control-input"
                     type="radio"
                     ng-model="cart.cart_info.payment"
                     ng-value="item.value">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">{{item.description}}</span>
            </label>
          </div>
        </div>
      </div>
      <div class="orderbox__pricemin">
        <span class="pricemin__text">Min order:</span>
        <span class="pricemin__price">{{restaurant.min_order_amount | currencyFormat}}</span>
      </div>
    </div>
    <div class="orderbox__content">
      <ul class="orderbox__product">
        <li class="product__item"
            ng-repeat="item in cart.selection"
            ng-if="item.quantity >= 0">
          <div class="product__amount">
            <input type="number"
                   class="product__number"
                   ng-change="item.quantity = productAmountChange(item);"
                   ng-model="item.quantity"
                   ng-model-options="{ debounce: 100 }">
          </div>
          <div class="product__quantity">X</div>
          <div class="product__body">
            <h3 class="product__title">{{item.details.dish.name}}</h3>
            <div class="product__text">{{item.details.dish.description}}</div>
            <div class="product__option" ng-if="item.details.combo.length > 0 || item.details.extra.length > 0">
              <div class="col-3" ng-repeat="option in item.details.combo">
                <span>- {{option.name}}: {{option.price | currencyFormat}}</span>
              </div>
              <div class="col-3" ng-repeat="option in item.details.extra">
                <span>- {{option.name}}: {{option.price | currencyFormat}}</span>
              </div>
            </div>
          </div>
          <div class="product__footer">
            <div class="product__footer-price">
              <input type="text" class="product__number" value="10">
              <span class="peroid"><i class="fa fa-close"></i></span>
              <span>{{item.totalPrice | currencyFormat}}</span>
            </div>
            <span class="btn-del-product"
                  ng-click="subtractFromCart(item)">
              <i class="fa fa-times-circle"></i>
            </span>
          </div>
        </li>
      </ul>
      <div class="orderbox__order">
        <div class="row">
          <div class="col-md-8">
            <div class="order__note">
              <textarea cols="30"
                        rows="10"
                        placeholder="Order Note:"
                        ng-model="cart.info.order_note"
                        ng-change="saveCart()"
                        ng-model-options="{ debounce: 200 }"></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="order__total">
              <p>Subtotal:<span>{{subTotal | currencyFormat}}</span></p>
              <p ng-if="cart.deliveryFee === 0">Delivery fee:<span>{{cart.deliveryFee | currencyFormat}}</span></p>
              <p class="bigtotal">Order total:<span>{{total | currencyFormat}}</span></p>
              <button type="button"
                      class="md-btn md-btn--primary md-btn--md"
                      ng-click="proceedToCheckout()"
                      ng-disabled="cart.selection.length <= 0 || subTotal < restaurant.min_order_amount">
                ORDER NOW
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="close-order-box close-popup"
         ng-click="closeCart()">x</div>
  </div>
</div>
