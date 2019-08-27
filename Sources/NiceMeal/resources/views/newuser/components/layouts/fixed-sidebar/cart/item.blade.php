<div class="fixed-sidebar-content-cart-items fixed-sidebar-content-cart-items-pd" ng-repeat="item in cart.items" style="font-size: 10px; border-bottom: none">
     <div class="row">
         <div class="col-lg-3 col-md-12 col-sm-12" style="padding-left: 7px;">
             <input ng-change="dishAmountChange(item.quantity,$index)" ng-model="item.quantity" type="text" style="font-size: 12px;width:25px;height:25px;padding:0px 0px 0px 5px;" name=""
                    value="<% item.quantity %>">
         </div>
         <div class="col-lg-9 col-md-12 col-sm-12 row item-info-section item-name-price-pd">
             <div class="col-lg-1" style="padding-left: 0">
                 x
             </div>
             <div class="col-lg-5 col-md-12 col-sm-12 text-wrapping px-0">
                 <% item.name %>
             </div>
             <div class="col-lg-5 col-md-12 col-sm-12 px-0">
                 <div> <% itemTotalCalculate(item) %><span class="text-danger delete-item-sign" style="cursor:pointer;" ng-click="subtractFromCart($index)">X</span></div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-2 col-md-12 col-sm-12"></div>
         <div class="col-lg-10 col-md-12 col-sm-12">
             <span class="text-wrapping description"></span>
         </div>
     </div>
 </div>
