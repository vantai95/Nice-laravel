<!-- Modal -->
<div class="modal fade modal-like" id="PopupAddToCart" role="dialog">
      <div class="modal-dialog modal-dialog-like">
      <!-- Modal content-->
            <div class="modal-content modal-content-like">
                  <div class="modal_header row">
                        <div class="col-md-6 col-sm-6 request-txt">
                              <label class="text-head">REQUEST</label>
                        </div>
                        <div class="col-md-6 col-sm-6 icon-close">
                             <button type="button" class="close-btn" data-dismiss="modal">X</button>
                        </div>
                  </div>
                  <div class="modal_body info-add-to-cart" ng-init="tab=1">
                        <h5 class="title-body"><% selectedDish.name %><i class="fa fa-heart-o icon-heart" aria-hidden="true"></i></h5>
                        <div ng-show="tab == 2"><p class="title-text" style="font-size: 13px;" ng-bind-html="selectedDish.description | trustHtml"></p></div>
                        <div ng-show="tab == 1" >
                              <img ng-if="selectedDish.dish_image == null || images == '' " src='/b2c-assets/img/dish.png' style="width: 100%;height: 120px;">

                              <img ng-if="selectedDish.dish_image != null && check == 0" src="{{config('filesystems.disks.azure.url').'/'}}<% images %>" style="width: 100%;height: 120px;"> 

                              <div ng-if="selectedDish.dish_image != null && check == 1">
                                    <img src="{{config('filesystems.disks.azure.url').'/'}}<% images[currentIndex] %>" style="width: 100%;height: 120px;">

                                    <dir class="row slide-show-img" style="margin-top: -22%;">
                                          <div class="col-md-6 col-md-offset-10" style="margin-left: -11%;">
                                                <button class="btn-slide-show" style="background: none;border: none;" ng-click="prev()">
                                                      <i class="fa fa-chevron-left icon-slide" aria-hidden="true" style="color: black;font-size: 3vh;"></i>
                                                </button>
                                          </div>
                                          <div class="col-md-6 col-md-offset-10" style="margin-top: -8%;">
                                                <button class="btn-slide-show" style="background: none;border: none;" ng-click="next()">
                                                      <i class="fa fa-chevron-right icon-slide" aria-hidden="true" style="color: black;font-size: 3vh;"></i>
                                                </button>
                                          </div>
                                    </dir>                             
                              </div>   
                        </div>
                        <div class="row" style="padding-top: 12%;">
                              <div class="col-md-6 icon-show">
                                    <div class="tab" ng-class="{selected: tab==1}" ng-click="tab = 1"><i class="fa fa-file-image-o" aria-hidden="true" ng-hide="tab == 1"></i></div>
                                    <div class="tab" ng-class="{selected: tab==2}" ng-click="tab = 2"><i class="fa fa-file-text-o" aria-hidden="true" ng-hide="tab == 2"></i></div>
                              </div>
                              <div class="col-md-6">
                                      <span class="title-price"><% selectedDish.price.formatCurrency() %></span>  
                              </div>
                        </div>
                  </div>
                  {{--<div class="dropdown <% customizationSelected(dish_customization.customization_id) ? '' : 'un' %>selected-customization" ng-repeat="dish_customization in getCustomizations()">--}}
                        {{--<a href="#custom_<% dish_customization.id %>" class="btn customization row" data-toggle="collapse">--}}
                              {{--<div class="col-sm-6 customization-name"><% renderCustomization(dish_customization.customization_id).name %></div>--}}
                              {{--<div class="col-sm-4 customization-price" ng-if="customizationSelected(dish_customization.customization_id)"><% customizationTotalCalculate(dish_customization.customization_id) %></div>--}}
                              {{--<div class="col-sm-2 col-sm-offset-11 icon-down">--}}
                                    {{--<i class="fa fa-chevron-down icon-down-chevren icon-heart" aria-hidden="true"></i></div>--}}
                        {{--</a>--}}
                        {{--<div id="custom_<%dish_customization.customization_id %>" class="collapse collapse-option">--}}
                            {{--<div class="row option <% optionSelected(option.id) ? 'option--selected' : '' %>" ng-repeat="option in renderCustomization(dish_customization.customization_id).options" ng-click="selectOption(option)" style="padding-left: 20px;">--}}
                              {{--<div class="col-sm-6"><% option.name %></div>--}}
                              {{--<div class="col-sm-6"><% option.price.formatCurrency() %></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                  {{--</div>--}}

                  <div class="dropdown <% customizationSelected(dish_customization.id) ? '' : 'un' %>selected-customization" ng-repeat="dish_customization in selectedCustomizations">
                        <a href="#custom_<% dish_customization.id %>" class="btn customization row" data-toggle="collapse">
                              <div class="col-sm-6 customization-name"><% dish_customization.name %></div>
                              <div class="col-sm-4 customization-price"><% dish_customization.id %></div>
                              <div class="col-sm-2 col-sm-offset-11 icon-down">
                                    <i class="fa fa-chevron-down icon-down-chevren icon-heart" aria-hidden="true"></i></div>
                        </a>
                        <div id="custom_<%dish_customization.id %>" class="collapse collapse-option">
                              <div class="row option <% optionSelected(option.id) ? 'option--selected' : '' %>" ng-repeat="option in dish_customization.options" ng-click="selectOption(option)" style="padding-left: 20px;">
                                    <div class="col-sm-6"><% option.name %></div>
                                    <div class="col-sm-6"><% option.price.formatCurrency() %></div>
                              </div>
                        </div>
                  </div>
                  <div class="text-note">
                        <textarea class="details-note" name="message" rows="10" cols="30">No spicy, no mayonise ...
                        </textarea>
                  </div>
                  <div class="row quantity-add-to-cart">
                        <div class="col-sm-6 title-quantity">
                              Quantity
                        </div>
                        <div class="col-sm-6 col-sm-offset-8 quantity buttons_added">
                              <button type="button" ng-click="addToCartItemQuantityChange(-1)" class="minus"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                              <input type="number" step="1" min="1" max="" ng-model="selectedDish.quantity" ng-change="addToCartItemQuantityChange()" name="quantity" value="<% selectedDish.quantity %>" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="" style="">
                               <button type="button" ng-click="addToCartItemQuantityChange(1)" class="plus"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                  </div>
                  <div class="btn-add-to-cart">
                        <button type="button" ng-click="addToCart()"  class="btn-submit">Add to cart
                        <span class="price-total"><% itemTotalCalculate() %></span>
                        </button>
                  </div>
            </div>
      </div>
</div>