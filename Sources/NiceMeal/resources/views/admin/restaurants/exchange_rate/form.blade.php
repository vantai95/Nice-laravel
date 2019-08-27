<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="col-lg-12">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h5 class="m-portlet__head-text">
                        @lang('admin.restaurants.form_title.exchange_rate')
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('value') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.exchange_rate.usd_vnd')</label>
        </div>
        <div class="col-lg-8 {{ $errors->has('value') ? 'has-error' : ''}}">
            <div class="col-lg-6 col-md-6 col-sm-12">
                {!! Form::text('value',number_format($settings->value,0,'.',','), ['class' => 'form-control','id' => 'value']) !!}
                {!! $errors->first('value', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        {!! Form::hidden('key',null, ['class' => 'form-control','id' => 'key']) !!}
        {!! Form::hidden('id',null, ['class' => 'form-control']) !!}
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
        $(document).ready(function () {
            $('#value').mask("#.##0",{reverse:true});
            $('#submitForm').submit(function(e){
                $('#value').unmask();
            });
        });
    </script>
@endsection