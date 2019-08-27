<!-- Modal Header -->
<div class="modal-header text-center popup-border-none">
    <img src="/b2c-assets/img/icon1.png" alt="sms-icon" style="width: 10%;">
</div>

<!-- Modal body -->
<div class="modal-body ">
    <p class="text-center popup-notice">
        Dish price has been changed, do you want to apply new price?
    </p>
    <hr>
    <div class="text-center">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 title-custom">
                Dish name
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 title-custom">
                Old price
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 title-custom">
                New price
            </div>
        </div>
        <div class="row" ng-repeat="dishes_changed in dishes_changed_list">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <% dishes_changed.name %>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <% dishes_changed.old_price.formatCurrency() %>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <% dishes_changed.price.formatCurrency() %>
            </div>
        </div>
    </div>
</div>
