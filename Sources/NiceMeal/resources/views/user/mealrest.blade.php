@extends('layouts.app_mealrest')
@section('content')
    <div class="md-content ng-scope">
        <section class="login__section">
            <div class="md-tb">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-1">
                            <div class="col-md-4">
                                <h4 class="textCenter" id="pageTitle">@lang('b2c.login.title')</h4>
                                <p class="textCenter" id="pageDes">@lang('b2c.login.title_des')</p>
                                <div class="textCenter"><a href="#"><img src="{{url("/b2c-assets/img/MR-01.png")}}"></a></div>
                            </div>
                            <div class="col-md-8">
                                <div class="login__panel">
                                    <div class="col-md-12">
                                        <ul style="cursor: pointer; display: flex">
                                            <li class="active" id="tabLogin">
                                                <a>@lang('b2c.login.title')</a>
                                            </li>
                                            <li  id="tabRegister">
                                                <a ui-sref="pageRegister"
                                                   href="javascript:void()">@lang('b2c.login.register')
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <form method="post" action="{{ route('login') }}"
                                              class="form-login ng-pristine ng-invalid ng-invalid-required"
                                              name="formLogin" id="formLogin" >
                                            @csrf
                                            <div class="form-group col-md-12">
                                                <div class="col-md-3">
                                                    <span class="form-control">@lang('b2c.login.username')</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <input style="margin: 0px" type="text" id="email" name="email"
                                                           placeholder="{{trans('b2c.login.place_holder.username')}}"
                                                           class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"
                                                           required="">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-3">
                                                    <span class="form-control">@lang('b2c.login.password')</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="password" id="password"
                                                           name="password"
                                                           placeholder="{{trans('b2c.login.place_holder.password')}}"
                                                           class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"
                                                           required="">
                                                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-9 col-md-offset-3">
                                                    <p style="text-align: center">@lang('b2c.login.forgot_password')
                                                        <a ui-sref="pageInitForgot" style="cursor: pointer;  color:#000"
                                                           href="{{ url('password/forgot-password') }}">
                                                            @lang('b2c.login.here')
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="md-btn md-btn--primary col-md-10 col-xs-12 btnLogin"
                                                        >@lang('b2c.login.sign_in_btn')</button>
                                            </div>
                                            <div class="col-md-9 col-md-offset-3">
                                                <a class="md-btn md-btn--facebook col-md-10 col-xs-12 btnLogin"
                                                   style="padding-left: 50px"
                                                   href="{{ URL::to('auth/facebook') }}">
                                                    <i class="fa fa-facebook"></i>
                                                    <span>@lang('b2c.login.login_facebook')</span></a>
                                            </div>
                                            <div class="col-md-9 col-md-offset-3">
                                                <a class="md-btn md-btn--google col-md-10 col-xs-12 btnLogin"
                                                   style="padding-left: 50px"
                                                   href="{{ URL::to('auth/google') }}">
                                                    <i class="fa fa-google"></i>@lang('b2c.login.login_google')
                                                </a>
                                            </div>
                                        </form>

                                        <form style="display:none" class="form-login" method="POST" action="{{ route('register') }}"
                                                  name="formRegister" id="formRegister">
                                                @csrf
                                                <div class="form-group col-md-12">
                                                    <div class="col-md-4">
                                                        <span class="form-control">@lang('b2c.register.full_name')
                                                            <strong class="red">*</strong></span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text"
                                                               placeholder="{{trans('b2c.register.place_holder.full_name')}}"
                                                               class="form-control" required="required"
                                                               id="full_name" name="full_name">
                                                        {!! $errors->first('full_name', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <div class="col-md-4">
                                                        <span class="form-control">@lang('b2c.register.email')
                                                            <strong class="red">*</strong></span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="email" style="margin: 0px"
                                                               placeholder="{{trans('b2c.register.place_holder.email')}}"
                                                               class="form-control" required="required"
                                                               id="email" name="email">
                                                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <div class="col-md-4">
                                                        <span class="form-control">@lang('b2c.register.phone')
                                                            <strong class="red">*</strong></span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="tel" name="phone"
                                                               onkeypress="return isNumber(event)" minlength="10" maxlength="10"
                                                               placeholder="{{trans('b2c.register.place_holder.phone')}}"
                                                               class="form-control" id="phone" required="required">
                                                        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <div class="col-md-4">
                                                        <span class="form-control">@lang('b2c.register.password')
                                                            <strong class="red">*</strong></span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="password"
                                                               placeholder="{{trans('b2c.register.place_holder.password')}}"
                                                               class="form-control" required minlength="6"
                                                               maxlength="32"
                                                               name="password">
                                                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <div class="col-md-4">
                                                        <span class="form-control">@lang('b2c.register.confirm_password')
                                                            <strong class="red">*</strong></span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input id="password-confirm"
                                                               placeholder="{{trans('b2c.register.place_holder.confirm_password')}}"
                                                               type="password" class="form-control" required="required"
                                                               name="password_confirmation">
                                                        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <div class="col-md-4">
                                                        <span class="form-control">@lang('b2c.register.gender')
                                                            <strong class="red">*</strong></span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="checkbox">
                                                            <label class="custom-control custom-checkbox"
                                                                   style="margin-right: 20px">
                                                                <input class="custom-control-input" required
                                                                       name="gender"
                                                                       type="radio"
                                                                       value="male"/>
                                                                <span class="custom-control-indicator"></span>
                                                                <span class="custom-control-description">@lang('b2c.register.male')</span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" required
                                                                       name="gender"
                                                                       type="radio"
                                                                       value="female"/>
                                                                <span class="custom-control-indicator"></span>
                                                                <span class="custom-control-description">@lang('b2c.register.female')</span>
                                                            </label>
                                                        </div>
                                                        <div>{!! $errors->first('gender', '<p class="help-block">:message</p>') !!}</div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <div class="col-md-3">
                                                        <span class="form-control">@lang('b2c.register.birthday')
                                                            <strong class="red">*</strong></span>
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
                                                        <p style="margin-left: 10px">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox"
                                                                       class="custom-control-input term-policy-btn"
                                                                       value="true">
                                                                <span class="custom-control-indicator"></span>
                                                            </label>
                                                            @lang('b2c.register.term_policy_des')
                                                            <a style="cursor: pointer;  color:red;"> @lang('b2c.register.term_policy')</a>
                                                        </p>
                                                    </div>
                                                    {!! $errors->first('term_policy', '<p class="help-block">:message</p>') !!}
                                                </div>

                                                <div class="col-md-9 col-md-offset-3 textCenter">
                                                    <button type="submit" disabled="disabled"
                                                            class="md-btn md-btn--primary col-md-10 register-btn btnLogin"
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
            $("#pageTitle").html('@lang('b2c.register.title')');
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
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        $(document).ready(function () {
            $(".term-policy-btn").click(function () {
                $('.register-btn').attr('disabled', function (_, attr) {
                    return !attr
                });
            });
        });
    </script>
@endsection
