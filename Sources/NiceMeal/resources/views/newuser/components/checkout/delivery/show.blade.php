<div class="note">
    <div class="row">
        <div class="note-info col-md-12 col-xs-12">
            <h6>Note</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-xs-12 delivery-time">
            <div class="row wigget-mobile-checkout">
                <div class="col-md-12 col-xs-12">
                    <label>Delivery time</label>
                </div>
                <div class="calender col-md-8 col-xs-8">
                    <i class="fa fa-calendar deli" aria-hidden="true"></i>
                    <input ng-model="checkoutData.specific_date" class="form-control input-calender note-date" autocomplete="off" name="special_date" type="text" required>
                    <div class="dropdown modal-datepicker">
                        <button class="btn-calender" type="button" data-toggle="dropdown">
                            <i class="fa fa-chevron-down date-asap" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li id="deli_special" ng-click="deliverySpecialSelection()">Special date</li>
                            <li id="deli_asap" ng-click="deliveryAsapSelection()">As soon as possible</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-1 col-xs-1 dash">-</div>
                <div class="col-md-3 col-xs-3 time">
                    <input ng-model="checkoutData.specific_time" class="form-control timepicker note-time" name="note-time" type="text" autocomplete="off" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <label>Order note</label>
            <input type="text" name="order-note" placeholder="Please don't ring the bell" ng-model="checkoutData.delivery_note">
        </div>
    </div>
</div>