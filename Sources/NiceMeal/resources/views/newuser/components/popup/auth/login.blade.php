<!-- Modal -->
<div class="modal fade modal-modal" id="myModalLogin" role="dialog" ng-controller="LoginPopupCtrl">
    <div class="modal-dialog modal-dialog-login">
        <!-- Modal content-->
        <div class="modal-content modal-content-login">
            <div class="modal_header">
                <img src="{{ asset('b2c-assets/img/logo_new.png') }}"/>
            </div>
            <div class="modal_body">
                <div class="title-form">
                    <div class="row">
                        <div class="col-icon col-sm-5">
                            <p class="fa fa-arrow-left" data-dismiss="modal"></p>
                        </div>
                        <div class="col-sm-7">
                            <h5 class="title-text-login">Login</h5>
                        </div>
                    </div>
                </div>
                <form method="POST" class="form" ng-submit="requestLogin()">
                    <div class="form_body-login">
                        <div class="form-group email">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="text" ng-model="email" style="margin-left: 0"
                                   class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email"
                                   required="">
                        </div>
                        <div class="form-group password" style="padding-bottom: 15px;">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="password" name="password" ng-model="password"
                                   placeholder="{{trans('b2c.login.place_holder.password')}}"
                                   class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   required="">
                        </div>
                        <div class="separator">
                            <span class="separator-text">or</span>
                        </div>
                        <div class="facebook">
                            <a class="md-btn md-btn--facebook"
                               style="width: 100%;"
                               href="{{ URL::to('auth/facebook') }}">
                                <i class="fa fa-facebook"></i>
                                <span>@lang('b2c.login.login_facebook')</span></a>
                        </div>
                        <div class="gmail">
                            <a class="md-btn md-btn--google col-md-10 col-xs-12"
                               style="background: white;color: black;width: 100%;"
                               href="{{ URL::to('auth/google') }}">
                                <i class="fa fa-google"></i>@lang('b2c.login.login_google')
                            </a>
                        </div>
                    </div>
                    <div class="modal_footer" style="">
                        <button type="submit" ng-disabled="requesting" class="btn btn-submit">Sign up</button>
                        <div class="row footer-text">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <a href="#" id="registerBtn" name="registerBtn">Don't have account?</a>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <a href="#" id="forgotBtn" name="forgotBtn" class="flr-text">Forgot Password?</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
