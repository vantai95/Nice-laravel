<div class="form-group m-form__group row">
    <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-error' : ''}}">
        <label for="name_en" class="col-form-label col-sm-12">@lang('admin.customizations.forms.name_en')
            <span class="text-danger">*</span>
        </label>
        <div class="col-sm-12">
            {!! Form::text('name_en','' , ['class' => 'form-control m-input','id' => 'customization_name_en','required'=>'required']) !!}
            {!! $errors->first('name_en', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-lg-6 {{ $errors->has('name_ja') ? 'has-error' : ''}}">
        {!! Form::label('name_ja', trans('admin.customizations.forms.name_ja'), ['class' => 'col-form-label
        col-sm-12']) !!}
        <div class="col-sm-12">
            {!! Form::text('name_ja', '', ['class' => 'form-control m-input','id' => 'customization_name_ja']) !!}
            {!! $errors->first('name_ja', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>


<div class="form-group m-form__group row">
    <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-error' : ''}}">
        <label for="description_en"
            class="col-form-label col-sm-12">@lang('admin.customizations.forms.description_en')
        </label>
        <div class="col-sm-12">
            {!! Form::textarea('description_en', '', ['class' => 'summernote','id' => 'customization_description_en' ,'rows' => 10]) !!}
            {!! $errors->first('description_en', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-lg-6 {{ $errors->has('description_ja') ? 'has-error' : ''}}">
        {!! Form::label('description_ja', trans('admin.customizations.forms.description_ja'), ['class' =>
        'col-form-label col-sm-12']) !!}
        <div class="col-sm-12">
            {!! Form::textarea('description_ja', '', ['class' => 'summernote','id' => 'customization_description_ja' ,'rows' => 10]) !!}
            {!! $errors->first('description_ja', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group m-form__group row">
    <div class="col-lg-4 {{ $errors->has('required') ? 'has-error' : ''}}">
        <label for="required" class="col-form-label col-sm-12">@lang('admin.customizations.forms.required')
            <span class="text-danger">*</span>
        </label>
        <div class="col-sm-12">
            <input type="radio" name="required" id="customization_required_yes" value="1" required>
            @lang('admin.customizations.forms.radio_yes')
            <input type="radio" name="required" id="customization_required_no" value="0" required>
            @lang('admin.customizations.forms.radio_no')
        </div>
    </div>
    <div class="col-lg-4 {{ $errors->has('active') ? 'has-error' : ''}}">
        <label for="status" class="col-form-label col-sm-12">@lang('admin.customizations.forms.status')
            <span class="text-danger">*</span>
        </label>
        <div class="col-sm-12">
            <label class="m-checkbox">
                {!! Form::checkbox('active', 1, 0 , ['class' => 'form-control
                ','name'=>'active','id'=>'customization_active']) !!}
                @lang('admin.customizations.forms.active')
                <span></span>
            </label>
        </div>
        {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group m-form__group"
    id="option_form">
    <div class="row" style="margin-bottom: 20px">
        <div class="col-lg-4 {{ $errors->has('active') ? 'has-error' : ''}}">
            <label for="selection_type"
                class="col-form-label col-sm-12">@lang('admin.customizations.forms.selection_type')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                <select name="selection_type" class="select2 form-control" id="customization_selection_type"
                    onchange="changeSelectedType()">
                    <option value="1">Single choice</option>
                    <option value="2">Multiple choice</option>
                </select>
            </div>
        </div>

        <div class="col-lg-4 {{ $errors->has('required') ? 'has-error' : ''}}" id="quantity_changeable">
            <label class="col-form-label col-sm-12">@lang('admin.customizations.forms.quantity_changeable')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                <input type="radio" name="quantity_changeable" id="quantity_changeable_yes" value="1" required>
                @lang('admin.customizations.forms.radio_yes')
                <input type="radio" name="quantity_changeable" id="quantity_changeable_no" value="0" required>
                @lang('admin.customizations.forms.radio_no')
            </div>
        </div>

       <div id="max_div" class="col-lg-4
            {{ $errors->has('active') ? 'has-error' : ''}}">
            <label for="max_quantity"
                class="col-form-label col-sm-12">Times of selection
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::number('max_quantity',0, ['class' => 'form-control m-input','required' =>
                'required','id'=>'customization_max_quantity','pattern'=>'[0-9]{10}','min'=>'1' ]) !!}
            </div>
        </div>


    </div>
    <div class="row col-sm-12"  id="option_button">
        <div class="col-lg-6">
            <h5 class="modal-title">Option</h5>
        </div>
        <div class="col-lg-6">
            <button type="button" onclick="addMoreOption()" style="margin-right:-30px;" class="btn btn-primary pull-right"><i
                    class="fa fa-plus"></i> Add more</button>
        </div>
    </div>
    <input type="hidden" name="back_url" value="{{ $backUrl }}">
</div>
