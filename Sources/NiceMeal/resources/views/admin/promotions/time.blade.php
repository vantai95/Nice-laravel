@php
    $allTimes = [trans('admin.time_base_pricing_rules.select.all_time') => 1,trans('admin.time_base_pricing_rules.select.specific_time') => 0];
    $allDays = [trans('admin.time_base_pricing_rules.select.all_days') => 1,trans('admin.time_base_pricing_rules.select.specific_days') => 0];
@endphp
{{--Choose display type base on date--}}
<div>
  <div class="row">
    <div class="col-lg-6 {{ $errors->has('special_date') ? 'has-error' : ''}}">
        <label for="special_date" class="col-form-label col-sm-12">Special Date
            <span class="text-danger">*</span>
        </label>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <select class="form-control m-input" id="has_special_date" name="period_type">
            <option value="0" {{ (isset($promotion) && $promotion->period_type == 0) ? 'selected' : '' }}>No</option>
            <option value="1" {{ (isset($promotion) && $promotion->period_type == 1) ? 'selected' : '' }}>Yes</option>
          </select>
        </div>
        {!! $errors->first('period_type', '<p class="help-block field-error">:message</p>') !!}
    </div>
  </div>
  <div id="special_date_section" style="margin-top: 10px">
    <div class="row">
      <div class="col-lg-6 {{ $errors->has('special_date') ? 'has-error' : ''}}">
          <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('special_date',(isset($promotion) && isset($promotion->from_date) ) ? date('d-m-Y',strtotime($promotion->from_date)) : date('d-m-Y'),
              ['class' => 'form-control','id' => 'special_date','autocomplete' => 'off','required' => 'required'])
            !!}
          </div>
          {!! $errors->first('specific_date', '<p class="help-block field-error">:message</p>') !!}
      </div>
    </div>
  </div>
</div>

<div id="all_day_section" style="padding-right: 0">
    <div class="row">
        <div class="col-lg-6  {{ $errors->has('all_days') ? 'has-error' : ''}}">
            <label for="all_days" class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.all_days')
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::select('all_days', array_flip($allDays) ,isset($promotion) ? $promotion->all_days : null,['class' => 'form-control m-input','id' => 'all_days'])!!}
            </div>
            {!! $errors->first('all_days', '<p class="help-block field-error">:message</p>') !!}
        </div>
    </div>
    {{--Specific day--}}
    <div id="specific_date" class="row" style="margin-top: 10px">
        <div class="col-lg-4 {{ $errors->has('mon') ? 'has-error' : ''}}">
            <div class="col-sm-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('mon', 1, isset($promotion) ? $promotion->mon : false, ['class' => 'form-control ', 'name'=>'mon', 'id'=>'mon']) !!}
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
                        {!! Form::checkbox('tue', 1, isset($promotion) ? $promotion->tue : false, ['class' => 'form-control ', 'name'=>'tue', 'id'=>'tue']) !!}
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
                        {!! Form::checkbox('wed', 1, isset($promotion) ? $promotion->wed : false, ['class' => 'form-control ', 'name'=>'wed', 'id'=>'wed']) !!}
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
                        {!! Form::checkbox('thu', 1, isset($promotion) ? $promotion->thu : false, ['class' => 'form-control ', 'name'=>'thu', 'id'=>'thu']) !!}
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
                        {!! Form::checkbox('fri', 1, isset($promotion) ? $promotion->fri : false, ['class' => 'form-control ', 'name'=>'fri', 'id'=>'fri']) !!}
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
                        {!! Form::checkbox('sat', 1, isset($promotion) ? $promotion->sat : false, ['class' => 'form-control ', 'name'=>'sat', 'id'=>'sat']) !!}
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
                        {!! Form::checkbox('sun', 1, isset($promotion) ? $promotion->sun : false, ['class' => 'form-control ', 'name'=>'sun', 'id'=>'sun']) !!}
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
<div class="row">
    <div class="col-lg-6 {{ $errors->has('all_times') ? 'has-error' : ''}}">
        <label for="all_times" class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.all_times')
            <span class="text-danger">*</span>
        </label>
        <div class="col-sm-12">
            {!! Form::select('all_times', array_flip($allTimes) ,isset($timeBasePricingRule) ? $timeBasePricingRule->all_times : null,['class' => 'form-control m-input','id' => 'all_times'])!!}
        </div>
        {!! $errors->first('all_times', '<p class="help-block field-error">:message</p>') !!}
    </div>
</div>
{{--Specific time--}}
<div class="row" id="specific_time" style="margin-top: 10px">
    <div class="col-lg-6 {{ $errors->has('from_time') ? 'has-error' : ''}}">
        <label class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.from_time')
            <span class="text-danger">*</span>
        </label>
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('from_time', isset($promotion) ? \Carbon\Carbon::parse($promotion->from_time)->format('H:i A'):\Carbon\Carbon::now()->format('H:i A'), ['class' => 'form-control','id' => 'from_time']) !!}
            {!! $errors->first('from_time', '<p class="help-block field-error">:message</p>') !!}
        </div>
    </div>
    <div class="col-lg-6 {{ $errors->has('to_time') ? 'has-error' : ''}}">
        <label class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.to_time')
            <span class="text-danger">*</span>
        </label>
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('to_time', isset($promotion) ? \Carbon\Carbon::parse($promotion->to_time)->format('H:i A'):\Carbon\Carbon::now()->format('H:i A') , ['class' => 'form-control','id' => 'to_time']) !!}
            {!! $errors->first('to_time', '<p class="help-block field-error">:message</p>') !!}
        </div>
    </div>
</div>
