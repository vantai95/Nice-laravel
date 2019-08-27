<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="col-lg-12">
                    <div class="row {{ $errors->has('cod_payment') ? 'has-error' : ''}}">
                        <div class="col-sm-12">
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    {!! Form::checkbox('cod_payment', isset($detailInfo) ? $detailInfo->cod_payment : 0, isset($detailInfo) ? $detailInfo->cod_payment : false, ['class' => 'form-control ', 'name'=>'cod_payment', 'id'=>'cod_payment']) !!}
                                    @lang('admin.restaurants.forms.cod_payment')
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        {!! $errors->first('cod_payment', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                    <div class="row {{ $errors->has('online_payment') ? 'has-error' : ''}}">
                        <div class="col-sm-12">
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    {!! Form::checkbox('online_payment', isset($detailInfo) ? $detailInfo->online_payment : 0, isset($detailInfo) ? $detailInfo->online_payment : false, ['class' => 'form-control ', 'name'=>'online_payment', 'id'=>'online_payment']) !!}
                                    @lang('admin.restaurants.forms.online_payment')
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        {!! $errors->first('online_payment', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group m-form__group row online-setting" style="display:none">
                                <div class="col-sm-6 m-checkbox-inline">
                                    <label class="m-checkbox">
                                        {!! Form::checkbox('paypalSettingValue', isset($paypalSettingValue) ? $paypalSettingValue : 0, isset($paypalSettingValue) ? $paypalSettingValue : false, ['class' => 'form-control ', 'name'=>'paypalSettingValue', 'id'=>'paypalSettingValue']) !!}
                                        <img class="active" src="{{ url('b2c-assets/img/paypal.png') }}"/>
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-sm-6 m-checkbox-inline">
                                    <label class=" m-checkbox">
                                        {!! Form::checkbox('nganLuongSettingValue', isset($nganLuongSettingValue) ? $nganLuongSettingValue : 0, isset($nganLuongSettingValue) ? $nganLuongSettingValue : false, ['class' => 'form-control ', 'name'=>'nganLuongSettingValue', 'id'=>'nganLuongSettingValue']) !!}
                                        <img class="active" src="{{ url('b2c-assets/img/alego_small.png') }}"/>
                                        <span></span>
                                    </label>
                                </div>
                                <div class="text-danger d-none message-valid">@lang('admin.restaurants.forms.choose_online_payment')</div>
                                {!! $errors->first('paypalSettingValue', '<p class="help-block field-error">:message</p>') !!}
                                {!! $errors->first('nganLuongSettingValue', '<p class="help-block field-error">:message</p>') !!}
                            </div>
                        </div>
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
        $(".online-setting").hide();
        var onlinePayment = '{{ $detailInfo->online_payment }}';
        if (onlinePayment === '1') {
            $(".online-setting").show();
        }
        $('#online_payment').click(function () {
            if ($(this).is(':checked')) {
                $(".online-setting").show();
                var checked = 1;
                checkSubmit(checked);
            } else {
                $(".online-setting").hide();
                $('#paypalSettingValue').prop('checked', false);
                $('#nganLuongSettingValue').prop('checked', false);
                var checked = 1;
                checkSubmit(checked);
            }
        });

        $('#submitForm').on('submit', function(e) {
            if($('input[name="online_payment"]:checked').length == 0) {
                $('#submitButton').removeAttr('disabled');
                $('.message-valid').css('display','none');
            } else {
                var checked = $('.online-setting').find('input:checkbox:checked').length;
                if (checked == 0) {
                    $('#submitButton').attr('disabled', 'disabled');
                    $('.message-valid').css('display','block');
                    $('.message-valid').removeClass('d-none');
                    e.preventDefault();
                } else {
                    $('#submitButton').removeAttr('disabled');
                    $('.message-valid').css('display','none');
                }
            }
        });

        $('.online-setting').on('change', function (e) {
            var checked = $('.online-setting').find('input:checkbox:checked').length;
            checkSubmit(checked);
        });

        function checkSubmit(validSubmit) {
            if (validSubmit == 0) {
                $('#submitButton').attr('disabled', 'disabled');
                $('.message-valid').css('display','block');
                $('.message-valid').removeClass('d-none');
            } else {
                $('#submitButton').removeAttr('disabled');
                $('.message-valid').css('display','none');
            }
        }

    </script>
@endsection