

<div class="col-lg-3 sticky">
  <div class="sidebar-left">
    <!-- widget -->
    <div class="widget">
      <h2 class="widget__title">Choose Category</h2>
      <div class="widget__content">
        <!-- widget-categories -->
        <ul class="widget-categories"> 
          <li id="category-<%category.id%>" ng-repeat="category in categories" ng-if="category.dishes.length > 0">
            <a href="#category-<% category.id %>" ng-click="goToCate(category)" ng-class="{'text-active': category == currCate}"><% category.title %></a>
          </li>
        </ul><!-- End / widget-categories -->

      </div>
    </div><!-- End / widget -->

  </div>
</div>
<div class="col-lg-5 sticky">

  <!-- nav-menu -->
  <nav class="nav-menu">
    @include('user.restaurants.partial.tabs')
  </nav><!-- End / nav-menu -->

  <div class="content">
    <div class="category-wrapper">
      <!-- <div ng-if="countAvailCategories == 0">No dish available</div> -->
      <div id="category-position-<%category.id%>" class="category" ng-repeat="category in categories" ng-if="category.dishes.length > 0">
        <div class="category__header">
          <span class="category-to-top click-to-top" onclick="goTopPage()"><i class="fa fa-angle-double-up"></i>top</span>
          <h4 class="category__cat ng-binding"><% category.title %></h4>
          <span class="category-minimize" ng-click="minimize = !minimize"><% minimize ? 'Hide' : 'Show' %><i class="fa" ng-class="minimize ? 'fa-angle-up' : 'fa-angle-down'"></i></span>
        </div>
        <div class="category__content animate-show-hide"ng-show="minimize">
          <!-- ngRepeat: dish in category_dishes -->        
          <div class="listing-01 ng-scope row" id="dish-<%dish.id%>" ng-click="selectDish(category, dish)" ng-repeat="dish in category.dishes | filter: {name: dishfilter}" ng-if="dish.category_id == category.id">
          
            <div class="listing-01__body col-lg-6">
              <h2 class="listing-01__name"><a href="" class="ng-binding"><% dish.name %></a></h2>
              <p class="ng-binding" ng-bind-html="dish.description | trustHtml"></p>
            </div>
            <div class="listing-01__footer col-lg-6">
              <span class="ng-binding"><% dish.price.formatCurrency() %></span>
              <a class="btn-add-to-cart"><i class="fa fa-plus-circle"></i></a>
            </div>
          </div>
          <!-- end ngRepeat: dish in category_dishes -->
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-lg-4 sticky">
  <div class="sidebar-right">

    <!-- widget -->
    <div class="widget">
      <h2 class="widget__title">Min order: <span class="price"><% restaurant.minOrderAmount.formatCurrency() %></span></h2>
      <div class="widget__content">

        <!-- widget-order -->
        <div class="widget-order">
          <div class="widget-order__item">
            <span class="widget-order__title">Choose service</span>
            <div class="widget-order__check_wrap">

              <div class="checkbox" ng-repeat="(key,value) in orderServices">
                <label class="custom-control custom-checkbox"
                        ng-click="selectService(key,{{$restaurant->deliveryCost}})" 
                      >
                  <input class="custom-control-input"
                        ng-required="1"
                         name="Services"
                         type="radio"
                         ng-checked="checkService(key)"
                         ng-value="key"
                        />
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description"><% value %></span>
                </label>
              </div>

            </div>
            <span class="widget-order__title">Choose payment</span>
            <div class="widget-order__check_wrap">

              <!-- checkbox -->
              <div class="checkbox" ng-repeat="(key,value) in orderPayments">
                <label class="custom-control custom-checkbox"
                        ng-click="selectPayment(key)"
                      >
                  <input class="custom-control-input"
                         name="Payments"
                         type="radio"
                         ng-checked="checkPayment(key)"
                         ng-value="key" />
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description"><% value %></span>
                </label>
              </div>              
            </div>
            @if($restaurant->take_red_bill)
            <div class="widget-order__title " >
                <label>
                  Take Red Invoice
                  <input name="checkBill" ng-checked="cart.checkbill" type="checkbox" value="1" ng-click="checkBill($event)">                   
                </label>
            </div>
            @endif
          </div>
          <div class="widget-order__item">
            <div class="widget-order__product">
              <div class="widget-order__product_list"
                   ng-repeat="(key,item) in cart.items | filter:{'free_item' : 0}"
                   >
                <input class="product__number"
                       style="width: 60px !important"
                       type="number"
                       ng-required="1"
                       ng-change="dishAmountChange(item.quantity, key);"
                       ng-model="item.quantity"
                       ng-model-options="{ debounce: 100 }" min="0"
                       ng-disabled="item.free_item">
                <span class="product__period">x</span>
                <h4 class="product__name" style="width: 28%">
                  <% item.name %>
                </h4>
                <div class="product__footer" style="float: right">
                  <span style="margin-left:-20px" class="product__price"><% item.price.formatCurrency() %></span>
                  <span style="margin-left:0px;" class="btn-del-product" ng-click="subtractFromCart(key)">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </div>
                <div class="product__subscription">
                  <div ng-repeat="option in item.options">
                    <strong>- <% option.option_name %>: <% option.quantity %> x <% option.price.formatCurrency() %></strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="widget-order__item">
            <div class="widget-order__total">
              <p>Subtotal:<span><% cart.sub_total.formatCurrency() %></span></p>
              <p ng-show="cart.promotion > 0">Promotion:<span><% cart.promotion.formatCurrency() %></span></p>
              <p>Tax <% cart.tax %>%: <span><% cart.tax_bill.formatCurrency() %></span></p>
              <p>Delivery fee:<span><% cart.delivery_fee.formatCurrency() %></span></p>
              <p class="disable" ng-if="hasNewPrice">
                Total: <span></span>
              </p>
              <p class="bigtotal">
                Total: <span><% cart.order_total.formatCurrency() %></span>
              </p>
              <textarea name="order_note"
                        cols="30"
                        rows="10"
                        placeholder="Order Note:"
                        ng-model="cart.order_note"
                        ng-change="saveCart()"
                        ng-model-options="{ debounce: 200 }"></textarea>
            </div>
          </div>
          <div class="widget-order__item">
            <div class="widget-order__btn_order">
              <a class="md-btn md-btn--danger md-btn--sm md-btn--outline-danger"
              data-toggle="modal" data-target="#cartModal">Full Detail</a>
            
              <button type="button" class="md-btn md-btn--danger md-btn--sm"
                  ng-click="chooseFreeItems()"
                  ng-disabled="cart.sub_total <= 0 || cart.sub_total < {{ $restaurant->minOrderAmount }}">Order now</button>
            
                  <div class="orderbox_alert row" ng-if="cart.sub_total <= 0 || cart.sub_total < {{ $restaurant->minOrderAmount }}">
                                                <span>Your order subtotal must be higher than min order amount</span>
                                        </div>
            </div>
          </div>
        </div><!-- End / widget-order -->

      </div>
    </div><!-- End / widget -->

  </div>
</div>
