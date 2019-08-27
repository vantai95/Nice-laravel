@php
    $statusFilter = [
        trans('admin.restaurants.restaurant_status.popular') => 0,
        trans('admin.restaurants.restaurant_status.new') => 1,
        trans('admin.restaurants.restaurant_status.promotion') => 2,
        trans('admin.restaurants.restaurant_status.high_quality') => 3,
        trans('admin.restaurants.restaurant_status.no_status') => 4
    ];
    isset($restaurant) ? $otpValue = $restaurant->otp_value : $otpValue = 0;
    isset($restaurant) ? $otp = $restaurant->otp : $otp = 0;

@endphp
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
                                    Restaurant Info
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->isAdmin() && !empty($restaurant))
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6 {{ $errors->has('slug') ? 'has-error' : ''}} slug">
                            <label for="slug" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.slug')
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text('slug', null, ['class' => 'form-control m-input', 'pattern' => '[A-Za-z0-9-]+' ]) !!}
                                {!! $errors->first('slug', '<p class="help-block field-error">:message</p>') !!}
                                <p class="help-block field-error regex">Input only characters: a-z, A-z, 0-9, - </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="form-group m-form__group row">
                    <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-error' : ''}}">
                        <label for="name_en" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.name_en')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text('name_en', null, ['class' => 'form-control m-input']) !!}
                            {!! $errors->first('name_en', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-lg-6 {{ $errors->has('name_ja') ? 'has-error' : ''}}">
                        {!! Form::label('name_ja', trans('admin.restaurants.forms.name_ja'), ['class' => 'col-form-label col-sm-12']) !!}
                        <div class="col-sm-12">
                            {!! Form::text('name_ja', null, ['class' => 'form-control m-input']) !!}
                            {!! $errors->first('name_ja', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-lg-6 {{ $errors->has('description_en') ? 'has-error' : ''}}">
                        <label for="description_en"
                               class="col-form-label col-sm-12">@lang('admin.restaurants.forms.description_en')
                        </label>
                        <div class="col-sm-12">
                            {!! Form::textarea('description_en', null, ['class' => 'summernote', 'rows' => 10]) !!}
                            {!! $errors->first('description_en', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-lg-6 {{ $errors->has('description_ja') ? 'has-error' : ''}}">
                        {!! Form::label('description_ja', trans('admin.restaurants.forms.description_ja'), ['class' => 'col-form-label col-sm-12']) !!}
                        <div class="col-sm-12">
                            {!! Form::textarea('description_ja', null, ['class' => 'summernote', 'rows' => 10]) !!}
                            {!! $errors->first('description_ja', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-lg-12 {{ $errors->has('note') ? 'has-error' : ''}}">
                        <label for="note"
                               class="col-form-label col-sm-12">@lang('admin.restaurants.forms.note')
                        </label>
                        <div class="col-sm-12">
                            {!! Form::textarea('note', null, ['class' => 'summernote', 'rows' => 10]) !!}
                            {!! $errors->first('note', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row" style="display:none">
                    <div class="col-lg-6 {{ $errors->has('title_brief_en') ? 'has-error' : ''}}">
                        <label for="title_brief_en"
                               class="col-form-label col-sm-12">@lang('admin.restaurants.forms.title_brief_en')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text('title_brief_en', null, ['class' => 'form-control m-input']) !!}
                            {!! $errors->first('title_brief_en', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-lg-6 {{ $errors->has('title_brief_ja') ? 'has-error' : ''}}">
                        {!! Form::label('title_brief_ja', trans('admin.restaurants.forms.title_brief_ja'), ['class' => 'col-form-label col-sm-12']) !!}
                        <div class="col-sm-12">
                            {!! Form::text('title_brief_ja', null, ['class' => 'form-control m-input']) !!}
                            {!! $errors->first('title_brief_ja', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-lg-6 {{ $errors->has('tags') ? 'has-error' : ''}}">
                        <label for="ward_id"
                               class="col-form-label col-sm-12">@lang('admin.restaurants.forms.tags')<span class="text-danger">*</span></label>

                        <div class="col-sm-12">
                            {!! Form::select('tags',\App\Models\Tag::pluck("name_$lang",'id') ,isset($restaurant) ? $restaurant->tags : null,['class' => 'form-control select2 tags-select2','id' => 'tags','multiple' => 'multiple','name' => 'tags[]']) !!}

                            {{--<select multiple name="tags[]" class="form-control select2" id="tags">--}}
                            {{--<option disabled >--@lang('admin.restaurants.forms.choose_tags')--</option>--}}
                            {{--@foreach(\App\Models\Tag::all() as $index => $tag)--}}
                            {{--@if(!empty($restaurant) && !empty($restaurant->title_brief_en))--}}
                            {{--<option value="{{$tag->id}}" @if (in_array($tag->name_en,(explode(",",$restaurant->title_brief_en)))) selected @endif>{{$tag->name_en}}</option>--}}
                            {{--@else--}}
                            {{--<option value="{{$tag->id}}" >{{$tag->name_en}}</option>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {!! $errors->first('tags', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-2 {{ $errors->has('active') ? 'has-error' : ''}}">
                        <div class="col-sm-12">
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    {!! Form::checkbox('active', 1, isset($restaurant) ? $restaurant->active : true, ['class' => 'form-control ', 'name'=>'active', 'id'=>'active']) !!}
                                    @lang('admin.restaurants.forms.active')
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        {!! $errors->first('active', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                    <div class="col-lg-4 {{ $errors->has('maximum_discount') ? 'has-error' : ''}}">
                        <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.maximum_discount')
                        </label>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            {!! Form::text('maximum_discount',null, ['class' => 'form-control','id' => 'maximum_discount']) !!}
                            {!! $errors->first('maximum_discount', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-lg-12 {{ $errors->has('address_en') ? 'has-error' : ''}}">
                        <label for="address_en"
                               class="col-form-label col-sm-12">@lang('admin.restaurants.forms.address')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text('address_en', null, ['class' => 'form-control m-input']) !!}
                            {!! $errors->first('address_en', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-lg-4 {{ $errors->has('province_id') ? 'has-error' : ''}}">
                        <label for="province_id"
                               class="col-form-label col-sm-12">@lang('admin.restaurants.forms.province')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            {!! Form::select('province_id',\App\Models\Province::pluck("name_$lang",'id') ,isset($restaurant) ? $restaurant->province_id : null,['class' => 'form-control province-select2','id' => 'province_id']) !!}

                            {{--<select required name="province_id" class="form-control select2" id="province_id">--}}
                            {{--@if(empty($restaurant))--}}
                            {{--<option disabled >--@lang('admin.restaurants.forms.choose_province')--</option>--}}
                            {{--@endif--}}
                            {{--@foreach(\App\Models\Province::all() as $index=>$province)--}}
                            {{--@if(!empty($restaurant))--}}
                            {{--<option {{ $restaurant->province_id == $province->id ? 'selected' : '' }} value="{{$province->id}}">{{$province->name_en}}</option>--}}
                            {{--@else--}}
                            {{--<option value="{{$province->id}}" @if($index==0) selected @endif >{{$province->name_en}}</option>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-lg-4 {{ $errors->has('district_id') ? 'has-error' : ''}}">
                        <label for="restaurant_id"
                               class="col-form-label col-sm-12">@lang('admin.restaurants.forms.district')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            {!! Form::select('district_id',\App\Models\District::pluck("name_$lang",'id') ,isset($restaurant) ? $restaurant->district_id : null,['class' => 'form-control district-select2','id' => 'district_id']) !!}

                            {{--<select required name="district_id" class="form-control select2" id="district_id">--}}
                            {{--<option value="">--@lang('admin.restaurants.forms.choose_district')--</option>--}}

                            {{--@foreach(\App\Models\District::select("id","name_$lang as district_name","type_$lang as district_type")->get() as $index=>$district)--}}
                            {{--@if(!empty($restaurant))--}}
                            {{--<option value="{{$district->id}}" {{ isset($restaurant) ? ($restaurant->district_id == $district->id ? 'selected' : '') : ''}}>{{$district->district_type . ' ' . $district->district_name}}</option>--}}
                            {{--@else--}}
                            {{--<option value="{{$district->id}}"--}}
                            {{--@if($index==0) selected @endif >{{$district->name_en}}</option>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--@if(empty($restaurant))--}}
                            {{--<option disabled>--@lang('admin.restaurants.forms.choose_district')--</option>--}}
                            {{--@endif--}}
                            {{--@foreach(\App\Models\District::all() as $index=>$district)--}}
                            {{--@if(!empty($restaurant))--}}
                            {{--<option {{ $restaurant->district_id == $district->id ? 'selected' : '' }} value="{{$district->id}}">{{$district->name_en}}</option>--}}
                            {{--@else--}}
                            {{--<option value="{{$district->id}}"--}}
                            {{--@if($index==0) selected @endif >{{$district->name_en}}</option>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-4 {{ $errors->has('ward_id') ? 'has-error' : ''}}">
                        <label for="ward_id" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.ward')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            {!! Form::select('ward_id',\App\Models\Ward::pluck("name_$lang",'id') ,isset($restaurant) ? $restaurant->ward_id : null,['class' => 'form-control ward-select2','id' => 'ward_id']) !!}

                            {{--<select required name="ward_id" class="form-control select2" id="ward_id">--}}
                            {{--<option>--@lang('admin.restaurants.forms.choose_ward')--</option>--}}
                            {{--@foreach(\App\Models\Ward::select("id","name_$lang as ward_name","type_$lang as ward_type")->get() as $index=>$ward)--}}
                            {{--@if(!empty($restaurant))--}}
                            {{--<option value="{{$ward->id}}" {{ isset($restaurant) ? ($restaurant->ward_id == $ward->id ? 'selected' : '') : ''}}>{{$ward->ward_type . ' ' . $ward->ward_name}}</option>--}}
                            {{--@else--}}
                            {{--<option value="{{$district->id}}"--}}
                            {{--@if($index==0) selected @endif >{{$district->name_en}}</option>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {!! $errors->first('ward_id', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-lg-4 {{ $errors->has('phone') ? 'has-error' : ''}}">
                        <label for="phone" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.phone')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text('phone', null, ['class' => 'form-control m-input','onkeypress' => 'return isNumber(event)','maxlength' => '10']) !!}
                            {!! $errors->first('phone', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-lg-4 {{ $errors->has('email') ? 'has-error' : ''}}">
                        <label for="email" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.email')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text('email', null, ['class' => 'form-control m-input']) !!}
                            {!! $errors->first('email', '<p class="help-block field-error">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-4 {{ $errors->has('status') ? 'has-error' : ''}}">
                        <label for="status" class="col-form-label col-sm-12">@lang('admin.restaurants.forms.status')
                            <span class="text-danger">*</span>
                        </label>
                        @if (Auth::user()->isAdmin())
                        <div class="col-sm-12">
                            {!! Form::select('status', array_flip($statusFilter) ,isset($restaurant) ? $restaurant->status : 4,['class' => 'form-control status-select2','id' => 'status']) !!}
                            {{--<select required name="status" class="form-control select2" id="status" @if (!Auth::user()->isAdmin()) disabled @endif>--}}
                            {{--@if(empty($restaurant))--}}
                            {{--<option disabled >--@lang('admin.restaurants.forms.choose_status')--</option>--}}
                            {{--@endif--}}
                            {{--@foreach($statuses as $key=>$value)--}}
                            {{--@if(!empty($restaurant))--}}
                            {{--<option {{ $restaurant->status == $value ? 'selected' : '' }} value="{{$value}}">{{ucfirst(strtolower($key))}}</option>--}}
                            {{--@else--}}
                            {{--<option value={{$value}} @if($key == \App\Models\Restaurant::STATUSES_FILTER['new']) selected @endif>{{ucfirst(strtolower($key))}}</option>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                        </div>
                        @else
                            <div class="col-sm-12">
                                <div class="form-control m-input"><label>{{isset($restaurant) ? $restaurant->resStatus() : "New"}}</label></div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    @if(Auth::user()->isAdmin())
                        <div class="col-lg-4 {{ $errors->has('vip_restaurant') ? 'has-error' : ''}}">
                            {!! Form::label('vip_restaurant', trans('admin.restaurants.forms.vip_restaurant'), ['class' => 'col-form-label col-sm-12']) !!}
                            <div class="col-sm-12">
                                {!! Form::select('vip_restaurant', \App\Models\Restaurant::getRestaurantVipList(), isset($restaurant) ? $restaurant->vip_restaurant : null, ['class' => 'form-control vip-select2','disabled'=>'disabled']) !!}
                                {!! $errors->first('vip_restaurant', '<p class="help-block field-error">:message</p>') !!}
                            </div>
                        </div>
                    @endif
                </div>

                {{--<div class="form-group m-form__group row">--}}
                {{--<div class="col-lg-6 {{ $errors->has('latitude') ? 'has-error' : ''}}">--}}
                {{--{!! Form::label('latitude', trans('admin.restaurants.forms.latitude'), ['class' => 'col-form-label col-sm-12']) !!}--}}
                {{--<div class="col-sm-12">--}}
                {{--{!! Form::text('latitude', null, ['class' => 'form-control m-input']) !!}--}}
                {{--{!! $errors->first('latitude', '<p class="help-block field-error">:message</p>') !!}--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-lg-6 {{ $errors->has('longitude') ? 'has-error' : ''}}">--}}
                {{--{!! Form::label('longitude', trans('admin.restaurants.forms.longitude'), ['class' => 'col-form-label col-sm-12']) !!}--}}
                {{--<div class="col-sm-12">--}}
                {{--{!! Form::text('longitude', null, ['class' => 'form-control m-input']) !!}--}}
                {{--{!! $errors->first('longitude', '<p class="help-block field-error">:message</p>') !!}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row m-content">
        <div class="col-lg-4">
            <div class="m-portlet">
                <div class="col-lg-12">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide ">
                                <i class="la la-gear">*</i>
                                </span>
                                <h5 class="m-portlet__head-text">
                                    Payment Setting<span class="text-danger">*</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row {{ $errors->has('online_payment') ? 'has-error' : ''}}">
                        <div class="col-sm-12">
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    {!! Form::checkbox('online_payment', isset($restaurant) ? $restaurant->online_payment : 0, isset($restaurant) ? $restaurant->online_payment : false, ['class' => 'form-control ', 'name'=>'online_payment', 'id'=>'online_payment']) !!}
                                    @lang('admin.restaurants.forms.online_payment')
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        {!! $errors->first('online_payment', '<p class="help-block field-error">:message</p>') !!}
                    </div>

                    <div class="row {{ $errors->has('cod_payment') ? 'has-error' : ''}}">
                        <div class="col-sm-12">
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    {!! Form::checkbox('cod_payment', isset($restaurant) ? $restaurant->cod_payment : 0, isset($restaurant) ? $restaurant->cod_payment : false, ['class' => 'form-control ', 'name'=>'cod_payment', 'id'=>'cod_payment']) !!}
                                    @lang('admin.restaurants.forms.cod_payment')
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        {!! $errors->first('cod_payment', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="m-portlet">
                <div class="col-lg-12">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                                </span>
                                <h5 class="m-portlet__head-text">
                                    Delivery Setting<span class="text-danger">*</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row {{ $errors->has('delivery') ? 'has-error' : ''}}">
                        <div class="col-sm-12">
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    {!! Form::checkbox('delivery', isset($restaurant) ? $restaurant->delivery : 0, isset($restaurant) ? $restaurant->delivery : false, ['class' => 'form-control ', 'name'=>'delivery', 'id'=>'delivery']) !!}
                                    @lang('admin.restaurants.forms.delivery')
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        {!! $errors->first('delivery', '<p class="help-block field-error">:message</p>') !!}
                    </div>

                    <div class="row {{ $errors->has('pickup') ? 'has-error' : ''}}">
                        <div class="col-sm-12">
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    {!! Form::checkbox('pickup', isset($restaurant) ? $restaurant->pickup : 0, isset($restaurant) ? $restaurant->pickup : false, ['class' => 'form-control ', 'name'=>'pickup', 'id'=>'pickup']) !!}
                                    @lang('admin.restaurants.forms.pickup')
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        {!! $errors->first('pickup', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="m-portlet">
                <div class="col-lg-12">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                                </span>
                                <h5 class="m-portlet__head-text">
                                    Send OTP Setting
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row {{ $errors->has('otp') ? 'has-error' : ''}}">
                        {!! Form::label('otp', trans('admin.restaurants.forms.otp'), ['class' => 'col-form-label col-sm-12 col-lg-6']) !!}
                        <div class="col-sm-12 col-lg-6">
                            <div class="d-inline-flex">
                                <div class="btn btn-info" id="decreaseOtp" onclick="decreaseOtp()">
                                    <span class="glyphicon glyphicon-plus"></span> -
                                </div>
                                {!! Form::text('otp', number_format( $otp,0,'.',','), ['class' => 'form-control m-input','id' => 'otp','min'=>1]) !!}
                                <div class="btn btn-info" id="increaseOtp" onclick="increaseOtp()">
                                    <span class="glyphicon glyphicon-minus"></span> +
                                </div>
                            </div>
                        </div>
                        {!! $errors->first('otp', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                    <div class="row {{ $errors->has('otp_value') ? 'has-error' : ''}}">
                        {!! Form::label('otp_value', trans('admin.restaurants.forms.otp_value'), ['class' => 'col-form-label col-sm-12 col-lg-6']) !!}
                        <div class="col-sm-12  col-lg-6">
                            <div class="d-inline-flex">
                                <div class="btn btn-info" id="decreaseOtpValue" onclick="decreaseOtpValue()">
                                    <span class="glyphicon glyphicon-plus"></span> -
                                </div>
                                {!! Form::text('otp_value',number_format( $otpValue,0,'.',','), ['class' => 'form-control m-input','id' => 'otp_value']) !!}
                                <div class="btn btn-info" id="increaseOtpValue" onclick="increaseOtpValue()">
                                    <span class="glyphicon glyphicon-minus"></span> +
                                </div>
                            </div>
                        </div>
                        {!! $errors->first('otp_value', '<p class="help-block field-error">:message</p>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h5 class="m-portlet__head-text">
                        @lang('admin.restaurants.form_title.owner_detail')
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('owner_name') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.owner_name')
            </label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('owner_name',null, ['class' => 'form-control','id' => 'owner_name']) !!}
                {!! $errors->first('owner_name', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('owner_phone') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.owner_phone')
            </label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('owner_phone',null, ['class' => 'form-control','id' => 'owner_phone','onkeypress' => 'return isNumber(event)','maxlength' => '10']) !!}
                {!! $errors->first('owner_phone', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('owner_email') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.owner_email')
            </label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('owner_email',null, ['class' => 'form-control','id' => 'owner_email']) !!}
                {!! $errors->first('owner_email', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h5 class="m-portlet__head-text">
                        @lang('admin.restaurants.detail_info.chosen_faq')
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-12 {{ $errors->has('name_vi') ? 'has-danger' : ''}}">
            <div class="col-sm-12">
                <select multiple name="faqs[]" class="form-control select2" id="faqs">
                    <option disabled>--@lang('admin.restaurants.detail_info.chosen_faq')--</option>
                    @foreach($faqs as $index => $item)
                    <option value="{{$item->id}}">{{$item->name_en}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-12">
            <label class="col-form-label col-lg-3 col-sm-12">
                @lang('admin.restaurants.columns.image') {{ csrf_field() }}
            </label>
            <div class="col-sm-12">
                <div class="m-dropzone dropzone m-dropzone--primary" id="m-dropzone-two">
                    <div class="m-dropzone__msg dz-message needsclick">
                        <h3 class="m-dropzone__msg-title">
                            @lang('admin.restaurants.text.upload_text')
                        </h3>
                    </div>
                </div>
            </div>
            {!! $errors->first('image', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="offset-5">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.restaurants.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/restaurants')}}" class="btn btn-secondary">
                    @lang('admin.restaurants.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    <script>
        var token = $('input[name="_token"]').val();
        var DropzoneDemo = {
            init: function () {

                Dropzone.options.mDropzoneTwo = {
                    paramName: "file",
                    maxFiles: 1,
                    maxFilesize: 10,
                    addRemoveLinks: true,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    removedfile: function(file){
                        file.previewElement.remove();
                        return true;
                    },
                    accept: function (e, o) {
                        "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                    },
                    'url': "{{ url('/admin/restaurants/upload') }}",
                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                    init: function () {
                        @if(!empty($restaurant->image))
                            this.addCustomFile = function (file, thumbnail_url, responce) {
                            // Push file to collection

                            file.name = "{{$restaurant->image}}";
                            this.files.push(file);
                            // Emulate event to create interface
                            this.emit("addedfile", file);
                            // Add thumbnail url
                            this.emit("thumbnail", file, '{{CommonService::buildImageURL($restaurant->image)}}');
                            // Add status processing to file
                            this.emit("processing", file);
                            // Add status success to file AND RUN EVENT success from responce
                            this.emit("success", file, responce, false);
                            // Add status complete to file
                            this.emit("complete", file);

                        }
                        this.addCustomFile(
                            // Thumbnail url
                            //"http://localhost:8000/images/news/1536742929.0.png",
                            // Custom responce for event success
                            {
                                status: "success"
                            }
                        );
                        this.on("addedfile", function() {
                            if (this.files[1]!=null){
                                this.removeFile(this.files[0]);
                            }
                        });
                        {{--@endforeach--}}
                        @endif
                    }
                }
            }
        };
        DropzoneDemo.init();

        //focus when select2 option is selected
        $(".tags-select2").on('select2:close', function(e) {
            var select2SearchField = $(this).parent().find('.select2-search__field'),
                setfocus = setTimeout(function() {
                    select2SearchField.focus();
                }, 100);
        });
        $(document).ready(function () {
            $("#submitButton").click(function () {
                    $('.news').remove();
                    $('#m-dropzone-two').find('img').each(function (index) {
                        $('#submitForm').append('<input type="hidden" class="news" name="image_' + $(this).attr('alt') + '" value="' + $(this).attr('src') + '" /> ');
                    });
                }
            )
            $('.province-select2').select2();
            $('.district-select2').select2();
            $('.ward-select2').select2();
            $('.status-select2').select2();
            $('.vip-select2').select2();
            $(".select2.tags-select2").select2({
                maximumSelectionLength: 3,
                language: {
                    maximumSelected: function (e) {
                        return "{{trans('admin.restaurants.maximum_selection')}}";
                    }
                }
            });
            $("input[name='maximum_discount']").mask("#.##0",{reverse:true});

            var slug = $("input[name='slug']").value;
            var regex = /^([A-Za-z0-9-]+)$/;
            if (regex.test(slug)) {
                $('.slug .regex').hide();
            }
            else {
                $('.slug .regex').show();
            }
        });

        $("select[name='district_id']").on('change', function() {
            var district_id = $("select[name='district_id']").val();
            var url = "/locations/" + district_id + "/wards";
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                success:function(res){
                    console.log(res);
                }

            });
        })

        $("input[name='slug']").bind('keyup', function () {
            var slug = this.value;
            var regex = /^([A-Za-z0-9-]+)$/;

            if (regex.test(slug)) {
                $('.slug .regex').hide();
            }
            else {
                $('.slug .regex').show();
            }
        });

        function getWards(district_id) {
            var url = "/locations/" + district_id + "/wards";
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                success:function(res){
                    $("select[name='ward_id']").html('');
                    $("select[name='ward_id']").append("<option disabled >--@lang('admin.restaurants.forms.choose_district')--</option>");
                    $.each(res.wards, function(key, ward) {
                        $("select[name='ward_id']").append("<option value=" + ward.id + ">" + ward.name + "</option>");
                    })
                }
            });
        }

        $("select[name='district_id']").on('change', function() {
            getWards($(this).val());
        })
        

        // var IONRangeSlider={
        //     init: function() {
        //         $("#vip_restaurant").ionRangeSlider({
        //             skin: 'big',
        //             min: 0,
        //             max: 10,
        //             step: 1,
        //            disable: "false" !== "{{ Auth::user()->isAdmin() ? 'false' : 'true' }}",
        //            from: '{{ isset($restaurant) ? $restaurant->vip_restaurant : 0 }}',
        //             prefix: 'VIP '
        //           })
        //     }
        //  };
        

        // Increase Decrease OPT
        $('#otp').mask("#.##0",{reverse:true});
        $('#otp_value').mask("#.##0",{reverse:true});

        $('#submitForm').submit(function(){
            $('#otp').unmask();
            $('#otp_value').unmask();
        });

        function increaseOtp() {
            var value = parseInt(document.getElementById('otp').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('otp').value = value;
        }

        function decreaseOtp() {
            var value = parseInt(document.getElementById('otp').value, 10);
            value = isNaN(value) ? 1 : value;
            value < 1 ? value = 1 : '';
            value--;
            if(value<1)
                value =1
            document.getElementById('otp').value = value;
        }

        function increaseOtpValue() {
            $('#otp_value').unmask();
            var value = parseInt(document.getElementById('otp_value').value);
            value+=10000;
            document.getElementById('otp_value').value = value;
            $('#otp_value').mask("#.##0",{reverse:true});
        }

        function decreaseOtpValue() {
            $('#otp_value').unmask();
            var value = parseInt(document.getElementById('otp_value').value);
            value = isNaN(value) ? 0 : value;
            value < 0 ? value = 0 : '';
            value-=10000;
            if(value<0)
                value =0
            document.getElementById('otp_value').value = value;
            $('#otp_value').mask("#.##0",{reverse:true});
        }
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
