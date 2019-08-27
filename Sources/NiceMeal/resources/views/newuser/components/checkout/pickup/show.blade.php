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
                    <label>Pickup time</label>
                </div>
                <div class="calender col-md-8 col-xs-8">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <input class="form-control input-calender note-date" autocomplete="off" name="special_date" type="text" placeholder="05-07-2019" value="" required ng-model="checkoutData.pickup_date">
                    <div class="dropdown modal-datepicker">
                        <button class="btn-calender" type="button" data-toggle="dropdown">
                            <i class="fa fa-chevron-down date-asap" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu" ng-click="changeDate()">
                            <li value="0">Spical date</li>
                            <li value="1">As soon as possible</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-1 col-xs-1 dash">-</div>
                <div class="col-md-3 col-xs-3 time">
                    <input class="form-control timepicker note-time" name="note-time" type="text" autocomplete="off" placeholder="18:00" ng-model="checkoutData.pickup_time">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <label>Order note</label>
            <input type="" name="order-note" placeholder="Wee will meet at the receptionsit..." ng-model="checkoutData.pickup_note">
        </div>
    </div>
</div>