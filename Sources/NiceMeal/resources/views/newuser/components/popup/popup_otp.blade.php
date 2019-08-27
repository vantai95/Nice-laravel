<div class="modal fade modal-modal" id="otpModal" role="dialog" style="top: 25%;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="text-center" ng-if="requesting()">
                <p style="font-weight: bold; color: #000 !important;">
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                </p>
                <h4>
                    Loading
                </h4>
            </div>
            <!-- Order success -->
            <div id="order_success_section" ng-if="!requesting() && verified">
                <!-- Modal Header -->
                <div class="modal-header text-center popup-border-none">
                    <img src="/b2c-assets/img/header_icon.png" alt="sms-icon">
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center popup-order-success">
                        Many thanks for ordering
                        <br>
                        <span>Your meal will be delivered as soon as possible</span>
                    </p>
                    <div class="text-center">
                        <img src="/b2c-assets/img/happy.png" alt="">
                    </div>
                    <div class="row text-center" style="margin-top: 30px;">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <button type="button" class="btn btn-lets-eat" ng-click="backHome()">
                                <i class="fa fa-arrow-left"></i>
                                <span class="btn-lets-eat-pd-left" >LET'S EAT!!!</span>
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <button type="button" class="btn btn-discovery">
                                <span class="btn-discovery-pd-left">DISCOVERY</span>
                                <i class="fa fa-arrow-right right-arrow-pd"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Otp section -->
            <div id="otp_section" ng-if="!requesting() && verified == 0">
                <!-- Modal Header -->
                <div class="modal-header text-center popup-border-none">
                    <img src="/b2c-assets/img/sms.png" alt="sms-icon" style="width: 10%;">
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center popup-notice">
                        Please check your phone or email to get OTP number
                        <br>
                        <span class="contact-info">
                            <% checkoutData.phone %>
                        <br>
                            <% checkoutData.email %>
                            {{--handle when input otp wrong--}}
                            <br>
                            <span ng-if="otp_error">Oops! <% otp_error %>. Please try again</span>
                            <br>
                            <span ng-if="timeLeft == 0">OTP has been expired, please resend</span>
                        </span>
                    </p>
                    <p class="text-center">
                        <input class="otp-input" type="text" name="otp" id="otp" ng-model="verifyData.otp" placeholder="_ _ _ _" maxlength="4">
                        <span class="text-danger">Time left: <% timeLeft %></span>
                    </p>
                    <div class="text-center">
                        {{--use class btn-otp-after-click for waiting resend otp--}}
                        <button type="button" class="btn btn-otp-after-click">Resend OTP</button>
                        <button type="button" class="btn btn-resend-otp" ng-click="submitOtp()" >Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>