<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-error' : ''}}">
            {!! Form::label('name_en', trans('admin.cuisines.forms.name_en').' *', ['class' => 'col-form-label col-sm-12']) !!}
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_en', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-6 {{ $errors->has('name_ja') ? 'has-error' : ''}}">
            {!! Form::label('name_ja', trans('admin.cuisines.forms.name_ja'), ['class' => 'col-form-label col-sm-12']) !!}
            <div class="col-sm-12">
                {!! Form::text('name_ja', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_ja', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.cuisines.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/'.$res->res_Slug.'/cuisines')}}" class="btn btn-secondary">
                    @lang('admin.cuisines.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
