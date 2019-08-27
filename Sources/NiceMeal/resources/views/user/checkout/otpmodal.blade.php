<!-- Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" ng-if='cart.payment == "cod_payment"'>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" ng-if="!verified && !canceled && !dishes_changed && !dishes_disappear && !ordering">Please enter your OTP</h5>
        <h5 class="modal-title" ng-if="dishes_changed">These dishes was changed</h5>
        <h5 class="modal-title" ng-if="dishes_disappear">These dishes was disappear</h5>
      </div>
      <div class="modal-body">
        <div>

          <div class="form-group" ng-if="dishes_changed">
            <div class="row">
              <div class="col-lg-6">
                <h6>Dish name</h6>
              </div>
              <div class="col-lg-3">
                <h6>Cart price</h6>
              </div>
              <div class="col-lg-3">
                <h6>Current price</h6>
              </div>
            </div>

            <div class="row" ng-repeat="item in cart.items" ng-if="dishes_changed_list[item.id]">
              <div class="col-lg-6">
                <% item.name %>
              </div>
              <div class="col-lg-3">
                <% item.price.formatCurrency() %>
              </div>
              <div class="col-lg-3">
                <% dishes_changed_list[item.id].price.formatCurrency() %>
              </div>
            </div>

          </div>

          <div class="form-group" ng-if="dishes_disappear">
            <div class="row">
              <div class="col-lg-6">
                <h6>Dish name</h6>
              </div>
            </div>

            <div class="row" ng-repeat="item in cart.items" ng-if="dishes_disappear_list[item.id]">
              <div class="col-lg-6">
                - <% item.name %>
              </div>
            </div>
          </div>

          <div class="form-group" ng-if="canceled" style="text-align:center">
            <h6>You haven't confirm your OTP, please contact to restaurant to confirm your order</h6>
            <div>
              <span style="font-size:50px;">
                <i style="color:lightgreen;" class="fa fa-phone"></i> <% restaurant.phone | tel%>
              </span>
            </div>
            <div>
              <span style="font-size:35px;color:lightsalmon;">
                <a href="/restaurants/<% restaurant.slug %>">Continue ordering</a>
              </span>
            </div>
          </div>

          <div class="form-group"
            ng-if="verified"
            style="text-align:center">
            <h6>Thank you for ordering</h6>
            <div>
              <span style="font-size:80px;color:lightgreen;">
                <i class="fa fa-check-circle-o"></i>
              </span>
            </div>
            <div>
              <span style="font-size:35px;color:lightsalmon;">
                <a href="/restaurants/<% restaurant.slug %>">Continue ordering</a>
              </span>
            </div>
          </div>

          <div class="form-group" style="text-align:center" ng-if="ordering">
              <h1>
              <i class="fa fa-spinner fa-spin"></i>
              </h1>
          </div>
          <div class="form-group row" ng-if="!ordering && verifyData.order_id && !verified && !canceled">
            <div class="col-lg-12"><h6>OTP</h6></div>

            <div class="col-lg-2">
              <input type="text" class="form-control" disabled value="{{ App\Models\Order::OTP_PREFIX }}">
            </div>
            <div class="col-lg-10">
              <input type="text" class="form-control" ng-change="validateOTP()" ng-value="verifyData.otp" ng-model="verifyData.otp" name="otp_number">
            </div>
            <div class="col-lg-12">
              <h6 style="color:red"><% otp_error %></h6>
            </div>
            <div class="col-lg-12" ng-if="!verified && playPosition >= playDuration && send_left > 0">
              <h6 style="color:red">Your otp has been expired, please resend</h6>
            </div>
          </div>
          <track-progress-bar ng-if="!ordering && verifyData.order_id && !verified && !canceled"
          cur-val="<% playPosition %>"
          max-val="<% playDuration %>" >
          </track-progress-bar>
        </div>
      </div>

      <div class="modal-footer" ng-if="!ordering && verifyData.order_id && !verified && !canceled">
        <!-- <i class="fa fa-spinner fa-spin" ng-show="requesting"></i> -->
        <button ng-if="!verified && playPosition >= playDuration && send_left > 0" ng-disabled="resending" type="button" ng-click="resendOTP()" class="btn btn-danger">Resend OTP</button>
        <button ng-if="!verified" type="button" ng-click="confirmOTP()" class="btn btn-danger">Verify</button>
        <button ng-init="canceled = 0" ng-click="cancelOTP()" type="button" class="btn btn-default">Close</button>
      </div>

      <div class="modal-footer" ng-if="dishes_changed || dishes_disappear">
        <!-- <i class="fa fa-spinner fa-spin" ng-show="requesting"></i> -->
        <button ng-if="dishes_changed || dishes_disappear" ng-click="applyCurrentPriceToCart()" type="button" class="btn btn-danger">Apply</button>
        <button ng-if="dishes_changed || dishes_disappear" data-dismiss="modal" type="button" class="btn btn-default">Close</button>
      </div>
    </div>
  </div>
</div>