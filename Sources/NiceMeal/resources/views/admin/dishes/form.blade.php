@php
$name_en = '';
$name_ja = '';
$description_en = '';
$description_ja = '';
$price = 0;
$active = 0;
if(isset($dish)){
    $name_en = $dish->name_en;
    $name_ja = $dish->name_ja;
    $description_en = $dish->description_en;
    $description_ja = $dish->description_ja;
    $price = $dish->price;
    $active = $dish->active;
}
@endphp
<div id="dishes" class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">


    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-error' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.name_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en',$name_en , ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('name_en', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-6 {{ $errors->has('name_ja') ? 'has-error' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.name_ja')
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_ja', $name_ja, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('name_ja', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-error' : ''}}">
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.description_en')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::textarea('description_en', $description_en, ['class' => 'summernote', 'rows' => 10, 'id'=>'description-en-id' ]) !!}
                <p class="required-des-en" style="color: red"></p>
                {!! $errors->first('description_en', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="col-lg-6 {{ $errors->has('description_ja') ? 'has-error' : ''}}">
            {!! Form::label('description_ja', trans('admin.restaurants.forms.description_ja'), ['class' => 'col-form-label col-sm-12']) !!}
            <div class="col-sm-12">
                {!! Form::textarea('description_ja', $description_ja, ['class' => 'summernote', 'rows' => 10]) !!}
                {!! $errors->first('description_ja', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('price') ? 'has-error' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.dishes.forms.price')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('price', number_format($price,0,'.',','), ['class' => 'form-control m-input','required' => 'required','id'=>'price']) !!}
                {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="col-lg-6 {{ $errors->has('active') ? 'has-error' : ''}}">
        {!! Form::label('status', trans('admin.restaurants.forms.status'), ['class' => 'col-form-label col-sm-12']) !!}
            <div class="col-sm-12">
                <label class="m-checkbox">
                    {!! Form::checkbox('active', 1, $active ,['class' => 'form-control ','name'=>'active','id'=>'active']) !!}
                    @lang('admin.restaurants.forms.active')
                    <span></span>
                </label>
            </div>
            {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-12 {{ $errors->has('categories') ? 'has-error' : ''}}">
            <label for="categories" class="col-form-label col-sm-12">@lang('admin.dishes.forms.category')
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-12">
                <select multiple name="categories[]" class="form-control select2" id="categories">
                    <option disabled >--Chọn category--</option>
                    @foreach($categories as $index => $item)
                        @if(!empty($dish) && !empty($dish->categoriesList()))
                            <option value="{{$item->id}}" @if (in_array($item->id,(json_decode($dish->categoriesList())))) selected @endif>{{$item->title_en}}</option>
                        @else
                            <option value="{{$item->id}}" >{{$item->title_en}}</option>
                        @endif
                    @endforeach
                </select>
                {!! $errors->first('categories', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-12" >
            <label for="description_en" class="col-form-label col-sm-12">@lang('admin.dishes.forms.customization')
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
        <div class="col-lg-12" >
            {!! Form::label('description_en', 'Time base pricing', ['class' => 'col-form-label col-sm-12 float-left']) !!}

        </div>
        <div id="tbps_zone" class="dish-extra-item-field col-lg-12 {{ $errors->has('active') ? 'has-error' : ''}}">
        </div>
    </div>
    <div class="form-group m-form__group row">
        @include('admin.components.media.form',[
            'name' => 'dish',
            'width' => '12',
            'maxFiles' => config('constants.MAX_FILE'),
            'img_name_attr' => 'image',
            'variable' => isset($dish) ? $dish : ''
        ])
    </div>
    <input type="hidden" name="back_url" value="{{ $backUrl }}">
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                @if(isset($dish))
                    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.restaurants.buttons.update'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                @else
                    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.restaurants.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                @endif
                <a href="{{url($backUrl)}}" class="btn btn-secondary">
                    @lang('admin.restaurants.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
