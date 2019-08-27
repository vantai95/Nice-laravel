<div class="delivery">
    <div class="row">
        <div class="delivery-info col-md-12 col-xs-12">
            <h6>Delivery info</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-12 title form-group residence-type">
            <label>Residence type</label>
            <select class="select2" name="type" ng-model="checkoutData.residencetype" required ng-change="CheckResidenceType('delivery')">
                <option value="" disabled selected>--Choose your title--</option>
                <option ng-repeat="(key,value) in residencetypes" value="<% key %>">
                    <% value %>
                </option>
            </select>
        </div>
        <div class="col-md-8 col-xs-12 full-address">
            <label>Full address</label>
            <input type="text" name="full-address" ng-model="checkoutData.address.full_address" placeholder="Enter your full address" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="compound-show hiden-residence-name" style="display: none;">
                <label>Compound name</label>
                <input type="text" name="compound-name" ng-model="checkoutData.delivery_compound" placeholder="The Incontinental">
            </div>
            <div class="hotel-show hiden-residence-name" style="display: none;">
                <label>Hotel name</label>
                <input type="text" name="hotel-name" ng-model="checkoutData.delivery_hotel">
            </div>
            <div class="building-show hiden-residence-name" style="display: none;">
                <label>Building name</label>
                <input type="text" name="building-name" ng-model="checkoutData.delivery_building" placeholder="Diamond plaza">
            </div>
        </div>
        <div class="col-md-8 col-xs-12 align-self-end">
            <div class="row wigget-mobile-checkout">
                <div class="col-md-6 col-xs-12 district">
                    <label>District</label>
                    <select id="delivery_district" ng-model="checkoutData.delivery_district" ng-required="true"
                            name="delivery_district" required>
                        <option value="" disabled selected>--Select district--</option>
                        <option ng-repeat="(key,value) in res_deli_setting" value="<% value.district_id %>">
                            <% value.district_name %>
                        </option>
                        {{--<option value="<% restaurant.district_id %>"><% restaurant.districtName %></option>--}}
                    </select>
                </div>
                <div class="col-md-6 col-xs-12 ward">
                    <label>Ward</label>
                    <select id="delivery_ward" ng-required="true" ng-init="checkoutData.delivery_ward = {{ $wardSelected }}" class="select2" name="delivery_ward" ng-model="checkoutData.delivery_ward">
                        <option value="" disabled selected>--Select ward--</option>
                        <option ng-repeat="ward in getDeliveryWard(checkoutData.delivery_district)" value="<% ward.ward_id %>">
                             <% ward.ward_name %>
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="hiden-residence-name building-show" style="display: none;">
                <label>Block/Tower</label>
                <input type="text" name="block-tower" ng-model="checkoutData.delivery_block">
            </div>
            <div class="hiden-residence-name compound-show" style="display: none;">
                <label>House number</label>
                <input type="text" name="house-number" ng-model="checkoutData.delivery_house">
            </div>
        </div>
        <div class="col-md-8 col-xs-12 hiden-residence-name floor-room" style="display: none;">
            <div class="row wigget-mobile-checkout">
                <div class="col-md-6 col-xs-12 floor">
                    <label>Floor</label>
                    <input type="text" name="floor" ng-model="checkoutData.delivery_floor">
                </div>
                <div class="col-md-6 col-xs-12 room">
                    <label>Room</label>
                    <input type="text" name="room" ng-model="checkoutData.delivery_room">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <label>Direction</label>
            <input type="text" ng-model="checkoutData.address.direction" name="direction" placeholder="Near ABC supermarket">
        </div>
    </div>
</div>