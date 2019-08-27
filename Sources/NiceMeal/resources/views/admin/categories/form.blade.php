<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('title_en') ? 'has-danger' : ''}}">
            <label for="title_en" class="col-form-label col-sm-12">@lang('admin.categories.forms.title_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('title_en', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
                {!! $errors->first('title_en', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>

        </div>

        <div class="col-lg-6 {{ $errors->has('title_ja') ? 'has-danger' : ''}}">
            <label for="title_ja" class="col-form-label col-sm-12">@lang('admin.categories.forms.title_ja')</label>
            <div class="col-sm-12">
                {!! Form::text('title_ja', null, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('title_ja', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6">
            <div class="col-lg-1 text-nowrap {{ $errors->has('active') ? 'has-error' : ''}}">
                <label for="active" class="col-form-label col-sm-12">@lang('admin.categories.forms.status')</label>
            </div>
            <div class="col-lg-2 col-md-9 col-sm-12">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('active', 1, isset($category) ? $category->active : true, ['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                        @lang('admin.categories.forms.active')
                        <span></span>
                    </label>
                </div>
                {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-12" >
            <label for="description_en" class="col-form-label col-sm-12 float-left">@lang('admin.dishes.forms.customization')
            </label>
        </div>
        <div id="customizations_zone" class="dish-extra-item-field col-lg-12 {{ $errors->has('active') ? 'has-error' : ''}}">
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-12" >
            {!! Form::label('description_en', 'Time base display', ['class' => 'col-form-label col-sm-12 float-left']) !!}

        </div>
        <div id="tbds_zone" class="dish-extra-item-field col-lg-12 {{ $errors->has('active') ? 'has-error' : ''}}">
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-12 {{ $errors->has('categories') ? 'has-error' : ''}}">
            <label for="categories" class="col-form-label col-sm-12">Choose Dishes
                <span class="text-danger"></span>
            </label>
            <div class="col-lg-12">
                <select multiple name="dished[]" class="form-control select2" id="dished">
                    <option disabled >--Choose Dish--</option>
                    @if(!empty($dishes))
                        @foreach($dishes as $index => $item)                            
                            @if(!empty($category) && !empty($category->dishesList()))
                            <option value="{{$item->id}}" @if (in_array($item->id,(json_decode($category->dishesList())))) selected @endif>{{$item->name_en}}</option>
                            @else
                                <option value="{{$item->id}}" >{{$item->name_en}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                {!! $errors->first('dished', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        
    </div>
    <div class="form-group m-form__group row">
        @include('admin.components.media.form',[
            'name' => 'category',
            'width' => '12',
            'maxFiles' => 1,
            'img_name_attr' => 'image',
            'variable' => isset($category) ? $category : ''
        ])
    </div>

    <input type="hidden" name="back_url" value="{{ $backUrl }}">
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.categories.buttons.create'), ['class' => 'btn btn-accent m-btn m-btn--air m-btn--custom', 'id' => 'submitButton']) !!}
                <a href="{{url($backUrl)}}" type="reset"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom btn-cancel">
                    @lang('admin.categories.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
