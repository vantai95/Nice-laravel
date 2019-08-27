@php
    isset($otpSetting) ? $otpValue = $otpSetting->otp_value : $otpValue = 0;
    isset($otpSetting) ? $otp = $otpSetting->otp : $otp = 0;
@endphp
<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-6">
            <div class="m-portlet">
                <div class="col-lg-12">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                                </span>
                                <h5 class="m-portlet__head-text">
                                    Send OTP Setting
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row {{ $errors->has('otp') ? 'has-error' : ''}}" style="margin-top: 10px">
                        {!! Form::label('otp', trans('admin.restaurants.forms.otp'), ['class' => 'col-form-label col-sm-12 col-lg-6']) !!}
                        <div class="col-sm-12 col-lg-6">
                            <div class="d-inline-flex">
                                <div class="btn btn-info" id="decreaseOtp" onclick="decreaseOtp()">
                                    <span class="glyphicon glyphicon-plus"></span> -
                                </div>
                                {!! Form::text('otp', number_format( $otp,0,'.',','), ['class' => 'form-control m-input','id' => 'otp','min'=>1]) !!}
                                <div class="btn btn-info" id="increaseOtp" onclick="increaseOtp()">
                                    <span class="glyphicon glyphicon-minus"></span> +
                                </div>
                            </div>
                        </div>
                        {!! $errors->first('otp', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                    <div class="row {{ $errors->has('otp_value') ? 'has-error' : ''}}" style="margin-top: 10px; padding-bottom: 10px;">
                        {!! Form::label('otp_value', trans('admin.restaurants.forms.otp_value'), ['class' => 'col-form-label col-sm-12 col-lg-6']) !!}
                        <div class="col-sm-12  col-lg-6">
                            <div class="d-inline-flex">
                                <div class="btn btn-info" id="decreaseOtpValue" onclick="decreaseOtpValue()">
                                    <span class="glyphicon glyphicon-plus"></span> -
                                </div>
                                {!! Form::text('otp_value',number_format( $otpValue,0,'.',','), ['class' => 'form-control m-input','id' => 'otp_value']) !!}
                                <div class="btn btn-info" id="increaseOtpValue" onclick="increaseOtpValue()">
                                    <span class="glyphicon glyphicon-minus"></span> +
                                </div>
                            </div>
                        </div>
                        {!! $errors->first('otp_value', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/restaurants')}}" class="btn btn-secondary">
                    @lang('admin.buttons.back')
                </a>
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    <script>
        //validate number
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        // Increase Decrease OPT
        $('#otp').mask("#.##0", {reverse: true});
        $('#otp_value').mask("#.##0", {reverse: true});

        $('#submitForm').submit(function () {
            $('#otp').unmask();
            $('#otp_value').unmask();
        });

        function increaseOtp() {
            var value = parseInt(document.getElementById('otp').value, 10);
            value = isNaN(value) ? 1 : value;
            value++;
            document.getElementById('otp').value = value;
        }

        function decreaseOtp() {
            var value = parseInt(document.getElementById('otp').value, 10);
            value = isNaN(value) ? 1 : value;
            value < 1 ? value = 1 : '';
            value--;
            if (value < 1)
                value = 1
            document.getElementById('otp').value = value;
        }

        function increaseOtpValue() {
            $('#otp_value').unmask();
            var value = parseInt(document.getElementById('otp_value').value);
            value += 10000;
            document.getElementById('otp_value').value = value;
            $('#otp_value').mask("#.##0", {reverse: true});
        }

        function decreaseOtpValue() {
            $('#otp_value').unmask();
            var value = parseInt(document.getElementById('otp_value').value);
            value = isNaN(value) ? 0 : value;
            value < 0 ? value = 0 : '';
            value -= 10000;
            if (value < 0)
                value = 0
            document.getElementById('otp_value').value = value;
            $('#otp_value').mask("#.##0", {reverse: true});
        }

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>
@endsection