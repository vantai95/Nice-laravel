@php
    isset($tax) ? $type = $tax->type : $type = 0;
@endphp
<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="m-form__group form-group row">
    
        <div class="col-lg-12 ">
            <div class="m-radio-inline">
                <label for="take_red_bill">
                <input type="checkbox" name="take_red_bill" id="take_red_bill" {{($take_red_bill==1) ? 'checked':'' }} value="1"> 
                    <span>Restaurant support take red invoice </span></label>
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('type') ? 'has-error' : ''}}">
            {{--<label for="type">@lang('admin.taxes.forms.type')</label>--}}
            <label for="type">@lang('admin.taxes.forms.type')</label>
            <div class="m-radio-inline">
                <label class="m-radio">
                    <input type="radio" name="type" id="inclusive" {{(!$type) ? 'checked':'' }} value="0"> @lang('admin.taxes.forms.inclusive')
                    (tax added to show on menu already)
                    <span></span>
                </label>
                <label class="m-radio">
                    <input type="radio"name="type" id="exclusive" {{($type) ? 'checked':'' }} value="1" > @lang('admin.taxes.forms.exclusive')
                    (tax added to final total if customer ask red invoice)
                    <span></span>
                </label>
            </div>
            {!! $errors->first('type', '<p class="help-block field-error">:message</p>') !!}
        </div>
        <div class="col-lg-6 {{ $errors->has('rate') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.taxes.forms.rate') (%)
                <span class="text-danger">*</span></label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('rate',null, ['class' => 'form-control','id' => 'rate','onkeypress' => 'return isNumber(event)']) !!}
                {!! $errors->first('rate', '<p class="help-block field-error">:message</p>') !!}
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
    </script>
@endsection