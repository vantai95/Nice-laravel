@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-1">
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-10">
                <div class="form-group">
                    <div class="card-header"><h4>{{ __('auth.reset.title') }}</h4></div>

                    <div class="card-body" style="margin-left: 15px">
                        <form method="POST" action="{{ url('password/reset') }}"
                              aria-label="{{ __('auth.reset.title') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-12 col-lg-12 col-sm-12 col-form-label text-md-right">{{ __('auth.reset.email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" style="margin-left:0"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback red" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-12 col-lg-12 col-sm-12 col-form-label text-md-right">{{ __('auth.reset.password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} password-field"
                                           name="password" required>
                                    <p class="text-danger d-none" id="message-valid-password">@lang('b2c.register.message_valid_password')</p>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback red help-block-message" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-12 col-lg-12 col-sm-12 col-form-label text-md-right">{{ __('auth.reset.confirm_password') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="submit-btn">
                                        {{ __('auth.reset.button') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        $(document).ready(function () {
            $('.password-field').on('blur', function() {
                var passVal = checkStrongPassword($('.password-field').val());

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
        });
    </script>
@endsection
