<!-- Modal -->
<div class="modal fade modal-modal" id="forgot-password" role="dialog" ng-controller="ForgotPopupCtrl" ng-app="myApp">
    <div class="modal-dialog modal-dialog-login">
        <!-- Modal content-->
        <div class="modal-content modal-content-login">
            <div class="modal_header">
                <img src="/b2c-assets/img/logo_new.png"/>
            </div>
            <div class="modal_body">
                <div class="title-form">
                    <div class="row">
                        <div class="col-icon col-sm-5">
                            <p class="fa fa-arrow-left" data-dismiss="modal"></p>
                        </div>
                        <div class="col-sm-7 forgot-pw-title-mg">
                            <h5 class="title-text-login">Forgot Password</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" class="form" ng-submit="requestForgot()">
                        @csrf
                        <div class="form-group email form_body-forgot">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="text" ng-model="email" style="margin-left: 0"
                                   class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email"
                                   ng-required="required">
                            <span id="error_message"></span>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-4" style="margin-bottom: 10vh;">
                                <button type="submit" ng-disabled="requesting" class="btn btn-submit" style="width: 100%;background-image: linear-gradient(#FFF200,#FCCF07);border: none;color: #D7011A;font-weight: 700;">
                                    Send Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
