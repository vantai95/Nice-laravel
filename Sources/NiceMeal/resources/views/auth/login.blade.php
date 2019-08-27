@extends('layouts.app')
@section('content')
    <div id="page-login" class="md-content ng-scope">
        <section class="login__section">
            <div class="md-tb">
                <div class="container">
                    <div class="row login-row">
                        <div class="col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-1 form-login" style="margin-left: 17%;">
                          <!--  <div class="col-md-4">
                          <?php
                          $showFormLogin=true;
                          foreach ($errors->all() as $error)
                          {
                              if( strpos( $error, 'Register - ' ) !== false ) 
                                  $showFormLogin = false;
                                                            
                          }
                          ?>
                             @if($showFormLogin)
                                                    <h4 class="textCenter" id="pageTitle">@lang('b2c.login.title')</h4>
                                                    <p class="textCenter" id="pageDes">@lang('b2c.login.title_des')</p>
                                                       @else                               
                                                    <h4 class="textCenter" id="pageTitle">@lang('b2c.register.title')</h4>
                                                    <p class="textCenter" id="pageDes">@lang('b2c.register.title_des')</p>
                                                       @endif
                                                    <div class="textCenter"><a href="#"><img src="{{url("/b2c-assets/img")}}/{{ CommonService::getLogo()}}"></a></div>
                          </div> -->
                            <div class="col-md-8" style="">
                                <div class="login__panel" style="">
                                    <div class="col-md-12 logo-header">
                                       <!--  <ul style="cursor: pointer; display: flex">
                                           @if($showFormLogin)
                                               <li class="active" id="tabLogin">
                                                   <a>@lang('b2c.login.title')</a>
                                               </li>
                                               <li  id="tabRegister">
                                                   <a ui-sref="pageRegister"
                                                   href="javascript:void()">@lang('b2c.login.register')
                                                   </a>
                                               </li>
                                           @else
                                               <li  id="tabLogin">
                                                   <a>@lang('b2c.login.title')</a>
                                               </li>
                                               <li  class="active" id="tabRegister">
                                                   <a ui-sref="pageRegister"
                                                   href="javascript:void()">@lang('b2c.login.register')
                                                   </a>
                                               </li>
                                           @endif
                                       </ul> -->
                                       <img src="{{ asset('b2c-assets/img/logo_new.png') }}" class="logo-new" style="" /></a>
                                    </div>
                                    <div class="col-md-12 title-form-login" style="">
                                        <div class="title-form">
                                            <div class="row title-form-login">
                                                <div class="col-icon col-sm-5">
                                                    <a href="{{ url('/') }}"><p class="fa fa-arrow-left" style=""></p></a>
                                                </div>
                                                <div class="col-title col-sm-7">
                                                    <?php
                                                      $showFormLogin=true;
                                                      foreach ($errors->all() as $error)
                                                      {
                                                          if( strpos( $error, 'Register - ' ) !== false )   
                                                              $showFormLogin = false;
                                                                                        
                                                      }
                                                      ?>
                                                         @if($showFormLogin)
                                                        <h5 class="title-text-login" id="pageTitle" style="">Login</h5>
                                                       @else                               
                                                        <h5 class="title-text-login" id="pageTitle" style="">Sign up</h5>
                                                       @endif
                                                        <!-- <div class="textCenter"><a href="#"><img src="{{url("/b2c-assets/img")}}/{{ CommonService::getLogo()}}"></a></div> -->
                                                    <!-- <h5 class="title-text-login" id="pageTitle" style="">Login</h5> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 login-form">
                                        <form method="post" action="{{ route('login') }}"
                                              class="ng-pristine ng-invalid ng-invalid-required"
                                              name="formLogin" id="formLogin" @if(!$showFormLogin) style="display:none;margin-top: -10px;" @endif >
                                            @csrf
                                            <div class="form-group col-md-12">
                                                <!-- <div class="col-md-3">
                                                    <span class="form-control">@lang('b2c.login.username')</span>
                                                </div> -->
                                                <label class="text-form-detail" style="">Email address</label>
                                                <div class="col-md-12">
                                                    <input style="margin: 0px;height: 40px;" type="text" id="email" name="email"
                                                           placeholder="{{trans('b2c.login.place_holder.username')}}"
                                                           class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"
                                                           required="">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <!-- <div class="col-md-3">
                                                    <span class="form-control">@lang('b2c.login.password')</span>
                                                </div> -->
                                                <label class="text-form-detail">Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" id="password"
                                                           name="password"
                                                           placeholder="{{trans('b2c.login.place_holder.password')}}"
                                                           class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"
                                                           required="" style="height: 40px;">
                                                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                           <div class="col-md-12 separator-login" style="">
                                                <div class="separator" style=""> 
                                                    <span class="separator-text" style="">or</span>
                                                </div>
                                           </div>
                                            <div class="col-md-12 btn-btn-login">
                                                <a class="md-btn md-btn--facebook col-md-10 col-xs-12 btnLogin"
                                                   style="padding-left: 50px;padding: 10px 13px;width: 92%;"
                                                   href="{{ URL::to('auth/facebook') }}">
                                                    <i class="fa fa-facebook"></i>
                                                    <span>@lang('b2c.login.login_facebook')</span></a>
                                            </div>
                                            <div class="col-md-12 btn-btn-login">
                                                <a class="md-btn md-btn--google col-md-10 col-xs-12 btnLogin"
                                                   style="padding-left: 50px;padding: 10px 13px;width: 92%;background: white;color: black;"
                                                   href="{{ URL::to('auth/google') }}">
                                                    <i class="fa fa-google"></i>@lang('b2c.login.login_google')
                                                </a>
                                            </div>
                                            <div class="col-md-12 btn-btn-login" style="margin-top: 8%;">
                                                <button type="submit" class="md-btn md-btn--primary col-md-10 col-xs-12 btnLogin btn-btn-sub" style="padding: 7px 13px;width: 92%;background: linear-gradient(#FFF200,#FCCF07);color: #D7011A;">@lang('b2c.login.sign_in_btn')</button>
                                            </div>
                                            <div class="col-md-12 text-link" style="margin-bottom: -14px;">
                                                <div class="col-md-6">
                                                    <p style="">
                                                        <a  class="forgot-password" ui-sref="pageInitForgot" style=""
                                                           href="{{ url('password/forgot-password') }}">
                                                            Forgot passwords?
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p style="">
                                                   <a class="create-account" id="tabRegister" ui-sref="pageRegister"
                                                   href="javascript:void()" style="">Create Account
                                                   </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </form>

                                        <form @if($showFormLogin) style="display:none" @endif  class="register-form" method="POST" action="{{ route('register') }}"
                                                  name="formRegister" id="formRegister">
                                                @csrf
                                                <div class="form-group col-md-12">
                                                    <label class="text-form-detail" style="">Full name<strong class="red">*</strong></label>
                                                    <div class="col-md-12">
                                                        <input type="text"
                                                               placeholder="{{trans('b2c.register.place_holder.full_name')}}"
                                                               class="form-control" required="required"
                                                               id="full_name" name="full_name">
                                                        {!! $errors->first('full_name', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="text-form-detail" style="">Email<strong class="red">*</strong></label>
                                                    <div class="col-md-12">
                                                        <input type="email" style="margin: 0px"
                                                               placeholder="{{trans('b2c.register.place_holder.email')}}"
                                                               class="form-control" required="required"
                                                               id="email" name="email">
                                                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="text-form-detail" style="">Phone number<strong class="red">*</strong></label>
                                                    <div class="col-md-12">
                                                        <input type="tel" name="phone"
                                                               onkeypress="return isNumber(event)" minlength="10" maxlength="10"
                                                               placeholder="{{trans('b2c.register.place_holder.phone')}}"
                                                               class="form-control" id="phone" required="required">
                                                        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="text-form-detail" style="">Password<strong class="red">*</strong></label>
                                                    <div class="col-md-12">
                                                        <input type="password" id="password-field"
                                                               placeholder="{{trans('b2c.register.place_holder.password')}}"
                                                               class="form-control" required minlength="8"
                                                               maxlength="32"
                                                               name="password">
                                                        <p class="text-danger d-none" id="message-valid-password">@lang('b2c.register.message_valid_password')</p>
                                                        {!! $errors->first('password', '<p class="help-block help-block-message">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="text-form-detail" style="">Confirm password<strong class="red">*</strong></label>
                                                    <div class="col-md-12">
                                                        <input id="password-confirm"
                                                               placeholder="{{trans('b2c.register.place_holder.confirm_password')}}"
                                                               type="password" class="form-control" required="required"
                                                               name="password_confirmation">
                                                        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <div class="col-md-4" style="color: white;">
                                                        <span class="form-control">@lang('b2c.register.gender')
                                                            <strong class="red" style="color: white;">*</strong></span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="checkbox">
                                                            <label class="custom-control custom-checkbox"
                                                                   style="margin-right: 20px">
                                                                <input class="custom-control-input" required
                                                                       name="gender"
                                                                       type="radio"
                                                                       value="male"/>
                                                                <span class="custom-control-indicator" style="color: white;"></span>
                                                                <span class="custom-control-description" style="color: white;">@lang('b2c.register.male')</span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" required
                                                                       name="gender"
                                                                       type="radio"
                                                                       value="female"/>
                                                                <span class="custom-control-indicator" style="color: white;"></span>
                                                                <span class="custom-control-description" style="color: white;">@lang('b2c.register.female')</span>
                                                            </label>
                                                        </div>
                                                        <div>{!! $errors->first('gender', '<p class="help-block">:message</p>') !!}</div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <div class="col-md-3" style="color: white;">
                                                        <span class="form-control">@lang('b2c.register.birthday')
                                                            <strong class="red" style="color: white;">*</strong></span>
                                                    </div>
                                                    <div class="col-md-3 ui-select-box" style="margin-bottom: 10px">
                                                        <select class="form-control" id="sel1" name="day" required>
                                                            <option selected disabled
                                                                    value="">@lang('b2c.register.day')</option>
                                                            @for($i=1;$i<=31;$i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 ui-select-box" style="margin-bottom: 10px">
                                                        <select class="form-control" style="padding-right:0;" id="sel2"
                                                                name="month" required>
                                                            <option selected disabled
                                                                    value="">@lang('b2c.register.month')</option>
                                                            @for($i=1;$i<=12;$i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 ui-select-box">
                                                        <select class="form-control" id="sel3" name="year" required>
                                                            <option selected disabled
                                                                    value="">@lang('b2c.register.year')</option>
                                                            @for($i=1970;$i<=2018;$i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-md-9 col-md-offset-3">
                                                        @if ( $errors->has('day') || $errors->has('month') || $errors->has('year') )
                                                            <p class="help-block">@lang('auth.register.validate_birth_day')</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-12"></div>
                                                <div class="col-md-12">
                                                    <div class="col-md-9 col-md-offset-3 textCenter">
                                                        <p style="margin-left: 10px;color: white;" >
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="term_policy"
                                                                       class="custom-control-input term-policy-btn"
                                                                       value="true" required="required">
                                                                <span class="custom-control-indicator"></span>
                                                            </label>
                                                            @lang('b2c.register.term_policy_des')
                                                            <a style="cursor: pointer;color: white;"> @lang('b2c.register.term_policy')</a>
                                                        </p>
                                                    </div>
                                                    {!! $errors->first('term_policy', '<p class="help-block">:message</p>') !!}
                                                </div>

                                                <div class="col-md-12 textCenter">
                                                    <button type="submit" disabled="disabled" id="submit-btn"
                                                            class="md-btn md-btn--primary col-md-10 register-btn btnLogin" style="color: white;width: 93%;background: linear-gradient(#FFF200,#FCCF07);" 
                                                            >@lang('b2c.register.register_btn')</button>
                                                </div>
                                                <div class="clearfix"></div>
                                            </form>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('user.social-tools')
    </div>
@endsection

@section('extra_scripts')
    <script>
        $('#tabRegister').click(function(){
            $(this).addClass('active');
            $("#tabLogin").removeClass('active');
            $("#formLogin").hide();
            $("#formRegister").show();
            $("#pageTitle").html();
            $("#pageDes").html();     
            $("#pageTitle").html('@lang('Sign up')');
            $("#pageDes").html('@lang('b2c.register.title_des')'); 
        });

        $("#tabLogin").click(function(){
            $(this).addClass('active');
            $("#tabRegister").removeClass('active');
            $("#formLogin").show();
            $("#formRegister").hide();
            $("#pageTitle").html('@lang('b2c.login.title')');
            $("#pageDes").html('@lang('b2c.login.title_des')');     
        });

        function isNumber(evt) {
             evt = (evt) ? evt : window.event;
             var charCode = (evt.which) ? evt.which : evt.keyCode;

             if(charCode == null) {
                 if(evt.match(/\d{10}/)) {
                     return true;
                 }
                 return false;
             } else {
                 if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                     return false;
                 }
                 return true;
             }
        }

        $(document).ready(function () {
            $(".term-policy-btn").click(function () {
                if($('input[name=term_policy]:checked').length > 0) {
                    if($('#submit-btn').is('[disabled=disabled]')) {
                        $('#submit-btn').prop('disabled', false);
                    } else {
                        $('#submit-btn').prop('disabled', false);
                    }
                } else {
                    if($('#submit-btn').is('[disabled=disabled]')) {
                        $('#submit-btn').prop('disabled', true);
                    } else {
                        $('#submit-btn').prop('disabled', true);
                    }
                }
            });

            $('#password-field').on('blur', function() {
                var passVal = checkStrongPassword($('#password-field').val());

                if(passVal == true ) {
                    $('#message-valid-password').css('display','none');
                    $('.help-block-message').css('display','none');
                    $('#submit-btn').prop('disabled', false);
                } else {
                    $('#message-valid-password').css('display','block');
                    $('.help-block-message').css('display','none');
                    $('#submit-btn').prop('disabled', true);
                }
            });

            $('#phone').on('blur', function () {
                if($('#phone').val() != '') {
                    var phoneVal = isNumber($('#phone').val());

                    if(phoneVal == true) {
                        $('#phone').val($('#phone').val());
                    } else {
                        $('#phone').val('');
                    }
                } else {
                    $('#phone').val('');
                }
            });
        });
    </script>
@endsection
