<div class="contact">
    <div class="row">
        <div class="contact-info col-md-12 col-xs-12">
            <h6>Contact info</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-xs-12 title form-group">
            <label>Title</label>
            <select name="title" ng-model="checkoutData.title" class="select2" required>
                <option value="" disabled selected>--</option>
                <option ng-repeat="(key,value) in title" value="<% key %>">
                    <% value %>
                </option>
            </select>
        </div>
        <div class="col-md-3 col-xs-12 full-name">
            <label>Full name</label>
            <input type="text" name="full-name" ng-model="checkoutData.full_name" placeholder="Enter your full name" required>
        </div>
        <div class="col-md-7 col-xs-12">
            <div class="row wigget-mobile-checkout">
                <div class="col-md-6 col-xs-12 email">
                    <label>Email</label>
                    <input type="email" name="email" ng-model="checkoutData.email" placeholder="Enter your email" required>
                </div>
                <div class="col-md-6 col-xs-12 phone">
                    <label>Phone</label>
                    <input type="tel" name="contact_phone" id="contact_phone" ng-model="checkoutData.phone" placeholder="Enter your phone" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 col-md-offset-5 col-xs-12">
            <div class="row wigget-mobile-checkout">
                <div class="col-md-6 col-xs-12 messaging-app">
                    <label>Messaging app</label>
                    <select class="select2" ng-model="checkoutData.messaging" required>
                        <option value="" disabled selected>--Choose your title--</option>
                        <option ng-repeat="(key,value) in messagingApp" value="<% key %>">
                            <% value %>
                        </option>
                    </select>
                    <input ng-if="checkoutData.messaging == 'other'" type="text" name="others" id="others" ng-model="checkoutData.other_app" />
                </div>
                <div class="col-md-6 col-xs-12 app-contact-info">
                    <label>App contact info</label>
                    <input type="text" id="app_contact_phone" name="app_contact_phone" ng-value="checkoutData.app_contact_info" ng-model="checkoutData.app_contact_info" placeholder="Phone/Email/Username" required>
                </div>
            </div>
        </div>
    </div>
</div>