<div class="payment">
    <div class="row">
        <div class="payment-info col-md-12 col-xs-12">
            <h6>Payment</h6>
        </div>
    </div>
    <div class="row" id="deposit_section">
        <div class="col-lg-4 col-md-4 col-xs-12" ng-if="getService() == 'book_table'">
            <label>Deposit</label>
            <input ng-model="checkoutData.payment_deposit" type="text" name="deposit" id="deposit" placeholder="350.000đ">
        </div>
    </div>
    <div class="row">
        <input type="text" name="payment_method" ng-value="checkoutData.payment_method" id="payment_method" ng-model="checkoutData.payment_method" style="display: none;">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-10 payment-mg" id="cash_icon" ng-click="choosePayment('cash')">
            <img class="payment-img-pd" src="/b2c-assets/img/money.png" alt="money_icon">
            <p class="payment-title">Cash</p>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-10 payment-mg" id="paypal_icon" ng-click="choosePayment('paypal')">
            <img class="payment-img-pd" src="/b2c-assets/img/paypal_icon.png" alt="paypal_icon"
                 style="padding-bottom: 1px">
            <p class="payment-title">PayPal</p>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-10 payment-mg" id="nganluong_icon" ng-click="choosePayment('nganluong')">
            <img class="payment-img-pd" src="/b2c-assets/img/nganluong.png" alt="nganluong_icon">
            <p class="payment-title">Ngân lượng</p>
        </div>
    </div>
    <div id="payment_section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="">Prepare the change for</label>
                <input ng-model="checkoutData.payment_prepare" type="text" name="prepare_change" id="prepare_change" placeholder="350.000 đ">
            </div>
            <!-- <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 payment-pickup-time">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 payment-pickup-time" ng-if="getService() == 'book_table'">
                <div class="row wigget-mobile-checkout">
                    <div class="col-md-12 col-xs-12">
                        <label>Delivery time</label>
                    </div>
                    <div class="calender col-md-8 col-xs-8">
                        <i class="fa fa-calendar payment-section" aria-hidden="true" ng-show="checkoutData.payment_date !='As soon as possible'"></i>
                        <input ng-model="checkoutData.payment_date" class="form-control input-calender" id="payment-note-date" autocomplete="off"
                               name="payment_special_date" type="text" required>
                        <div id="payment-modal-datepicker" class="dropdown">
                            <button class="btn-calender" type="button" data-toggle="dropdown">
                                <i class="fa fa-chevron-down date-asap" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li id="payment_special" ng-click="deliveryPaymentSpecialSelection()">Special date</li>
                                <li id="payment_asap" ng-click="deliveryPaymentAsapSelection()">As soon as possible</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-1 col-xs-1 dash" ng-show="checkoutData.payment_date !='As soon as possible'">-</div>
                    <div class="col-md-3 col-xs-3 time" ng-show="checkoutData.payment_date !='As soon as possible'">
                        <input ng-model="checkoutData.payment_time" class="form-control timepicker" id="payment-note-time" name="" type="text" autocomplete="off"  required>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="row" ng-if="getService() == 'book_table'">
            <div class="col-lg-4 col-md-4 col-xs-12 title form-group residence-type">
                <label>Residence type</label>
                <select class="select2" name="payment_delivery" ng-model="checkoutData.payment_delivery_type" required ng-change="CheckResidenceType('payment')">
                    <option value="" disabled selected>--Choose your title--</option>
                    <option value="house">House</option>
                    <option value="hotel">Hotel</option>
                    <option value="building">Building</option>
                    <option value="compound">Compound</option>
                </select>
            </div>
            <div class="col-lg-8 col-md-8 col-xs-12 full-address">
                <label>Full address</label>
                <input ng-model="checkoutData.payment_address" type="text" name="payment-address" placeholder="Enter your full address" required>
            </div>
        </div>
        <div class="row" ng-if="getService() == 'book_table'">
            <div class="col-md-4 col-xs-12">
                <div class="compound-show hiden-residence-name" style="display: none;">
                    <label>Compound name</label>
                    <input ng-model="checkoutData.payment_compound" type="text" name="payment-compound-name" placeholder="The Incontinental">
                </div>
                <div class="hotel-show hiden-residence-name" style="display: none;">
                    <label>Hotel name</label>
                    <input ng-model="checkoutData.payment_hotel" type="text" name="payment-hotel-name">
                </div>
                <div class="building-show hiden-residence-name" style="display: none;">
                    <label>Building name</label>
                    <input ng-model="checkoutData.payment_building" type="text" name="payment-building-name" placeholder="Diamond plaza">
                </div>
            </div>
            <div class="col-md-8 col-xs-12 align-self-end" >
                <div class="row wigget-mobile-checkout">
                    <div class="col-md-6 col-xs-12 district">
                        <label>District</label>
                        <select class="select2" id="payment_district" ng-model="checkoutData.payment_district" ng-required="true"
                                name="payment_district">
                            <option value="" disabled selected>--Select district--</option>
                            <option ng-repeat="(key,value) in res_deli_setting" value="<% value.district_id %>">
                                <% value.district_name %>
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 ward">
                        <label>Ward</label>
                        <select id="payment_ward" ng-required="true" ng-init="checkoutData.payment_ward = {{ $wardSelected }}" class="select2" name="payment_ward" ng-model="checkoutData.payment_ward">
                            <option value="" disabled selected>--Select ward--</option>
                            <option ng-repeat="ward in getDeliveryWard(checkoutData.payment_district)" value="<% ward.ward_id %>">
                                <% ward.ward_name %>
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" ng-if="getService() == 'book_table'">
            <div class="col-md-4 col-xs-12">
                <div class="hiden-residence-name building-show" style="display: none;">
                    <label>Block/Tower</label>
                    <input ng-model="checkoutData.payment_block" type="text" name="payment-block-tower">
                </div>
                <div class="hiden-residence-name compound-show" style="display: none;">
                    <label>House number</label>
                    <input ng-model="checkoutData.payment_house" type="text" name="payment-house-number">
                </div>
            </div>
            <div class="col-md-8 col-xs-12 hiden-residence-name floor-room" style="display: none;">
                <div class="row wigget-mobile-checkout">
                    <div class="col-md-6 col-xs-12 floor">
                        <label>Floor</label>
                        <input ng-model="checkoutData.payment_floor" type="text" name="payment-floor">
                    </div>
                    <div class="col-md-6 col-xs-12 room">
                        <label>Room</label>
                        <input ng-model="checkoutData.payment_room" type="text" name="payment-room">
                    </div>
                </div>
            </div>
        </div>
        <div class="row" ng-if="getService() == 'book_table'">
            <div class="col-md-12 col-xs-12">
                <label>Direction</label>
                <input ng-model="checkoutData.payment_direction" type="text" name="payment-direction" placeholder="Near ABC supermarket">
            </div>
        </div>
    </div>
</div>
