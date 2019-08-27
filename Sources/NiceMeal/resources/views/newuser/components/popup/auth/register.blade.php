<!-- Modal -->
  <div class="modal fade modal-modal" id="myModalRegister" role="dialog" ng-controller="RegisterPopupCtrl">
    <div class="modal-dialog modal-dialog-login">
      <!-- Modal content-->
        <div class="modal-content modal-content-login">
            <div class="modal_header">
	          	<img src="/b2c-assets/img/logo_new.png"/></a>
	        </div>
            <div class="modal_body">
                <div class="title-form">
                    <div class="row ">
	        			<div class="col-icon col-sm-5">
	        				<p class="fa fa-arrow-left" data-dismiss="modal"></p>
	        			</div>
	        			<div class="col-sm-7" style="left:-30px">
	        				<h5 class="title-text-register">Sign up</h5>
	        			</div>
	        		</div>
                </div>
                <div class="form_body-register">
                    <form class="form-register" name="registerForm" method="POST" ng-submit="requestRegister()">
                        <div class="form-group full_name">
                            <label>Full name</label>
                            <input type="text" class="form-control" ng-model="full_name" placeholder="ex:Matt Matthew" required="required" id="full_name" name="full_name">
                        </div>
                        <div class="form-group email">
                            <label>Email</label>
                            <input type="email" class="form-control" style="margin-left: 0;" ng-model="email" required="required" id="email" name="email" aria-describedby="emailHelp" placeholder="ex:Matt@nicemael.com">
                        </div>
                        <div class="form-group phone">
                            <label>Phone</label>
                            <input class="form-control" type="tel" ng-model="phone" name="phone" id="phone" required="required" onkeypress="return isNumber(event)">
                        </div>
                        <div class="form-group password">
                            <label>Passwords</label>
                            <input class="form-control" type="password" ng-model="password" id="password-field" required minlength="8" maxlength="32" name="password">
                        </div>
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input class="form-control" id="password-confirm" ng-model="password_confirmation" type="password" required="required" name="password_confirmation">
                        </div>
                        <!-- avatar
                        <div class="form-group">
                            <label>Avatar</label>
                            <input class="form-control" type="file" multiple onchange="angular.element(this).scope().fileNameChanged(this)">
                        </div> -->
                        <button type="submit" class="btn btn-submit" ng-disabled="requesting" style="margin-top: 15px;" id="submit-btn">Sign up</button>
                    </form>
                </div>
            </div> 
        </div> 
    </div>
  </div>

