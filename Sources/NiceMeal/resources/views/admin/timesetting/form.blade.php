@php
    $allTimes = [trans('admin.time_base_pricing_rules.select.all_time') => 1,trans('admin.time_base_pricing_rules.select.specific_time') => 0];
    $allDays = [trans('admin.time_base_pricing_rules.select.all_days') => 1,trans('admin.time_base_pricing_rules.select.specific_days') => 0];
@endphp
<div>
  <div class="form-group m-form__group row">
    <div class="col-lg-6 {{ $errors->has('special_date') ? 'has-error' : ''}}">
        <label for="special_date" class="col-form-label col-sm-12">Special Date
            <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
          <select class="form-control m-input" id="has_special_date" name="has_special_date">
            <option value="0" {{ (isset($time_setting) && $time_setting->has_special_date == 0) ? 'selected' : '' }}>No</option>
            <option value="1" {{ (isset($time_setting) && $time_setting->has_special_date == 1) ? 'selected' : '' }}>Yes</option>
          </select>
        </div>
        {!! $errors->first('period_type', '<p class="help-block field-error">:message</p>') !!}
    </div>
  </div>
  <div id="special_date_section">
    <div class="form-group m-form__group row">
      <div class="col-lg-6 {{ $errors->has('special_date') ? 'has-error' : ''}}">
        <label class="col-form-label col-sm-12">
          <i class="fa fa-calendar"></i> Date
        </label>
          <div class="col-sm-9" style="margin-top:10px;">
            {!! Form::text('special_date',(isset($time_setting) && $time_setting->has_special_date ) ? date('d-m-Y',strtotime($time_setting->special_date)) : date('d-m-Y'),
              ['class' => 'form-control','id' => 'special_date','autocomplete' => 'off'])
            !!}
          </div>
          {!! $errors->first('specific_date', '<p class="help-block field-error">:message</p>') !!}
      </div>
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
                {!! Form::select('all_days', array_flip($allDays) ,(isset($time_setting) && $time_setting->from_date == null) ? $time_setting->all_days : null,['class' => 'form-control m-input','id' => 'all_days'])!!}
            </div>
            {!! $errors->first('all_days', '<p class="help-block field-error">:message</p>') !!}
        </div>
    </div>
    {{--Specific day--}}
    <div id="specific_date">
      <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('mon') ? 'has-error' : ''}}">
            <div class="col-sm-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('mon', 1, isset($time_setting) ? $time_setting->mon : false, ['class' => 'form-control ', 'name'=>'mon', 'id'=>'mon']) !!}
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
                        {!! Form::checkbox('tue', 1, isset($time_setting) ? $time_setting->tue : false, ['class' => 'form-control ', 'name'=>'tue', 'id'=>'tue']) !!}
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
                        {!! Form::checkbox('wed', 1, isset($time_setting) ? $time_setting->wed : false, ['class' => 'form-control ', 'name'=>'wed', 'id'=>'wed']) !!}
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
                        {!! Form::checkbox('thu', 1, isset($time_setting) ? $time_setting->thu : false, ['class' => 'form-control ', 'name'=>'thu', 'id'=>'thu']) !!}
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
                        {!! Form::checkbox('fri', 1, isset($time_setting) ? $time_setting->fri : false, ['class' => 'form-control ', 'name'=>'fri', 'id'=>'fri']) !!}
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
                        {!! Form::checkbox('sat', 1, isset($time_setting) ? $time_setting->sat : false, ['class' => 'form-control ', 'name'=>'sat', 'id'=>'sat']) !!}
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
                        {!! Form::checkbox('sun', 1, isset($time_setting) ? $time_setting->sun : false, ['class' => 'form-control ', 'name'=>'sun', 'id'=>'sun']) !!}
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
</div>
{{--Choose display type base on time--}}
<div id="all_times_section">
  <div class="form-group m-form__group row">
      <div class="col-lg-6 {{ $errors->has('all_times') ? 'has-error' : ''}}">
          <label for="all_times" class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.all_times')
              <span class="text-danger">*</span>
          </label>
          <div class="col-sm-9">
              {!! Form::select('all_times', array_flip($allTimes) ,(isset($time_setting)) ? $time_setting->all_times : null,['class' => 'form-control m-input',
              'id' => 'all_times'])!!}
          </div>
          {!! $errors->first('all_times', '<p class="help-block field-error">:message</p>') !!}
      </div>
  </div>
  {{--Specific time--}}
  <div id="specific_time">
    <div class="form-group m-form__group row" >
        <div class="col-lg-5 {{ $errors->has('from_time') ? 'has-error' : ''}}" id="from_time_section">
            <label class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.from_time')
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-5 {{ $errors->has('to_time') ? 'has-error' : ''}}" id="to_time_section">
            <label class="col-form-label col-sm-12">@lang('admin.time_base_display_rules.columns.to_time')
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-1">
          <button class="btn btn-primary" onclick="addTime()" type="button"><i class="fa fa-plus"></i> Add more</button>
        </div>
    </div>

    @if(isset($time_setting))
      @foreach($time_setting->time_setting_details as $detail)
        <div class="row time-row" data-none-special-time-id="{{$detail->id}}" style="padding-top:10px;padding-left:40px">
          <div class="col-lg-5">
            <input class="form-control timepicker" id="from_time" name="specific_time[{{$detail->id}}][from_time]" type="text" autocomplete="off" value="{{$detail->from_time}}" required="">
          </div>
          <div class="col-lg-5">
            <input class="form-control timepicker" id="to_time" name="specific_time[{{$detail->id}}][to_time]" type="text" autocomplete="off" value="{{\App\Services\DateTimeHandleService::calculateHourOver24($detail->to_time)}}" required="">
          </div>
          <div onclick="deleteTimeOfNoneSepecialDate({{$detail->id}})" class="col-sm-2 label label-default pull-right option-item-remove"><i class="fa fa-close"></i></div>
        </div>
      @endforeach
    @endif
    <p class="help-block field-error d-none" id="time-error">The time field is required.</p>
  </div>
</div>