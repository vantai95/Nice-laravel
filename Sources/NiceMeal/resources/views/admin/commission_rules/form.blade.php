<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('level') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.commission_rules.forms.level')</label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('level',null, ['class' => 'form-control','id' => 'level']) !!}
                {!! $errors->first('level', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('total_from') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.commission_rules.forms.total_from')</label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('total_from',null, ['class' => 'form-control number-format','id' => 'total_from','onkeypress' => 'return isNumber(event)']) !!}
                {!! $errors->first('total_from', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('total_to') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.commission_rules.forms.total_to')</label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('total_to',null, ['class' => 'form-control number-format','id' => 'total_to','onkeypress' => 'return isNumber(event)']) !!}
                {!! $errors->first('total_to', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('rate') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.commission_rules.forms.rate')(%)</label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('rate',null, ['class' => 'form-control number-format','id' => 'rate','onkeypress' => 'return isNumber(event)']) !!}
                {!! $errors->first('rate', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                <a href="{{url('admin/commission-rules')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    <script>
        $('.number-format').mask("#.##0", {reverse: true});
        $('#submitForm').submit(function () {
            $('.number-format').unmask();
        });

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
