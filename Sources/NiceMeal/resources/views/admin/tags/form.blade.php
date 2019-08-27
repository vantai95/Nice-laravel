<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">

    <div class="form-group m-form__group row">
    
        <div class="col-lg-4">
            <label for="type" class="col-form-label col-sm-12">@lang('admin.tags.forms.type')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                <select required name="type" class="form-control select2" id="type">
                @if(isset($tag))
                    <option  value="0" @if($tag->type==0) selected @endif>Cuisine</option>
                    <option  value="1" @if($tag->type==1) selected @endif>Category</option>
                
                @else
                    <option  value="0" selected>Cuisine</option>
                    <option  value="1">Category</option>                
                @endif                  
                </select>
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('name_en') ? 'has-error' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.tags.forms.name_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_en', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('name_ja') ? 'has-error' : ''}}">
            {!! Form::label('name_ja', trans('admin.tags.forms.name_ja'), ['class' => 'col-form-label col-sm-12']) !!}
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
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.tags.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/tags')}}" class="btn btn-secondary">
                    @lang('admin.tags.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
