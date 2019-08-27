@php
    $restaurants = \App\Models\Restaurant::where('active', 1)->get();
    $restaurant = Session::get('res');
    $promotionTypes = \App\Models\Promotion::PROMOTION_TYPES;
    if (isset($slug)) {
        $categories = \App\Models\Category::where('restaurant_id', $restaurant->id)->where('active', 1)->select('id', 'title_en')->get();
        $dishes = \App\Models\Dish::where('restaurant_id', $restaurant->id)->where('active', 1)->select('id', 'name_en')->get();
        $promotionApplyTo = \App\Models\Promotion::PROMOTION_APPLY_TO;
    }
    else {
        unset($promotionTypes['free_item']);
        $promotionApplyTo = array_intersect_key(\App\Models\Promotion::PROMOTION_APPLY_TO, ['BY BILL'=>'']);
    }

@endphp

<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed row">

    <div class="form-group m-form__group col-lg-6">
        <b>TYPE OF PROMOTION</b>
        <br/>
        <div class="row">
            <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-error' : ''}}">
                <label for="name_en" class="col-form-label col-sm-12">@lang('admin.promotions.forms.name_en')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('name_en', isset($promotion) ? $promotion->name_en : '', ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('name_en', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-6 {{ $errors->has('name_ja') ? 'has-error' : ''}}">
                <label for="name_ja" class="col-form-label col-sm-12">@lang('admin.promotions.forms.name_ja')
                </label>
                <div class="col-sm-12">
                    {!! Form::text('name_ja', isset($promotion) ? $promotion->name_ja : '', ['class' => 'form-control m-input']) !!}
                    {!! $errors->first('name_ja', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-error' : ''}}">
                <label for="description_en" class="col-form-label col-sm-12">@lang('admin.promotions.forms.description_en')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::textarea('description_en', isset($promotion) ? $promotion->description_en : NULL, ['class' => 'summernote', 'rows' => 10]) !!}
                    {!! $errors->first('description_en', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-6 {{ $errors->has('description_ja') ? 'has-error' : ''}}">
                <label for="description_ja" class="col-form-label col-sm-12">@lang('admin.promotions.forms.description_ja')
                </label>
                <div class="col-sm-12">
                    {!! Form::textarea('description_ja', isset($promotion) ? $promotion->description_ja : '', ['class' => 'summernote', 'rows' => 10]) !!}
                    {!! $errors->first('description_ja', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 {{ $errors->has('type') ? 'has-error' : ''}}">
                <label for="type" class="col-form-label col-sm-12">Choose Types
                        <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <select required name="type" class="form-control select2" id="type">
                        <option {{ isset($promotion) ? 'disabled' : '' }} value="" >--Choose Type--</option>
                        @foreach($promotionTypes as $key => $value)
                            <option value="{{ $value }}" {{ ((old('type')==$value) || (old('type')=='' && isset($promotion) && $promotion->type==$value)) ? 'selected' : '' }}>{{ $key }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('type', '<p class="help-block field-error">:message</p>') !!}
                </div>
            </div>
            <div class="type col-lg-6">
                <div class="{{ $errors->has('value') ? 'has-error' : ''}} value">
                    <label for="value" class="col-form-label col-sm-12">@lang('admin.promotions.forms.value')
                        <span id="percent">(%)</span><span class="text-danger"> *</span>
                    </label>
                    <div class="col-sm-12">
                        {!! Form::text('value', isset($promotion) ? App\Services\CommonService::formatPrice($promotion->value) : '', ['class' => 'form-control m-input']) !!}
                        {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                @if(isset($slug))
                <div class="{{ $errors->has('free_item') ? 'has-error' : ''}} free_item">
                    <label for="free_item" class="col-form-label col-sm-12">@lang('admin.promotions.forms.free_item')
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-12">
                        <select multiple name="free_item[]" class="form-control select2" id="free_item">
                            <option disabled >--Chọn dish--</option>
                            @foreach($dishes as $index => $dish)
                                <option value="{{$dish->id}}" >{{$dish->name_en}}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('free_item', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 {{ $errors->has('maximun_discount') ? 'has-error' : ''}} maximun-discount">
                <label for="maximun_discount" class="col-form-label col-sm-12">@lang('admin.promotions.forms.maximun_discount')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('maximun_discount', isset($promotion) ? App\Services\CommonService::formatPrice($promotion->maximun_discount) : '', ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('maximun_discount', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            @if(!isset($slug))
            <div class="col-lg-6 {{ $errors->has('number_usage') ? 'has-error' : ''}}">
                <label for="number_usage" class="col-form-label col-sm-12">@lang('admin.promotions.forms.number_usage')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('number_usage', isset($promotion) ? $promotion->number_usage : '' , ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('number_usage', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            @if(!isset($slug))
            <div class="col-lg-6 {{ $errors->has('promotion_code') ? 'has-error' : ''}}">
                <label for="promotion_code" class="col-form-label col-sm-12">@lang('admin.promotions.forms.promotion_code')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('promotion_code', isset($promotion) ? $promotion->promotion_code : '', ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('promotion_code', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            @endif
            <div class="col-lg-6">
                <div class="col-lg-1 text-nowrap {{ $errors->has('status') ? 'has-error' : ''}}" style="height: 36px">
                    <label for="status" class="col-form-label col-sm-12"></label>
                </div>
                <div class="col-lg-2 col-md-9 col-sm-12">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            {!! Form::checkbox('status', 1, isset($promotion) ? $promotion->status : true, ['class' => 'form-control ','name'=>'status','id'=>'status']) !!}
                            @lang('admin.promotions.forms.active')
                            <span></span>
                        </label>
                    </div>
                    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="form-group m-form__group col-lg-6 apply_form">
        <b>APPLY TO</b>
        <br/>
        <div class="row">
            <div class="col-lg-6 {{ $errors->has('apply_to') ? 'has-error' : ''}}">
                <label for="apply_to" class="col-form-label col-sm-12">Choose Apply To
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <select required name="apply_to" class="form-control select2" id="apply_to">
                        <option {{ isset($promotion) ? 'disabled' : '' }} value="" >--Choose Apply To--</option>
                        @foreach( $promotionApplyTo as $key => $value)
                            <option value="{{ $value }}" {{  ((old('apply_to')==$value) || (old('apply_to')=='' && isset($promotion) && $promotion->apply_to==$value)) ? 'selected' : '' }} >{{ $key }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('apply_to', '<p class="help-block field-error">:message</p>') !!}
                </div>
            </div>
            @if(isset($slug))
            <div class="col-lg-6">
                <div class="col-lg-1 text-nowrap {{ $errors->has('include_request') ? 'has-error' : ''}}" style="height: 36px">
                    <label for="include_request" class="col-form-label col-sm-12"></label>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            {!! Form::checkbox('include_request', 1, isset($promotion) ? $promotion->include_request : true, ['class' => 'form-control ','name'=>'include_request','id'=>'include_request']) !!}
                            @lang('admin.promotions.forms.include_request')
                            <span></span>
                        </label>
                    </div>
                    {!! $errors->first('include_request', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            @endif
        </div>
        @if(isset($slug))
        <div id="apply_to_0" class="apply_to row">
            <div class="col-lg-6 {{ $errors->has('item_value_from') ? 'has-error' : ''}}">
                <label for="item_value_from" class="col-form-label col-sm-12">@lang('admin.promotions.forms.item_value_from')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('item_value_from', isset($promotion) ? App\Services\CommonService::formatPrice($promotion->item_value_from) : '' , ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('item_value_from', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-6 {{ $errors->has('item_value_to') ? 'has-error' : ''}}">
                <label for="item_value_to" class="col-form-label col-sm-12">@lang('admin.promotions.forms.item_value_to')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('item_value_to', isset($promotion) ? App\Services\CommonService::formatPrice($promotion->item_value_to) : '' , ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('item_value_to', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div id="apply_to_1" class="row apply_to">
            <div class="col-lg-12 {{ $errors->has('categories_id') ? 'has-error' : ''}}">
                <label for="categories_id" class="col-form-label col-sm-12">@lang('admin.promotions.forms.category')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <select multiple name="categories_id[]" class="form-control select2" id="categories_id">
                        <option disabled >--Chọn category--</option>
                        @foreach($categories as $index => $cate)
                            <option value="{{$cate->id}}" >{{$cate->title_en}}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('categories_id', '<p class="help-block field-error">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-6 {{ $errors->has('item_value_from') ? 'has-error' : ''}}">
                <label for="item_value_from" class="col-form-label col-sm-12">@lang('admin.promotions.forms.item_value_from')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('item_value_from', isset($promotion) ? App\Services\CommonService::formatPrice($promotion->item_value_from) : '' , ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('item_value_from', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-6 {{ $errors->has('item_value_to') ? 'has-error' : ''}}">
                <label for="item_value_to" class="col-form-label col-sm-12">@lang('admin.promotions.forms.item_value_to')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('item_value_to', isset($promotion) ? App\Services\CommonService::formatPrice($promotion->item_value_to) : '' , ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('item_value_to', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div id="apply_to_2" class="apply_to">
            <div class="{{ $errors->has('dishes_id') ? 'has-error' : ''}}">
                <label for="dishes_id" class="col-form-label col-sm-12">@lang('admin.promotions.forms.dish')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <select multiple name="dishes_id[]" class="form-control select2" id="dishes">
                        <option disabled >--Chọn dish--</option>
                        @foreach($dishes as $index => $dish)
                            <option value="{{$dish->id}}" >{{$dish->name_en}}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('dishes_id', '<p class="help-block field-error">:message</p>') !!}
                </div>
            </div>
        </div>
        @endif
        <div id="apply_to_3" class="apply_to row">
            <div class="col-lg-6 {{ $errors->has('min_order_value') ? 'has-error' : ''}}">
                <label for="min_order_value" class="col-form-label col-sm-12">@lang('admin.promotions.forms.min_order_value')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('min_order_value', isset($promotion) ? $promotion->min_order_value : '' , ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('min_order_value', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-6 {{ $errors->has('max_order_value') ? 'has-error' : ''}}">
                <label for="max_order_value" class="col-form-label col-sm-12">@lang('admin.promotions.forms.max_order_value')
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12">
                    {!! Form::text('max_order_value', isset($promotion) ? $promotion->max_order_value : '' , ['class' => 'form-control m-input','required'=>'required']) !!}
                    {!! $errors->first('max_order_value', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="form-group m-form__group col-lg-12 apply_form">
      <b>AVAILABLE TIMES</b>
      @if(isset($promotion))
        @include('admin.timesetting.form',['time_setting' => $promotion->time_setting])
      @else
        @include('admin.timesetting.form')
      @endif

    </div>
    {{-- <div class="form-group m-form__group col-lg-12">
        <label class="col-form-label col-lg-12 col-sm-12 text-left">
            @lang('admin.promotions.forms.image') {{ csrf_field() }}
        </label>
        <div class="col-lg-12 col-md-9 col-sm-12">
            <div class="m-dropzone  dropzone m-dropzone--primary" id="m-dropzone-two">
                <div class="m-dropzone__msg dz-message needsclick">
                    <h3 class="m-dropzone__msg-title">
                        @lang('admin.promotions.text.upload_text')
                    </h3>
                </div>
            </div>
        </div>
        {!! $errors->first('image', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
    </div> --}}

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                @if(isset($promotion))
                    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.promotions.buttons.upgrate'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                @else
                    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.promotions.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                @endif
                <a href="{{url('admin/'.(isset($slug) ? $res->res_Slug.'/promotions' : 'vouchers'))}}" class="btn btn-secondary">
                    @lang('admin.promotions.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>


@section('extra_scripts')
    @include('admin.promotions.script')
    @include('admin.timesetting.script')
@endsection
