<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="m-form__group form-group row">
        <div class="col-lg-12 {{ $errors->has('rate') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.intro.form.intro')
                <span class="text-danger">*</span></label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::textarea('intro',null, ['class' => 'form-control summernote-textarea','id' => 'intro']) !!}
                {!! $errors->first('intro', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-12 ml-lg-auto intro-submit-btn">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}

                <a href="{{url('admin/restaurants')}}" class="btn btn-secondary">
                    @lang('admin.buttons.back')
                </a>
            </div>
        </div>
    </div>
</div>


 