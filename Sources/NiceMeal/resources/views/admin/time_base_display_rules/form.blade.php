@php
    $periodType = [ trans('admin.time_base_pricing_rules.select.forever') => 0,trans('admin.time_base_pricing_rules.select.specific_period') => 1];
    $allTimes = [trans('admin.time_base_pricing_rules.select.all_time') => 1,trans('admin.time_base_pricing_rules.select.specific_time') => 0];
    $allDays = [trans('admin.time_base_pricing_rules.select.all_days') => 1,trans('admin.time_base_pricing_rules.select.specific_days') => 0];
@endphp
<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name') ? 'has-error' : ''}}">
            <label for="name" class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.name')
                <span class="text-danger">*</span></label>
            <div class="col-sm-9">
                {!! Form::text('name', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
    {{--Choose display type base on date--}}
    <div class="form-group m-form__group row" id="choose_date">
        <div class="col-lg-6 {{ $errors->has('period_type') ? 'has-error' : ''}}">
            <label for="period_type" class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.period_type')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
                {!! Form::select('period_type', array_keys($periodType) ,isset($timeBasePricingRule) ? $timeBasePricingRule->period_type : null,['class' => 'form-control m-input','id' => 'period_type'])!!}
            </div>
            {!! $errors->first('period_type', '<p class="help-block field-error">:message</p>') !!}
        </div>
    </div>

    {{--Datepicker--}}
    <div class="form-group m-form__group row period_specifice">
        <div class="col-lg-6 {{ $errors->has('from_date') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.from_date')
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9 col-md-9 col-sm-12 ">
                <div class="input-group date">
                    {!! Form::text('from_date', isset($timeBaseDisplayRule) ? \Carbon\Carbon::parse($timeBaseDisplayRule->from_date)->format('Y-m-d'):\Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control m-input','id' => 'from_date','readonly' => 'true']) !!}
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
                {!! $errors->first('from_date', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('to_date') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.to_date')
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9 col-md-9 col-sm-12 ">
                <div class="input-group date">
                    {!! Form::text('to_date', isset($timeBaseDisplayRule) ? \Carbon\Carbon::parse($timeBaseDisplayRule->to_date)->format('Y-m-d'):\Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control m-input','id' => 'to_date','readonly' => 'true']) !!}
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
                {!! $errors->first('to_date', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>

    {{--Choose display type base on date--}}
    <div id="all_day_section">
        <div class="form-group m-form__group row" >
            <div class="col-lg-6 {{ $errors->has('all_days') ? 'has-error' : ''}}">
                <label for="all_days" class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.all_days')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    {!! Form::select('all_days', array_flip($allDays) ,isset($timeBasePricingRule) ? $timeBasePricingRule->all_days : null,['class' => 'form-control m-input','id' => 'all_days'])!!}
                </div>
                {!! $errors->first('all_days', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        {{--Specific day--}}
        <div class="form-group m-form__group row" id="specific_date">
            <div class="col-lg-4 {{ $errors->has('mon') ? 'has-error' : ''}}">
                <div class="col-sm-12">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            {!! Form::checkbox('mon', 1, isset($timeBaseDisplayRule) ? $timeBaseDisplayRule->mon : false, ['class' => 'form-control ', 'name'=>'mon', 'id'=>'mon']) !!}
                            @lang('admin.time_base_display_rules.columns.mon')
                            <span></span>
                        </label>
                    </div>
                </div>
                {!! $errors->first('mon', '<p class="help-block field-error">:message</p>') !!}
            </div>
            <div class="col-lg-4 {{ $errors->has('tue') ? 'has-error' : ''}}">
                <div class="col-sm-12">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            {!! Form::checkbox('tue', 1, isset($timeBaseDisplayRule) ? $timeBaseDisplayRule->tue : false, ['class' => 'form-control ', 'name'=>'tue', 'id'=>'tue']) !!}
                            @lang('admin.time_base_display_rules.columns.tue')
                            <span></span>
                        </label>
                    </div>
                </div>
                {!! $errors->first('tue', '<p class="help-block field-error">:message</p>') !!}
            </div>
            <div class="col-lg-4 {{ $errors->has('wed') ? 'has-error' : ''}}">
                <div class="col-sm-12">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            {!! Form::checkbox('wed', 1, isset($timeBaseDisplayRule) ? $timeBaseDisplayRule->wed : false, ['class' => 'form-control ', 'name'=>'wed', 'id'=>'wed']) !!}
                            @lang('admin.time_base_display_rules.columns.wed')
                            <span></span>
                        </label>
                    </div>
                </div>
                {!! $errors->first('wed', '<p class="help-block field-error">:message</p>') !!}
            </div>
            <div class="col-lg-4 {{ $errors->has('thu') ? 'has-error' : ''}}">
                <div class="col-sm-12">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            {!! Form::checkbox('thu', 1, isset($timeBaseDisplayRule) ? $timeBaseDisplayRule->thu : false, ['class' => 'form-control ', 'name'=>'thu', 'id'=>'thu']) !!}
                            @lang('admin.time_base_display_rules.columns.thu')
                            <span></span>
                        </label>
                    </div>
                </div>
                {!! $errors->first('thu', '<p class="help-block field-error">:message</p>') !!}
            </div>
            <div class="col-lg-4 {{ $errors->has('fri') ? 'has-error' : ''}}">
                <div class="col-sm-12">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            {!! Form::checkbox('fri', 1, isset($timeBaseDisplayRule) ? $timeBaseDisplayRule->fri : false, ['class' => 'form-control ', 'name'=>'fri', 'id'=>'fri']) !!}
                            @lang('admin.time_base_display_rules.columns.fri')
                            <span></span>
                        </label>
                    </div>
                </div>
                {!! $errors->first('fri', '<p class="help-block field-error">:message</p>') !!}
            </div>
            <div class="col-lg-4 {{ $errors->has('sat') ? 'has-error' : ''}}">
                <div class="col-sm-12">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            {!! Form::checkbox('sat', 1, isset($timeBaseDisplayRule) ? $timeBaseDisplayRule->sat : false, ['class' => 'form-control ', 'name'=>'sat', 'id'=>'sat']) !!}
                            @lang('admin.time_base_display_rules.columns.sat')
                            <span></span>
                        </label>
                    </div>
                </div>
                {!! $errors->first('sat', '<p class="help-block field-error">:message</p>') !!}
            </div>
            <div class="col-lg-4 {{ $errors->has('sun') ? 'has-error' : ''}}">
                <div class="col-sm-12">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            {!! Form::checkbox('sun', 1, isset($timeBaseDisplayRule) ? $timeBaseDisplayRule->sun : false, ['class' => 'form-control ', 'name'=>'sun', 'id'=>'sun']) !!}
                            @lang('admin.time_base_display_rules.columns.sun')
                            <span></span>
                        </label>
                    </div>
                </div>
                {!! $errors->first('sun', '<p class="help-block field-error">:message</p>') !!}
            </div>
            <div class="col-lg-12 validate-message" id="validate_message">
                <p class="help-block field-error">@lang('admin.time_base_display_rules.validation_message.at_least_one')</p>
            </div>
        </div>
    </div>

    {{--Choose display type base on time--}}
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('all_times') ? 'has-error' : ''}}">
            <label for="all_times" class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.all_times')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
                {!! Form::select('all_times', array_flip($allTimes) ,isset($timeBasePricingRule) ? $timeBasePricingRule->all_times : null,['class' => 'form-control m-input','id' => 'all_times'])!!}
            </div>
            {!! $errors->first('all_times', '<p class="help-block field-error">:message</p>') !!}
        </div>
    </div>

    {{--Specific time--}}
    <div class="form-group m-form__group row" id="specific_time">
        <div class="col-lg-6 {{ $errors->has('from_time') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.from_time')
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('from_time', isset($timeBaseDisplayRule) ? \Carbon\Carbon::parse($timeBaseDisplayRule->from_time)->format('H:i'):\Carbon\Carbon::now()->format('H:i'), ['class' => 'form-control','id' => 'from_time']) !!}
                {!! $errors->first('from_time', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('to_time') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.to_time')
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('to_time', isset($timeBaseDisplayRule) ? \Carbon\Carbon::parse($timeBaseDisplayRule->to_time)->format('H:i'):\Carbon\Carbon::now()->format('H:i') , ['class' => 'form-control','id' => 'to_time']) !!}
                {!! $errors->first('to_time', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('active') ? 'has-error' : ''}}">
            <div class="col-sm-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1, isset($timeBaseDisplayRule) ? $timeBaseDisplayRule->active : true, ['class' => 'form-control ', 'name'=>'active', 'id'=>'active']) !!}
                        @lang('admin.time_base_display_rules.columns.active')
                        <span></span>
                    </label>
                </div>
            </div>
            {!! $errors->first('active', '<p class="help-block field-error">:message</p>') !!}
        </div>
    </div>

    <input type="hidden" name="back_url" value="{{ $backUrl }}">
</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                <a href="{{url($backUrl)}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
                {!! Form::button(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    <script>
        $(document).ready(function () {
            if($('#period_type').val() == 0){
                $('.period_specifice').hide();
                $('#all_day_section').show();
            }else {
                $('.period_specifice').show();
                $('#all_day_section').hide();
            }

            $('.validate-message').hide();
            $('#period_type').change(function () {
                if ($('#period_type').val() == '1') {
                    $('.period_specifice').show();
                    $('#all_day_section').hide();

                } else {
                    $('.period_specifice').hide();
                    $('#all_day_section').show();
                    $('.period_specifice').find('input[type=checkbox]').each(function (index) {
                        $(this).prop('checked', false);
                    })
                }
            });
           
            if($('#all_times').val() == 1){
                $('#specific_time').hide();
            }
            $('.validate-message').hide();

            if($('#all_days').val() == 1) {
                $('#specific_date').hide();
            }
            $('#all_days').change(function () {
                if ($('#all_days').val() == '0') {
                    $('#specific_date').show();
                } else {
                    $('#specific_date').hide();
                    $('#specific_date').find('input[type=checkbox]').each(function (index) {
                        $(this).prop('checked', false);
                    })
                }
            });
            $('#all_times').change(function () {
                if ($('#all_times').val() == '0') {
                    $('#specific_time').show();
                } else {
                    $('#specific_time').hide();
                }
            });

            //date picker
            $('#from_date').datepicker({
                language: '{{$lang}}',
                format: 'yyyy-mm-dd',
                autoclose: true,
                clearBtn: true,
                orientation: "bottom left"
            });

            $('#to_date').datepicker({
                language: '{{$lang}}',
                format: 'yyyy-mm-dd',
                autoclose: true,
                clearBtn: true,
                orientation: "bottom left"
            });

            //time picker
            $('#from_time').timepicker({
                format: 'HH:mm',
                showMeridian: false,
                minuteStep: 1,
            });
            $('#to_time').timepicker({
                format: 'HH:mm',
                showMeridian: false,
                minuteStep: 1,
            });

            $('#submitButton').on("click", function () {
               
                if ($('#all_days').val() == '0') {
                    let count = $('#specific_date').find('input[type=checkbox]:checked').length;                    
                    if (count > 0) {
                        $('#submitForm').submit();
                    } else {
                        $('.validate-message').show();
                        //scroll to validation message
                        $('html, body').animate({
                            scrollTop: $("#choose_date").offset().top
                        }, 300);
                    }
                } else {
                    $('#submitForm').submit();
                }
            });
        })
        ;
    </script>
@endsection
