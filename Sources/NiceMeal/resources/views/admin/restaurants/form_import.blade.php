<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">

    <div class="form-group m-form__group row m-content">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="col-lg-12">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                                </span>
                                <h5 class="m-portlet__head-text">
                                    Import Restaurant
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-lg-12 {{ $errors->has('file_import') ? 'has-error' : ''}}">
                        <label for="file_import" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.file_import')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            {!! Form::file('file_import', ['accept' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'], ['class' => 'form-control m-input']) !!}
                            {!! $errors->first('file_import', '<p class="help-block field-error">:message</p>') !!}
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
            <div class="offset-5">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.restaurants.buttons.import'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/restaurants')}}" class="btn btn-secondary">
                    @lang('admin.restaurants.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>


@section('extra_scripts')

@endsection