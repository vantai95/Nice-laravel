<!-- Modal Header -->
<div class="modal-header text-center popup-border-none">
    <img src="/b2c-assets/img/icon1.png" alt="sms-icon" style="width: 10%;">
</div>

<!-- Modal body -->
<div class="modal-body ">
    <p class="text-center popup-notice">
        Dish has been disappeared, please refresh to apply!
    </p>
    <div class="row">
        <div class="col-lg-12 text-center" ng-repeat="dishes_disappear in dishes_disappear_list">
            <b><% dishes_disappear.name%></b>
        </div>
    </div>
    <hr>
</div>