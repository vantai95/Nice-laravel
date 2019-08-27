@php
    $resId = \Illuminate\Support\Facades\Session::get('res')->id;
@endphp
<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="col-lg-12">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h5 class="m-portlet__head-text">
                        @lang('admin.restaurants.form_title.res_detail')
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-9 {{ $errors->has('name_en') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12"><b>@lang('admin.restaurants.detail_info.res_id'): {{$resId}}</b></label>
        </div>
        <div class="col-lg-4 {{ $errors->has('name_en') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.restaurant_name')
                <span class="text-danger">*</span></label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('name_en',null, ['class' => 'form-control','id' => 'name_en']) !!}
                {!! $errors->first('name_en', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('phone') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.restaurant_phone')
                <span class="text-danger">*</span></label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('phone',null, ['class' => 'form-control','id' => 'phone']) !!}
                {!! $errors->first('phone', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('email') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.restaurant_email')
                <span class="text-danger">*</span></label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('email',null, ['class' => 'form-control','id' => 'email']) !!}
                {!! $errors->first('email', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-12 {{ $errors->has('address_en') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.restaurant_address')
                <span class="text-danger">*</span></label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('address_en',null, ['class' => 'form-control','id' => 'address_en']) !!}
                {!! $errors->first('address_en', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('province_id') ? 'has-error' : ''}}">
            <label for="province_id"
                   class="col-form-label col-sm-12">@lang('admin.restaurants.forms.province')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::select('province_id',\App\Models\Province::pluck("name_$lang",'id') ,isset($detailInfo) ? $detailInfo->province_id : null,['class' => 'form-control province-select2','id' => 'province_id']) !!}
                {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('district_id') ? 'has-error' : ''}}">
            <label for="district_id"
                   class="col-form-label col-sm-12">@lang('admin.restaurants.forms.district')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::select('district_id',\App\Models\District::pluck("name_$lang",'id') ,isset($detailInfo) ? $detailInfo->district_id : null,['class' => 'form-control district-select2','id' => 'district_id']) !!}
                {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('ward_id') ? 'has-error' : ''}}">
            <label for="province_id"
                   class="col-form-label col-sm-12">@lang('admin.restaurants.forms.ward')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::select('ward_id',\App\Models\Ward::pluck("name_$lang",'id') ,isset($detailInfo) ? $detailInfo->ward_id : null,['class' => 'form-control ward-select2','id' => 'ward_id']) !!}
                {!! $errors->first('ward_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{ $errors->has('link') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.restaurant_link')
            </label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('link',null, ['class' => 'form-control','id' => 'link']) !!}
                {!! $errors->first('link', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('slug') ? 'has-error' : ''}} slug">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.forms.slug')
                <span class="text-danger">*</span></label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('slug',null, ['class' => 'form-control','id' => 'slug']) !!}
                {!! $errors->first('slug', '<p class="help-block field-error">:message</p>') !!}
                <p class="help-block field-error regex">Input only characters: a-z, A-z, 0-9, - </p>
            </div>
        </div>
        <div class="col-lg-4">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.forms.status')
            </label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {{$detailInfo->resStatus()}}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row m-content">
        <div class="col-lg-4">
            <div class="m-portlet">
                <div class="col-lg-12">
                    <div class="m-portlet__head pr-0">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                                </span>
                                <h5 class="m-portlet__head-text">
                                    @lang('admin.restaurants.detail_info.payment_setting')
                                    <span class="text-danger">*</span>
                                </h5>

                                <p class="pl-2 pt-3 m-0">
                                    <a href="{{ url('admin/'.$res->res_Slug.'/payment-settings') }}" class="m-menu__link btn btn-primary">
                                        <span class="m-menu__link-text">@lang('admin.restaurants.detail_info.setting')</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @if($payment_type == 'online' || $payment_type == 'cod_and_online')
                        <div class="row {{ $errors->has('online_payment') ? 'has-error' : ''}}">
                            <div class="col-sm-12 pr-1">
                                <div class="m-checkbox-inline">
                                    <label>
                                            @lang('admin.restaurants.forms.online_payment')
                                        <span>(</span>
                                            @if($paypal == true)
                                                @lang('admin.restaurants.detail_info.paypal')
                                            @endif
                                            @if($paypal == true && $nganluong == true)
                                                <span>-</span>
                                            @endif
                                            @if($nganluong == true)
                                                @lang('admin.restaurants.detail_info.ngan_luong')
                                            @endif
                                            @if($paypal == false && $nganluong == false)
                                                @lang('admin.restaurants.detail_info.no_setting')
                                            @endif
                                        <span>)</span>
                                    </label>
                                </div>
                            </div>
{{--                            {!! $errors->first('online_payment', '<p class="help-block field-error">:message</p>') !!}--}}
                        </div>
                    @endif

                    @if($payment_type == 'cod' || $payment_type == 'cod_and_online')
                        <div class="row {{ $errors->has('cod_payment') ? 'has-error' : ''}}">
                            <div class="col-sm-12">
                                <div class="m-checkbox-inline">
                                    <label>
                                        @lang('admin.restaurants.forms.cod_payment')
                                    </label>
                                </div>
                            </div>
{{--                            {!! $errors->first('cod_payment', '<p class="help-block field-error">:message</p>') !!}--}}
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="m-portlet">
                <div class="col-lg-12">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                                </span>
                                <h5 class="m-portlet__head-text">
                                    @lang('admin.restaurants.detail_info.delivery_setting')
                                    <span class="text-danger">*</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row {{ $errors->has('delivery') ? 'has-error' : ''}}">
                        <div class="col-sm-12">
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    {!! Form::checkbox('delivery', isset($detailInfo) ? $detailInfo->delivery : 0, isset($detailInfo) ? $detailInfo->delivery : false, ['class' => 'form-control ', 'name'=>'delivery', 'id'=>'delivery']) !!}
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
                                    {!! Form::checkbox('pickup', isset($detailInfo) ? $detailInfo->pickup : 0, isset($detailInfo) ? $detailInfo->pickup : false, ['class' => 'form-control ', 'name'=>'pickup', 'id'=>'pickup']) !!}
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
        <div class="col-lg-4 {{ $errors->has('maximum_discount') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.maximum_discount')
            </label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                {!! Form::text('maximum_discount',null, ['class' => 'form-control','id' => 'maximum_discount']) !!}
                {!! $errors->first('maximum_discount', '<p class="help-block field-error">:message</p>') !!}
            </div>

            <label class="col-form-label col-sm-12">@lang('admin.restaurants.detail_info.active')</label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                 <span onclick="changeStatus({{$detailInfo->id}})" class="m-switch m-switch--outline m-switch--success">
                    <label class="align-middle" style="margin:0px" >
                        <input type="checkbox" {{( $detailInfo->active ==1 ) ? "checked" : ""}} id="active_{{$detailInfo->id}}" name="active">
                        <span></span>
                    </label>
                </span>
            </div>
        </div>
    </div>

    <div class="row form-group m-form__group">
        <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12" style="padding-right: 10px; border: 1px dashed">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h5 class="m-portlet__head-text">
                            @lang('admin.restaurants.form_title.res_work_time')
                        </h5>
                    </div>
                </div>
            </div>
            @foreach($detailInfo->restaurantWorkTimes as $workTime)
                <div class="row" style="padding-top: 20px;">
                  <div class="col-lg-6">
                    @if($workTime->time_setting->has_special_date)
                      {{ \App\Services\DateTimeHandleService::yymmdd_to_ddmmyy($workTime->time_setting->special_date) }}
                    @elseif($workTime->time_setting->all_days)
                      @lang('admin.time_base_pricing_rules.detail.all_days')
                    @else
                      @foreach(\App\Http\Controllers\Controller::WEEKNAME as $index => $dayName)
                          @if ($workTime->time_setting[$dayName] == 1)
                              <span>
                                {{trans('admin.time_base_pricing_rules.detail.'.$dayName)}},
                              </span>
                          @endif
                      @endforeach
                    @endif
                  </div>
                  <div class="col-lg-6">
                    @if(!$workTime->time_setting->all_times)
                      @foreach($workTime->time_setting->time_setting_details as $setting_details)
                        <div class="row" style="margin-bottom:10px;">
                          <div class="col-lg-12">
                            From time: <b>{{$setting_details->from_time}}</b>
                          </div>
                          <div class="col-lg-12">
                            To time: <b>{{ \App\Services\DateTimeHandleService::calculateHourOver24($setting_details->to_time)}}</b>
                          </div>
                        </div>
                      @endforeach
                    @else
                      All times
                    @endif
                  </div>
                </div>
            @endforeach
            <div class="row" style="margin: 15px -15px;">
                <div class="col-lg-9">
                    <a href="{{url('admin/'.$res->res_Slug.'/restaurant-work-times')}}"
                       class="btn btn-success">@lang('admin.buttons.edit')</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 delivery-setting-section">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h5 class="m-portlet__head-text">
                            @lang('admin.restaurants.form_title.res_delivery')
                        </h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th scope="col">@lang('admin.restaurants.form_title.location')</th>
                        <th scope="col">@lang('admin.restaurants.form_title.minimum')</th>
                        <th scope="col">@lang('admin.restaurants.form_title.fee')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($detailInfo->restaurantDeliverySetting as $delivery)
                        <tr>
                            <td>{{$delivery->district_name}}</td>
                            <td>{{\App\Services\CommonService::formatPriceVND($delivery->min_order_amount)}}</td>
                            <td>{{\App\Services\CommonService::formatPriceVND($delivery->delivery_cost)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row" style=" margin-bottom: 15px;">
                <div class="col-lg-9">
                    <a href="{{url('admin/'.$res->res_Slug.'/restaurant-delivery-settings')}}"
                       class="btn btn-success">@lang('admin.buttons.edit')</a>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="col-lg-12">--}}
    {{--<div class="m-portlet__head">--}}
    {{--<div class="m-portlet__head-caption">--}}
    {{--<div class="m-portlet__head-title">--}}
    {{--<h5 class="m-portlet__head-text">--}}
    {{--@lang('admin.restaurants.form_title.res_delivery')--}}
    {{--</h5>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

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
                    @if(!empty($detailInfo) )
                    <option value="{{$item->id}}" @if(in_array($item->id, $detailInfo->faqs)) selected
                        @endif>{{$item->name_en}}</option>
                    @else
                    <option value="{{$item->id}}">{{$item->name_en}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        @include('admin.components.media.form',[
            'name' => 'restaurant',
            'width' => '12',
            'maxFiles' => 1,
            'img_name_attr' => 'image',
            'variable' => isset($detailInfo) ? $detailInfo : ''
        ])
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
        //validate number
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        $(document).ready(function () {
            $('.province-select2').select2();
            $('.district-select2').select2();
            $('.ward-select2').select2();

            //validate slug
            var slug = $("input[name='slug']").value;
            var regex = /^([A-Za-z0-9-]+)$/;
            if (regex.test(slug)) {
                $('.slug .regex').hide();
            }
            else {
                $('.slug .regex').show();
            }
            $("input[name='maximum_discount']").mask("#.##0",{reverse:true});
        })

        function getWards(district_id) {
            var url = "/locations/" + district_id + "/wards";
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                success: function (res) {
                    $("select[name='ward_id']").html('');
                    $("select[name='ward_id']").append("<option disabled >--@lang('admin.restaurants.forms.choose_district')--</option>");
                    $.each(res.wards, function (key, ward) {
                        $("select[name='ward_id']").append("<option value=" + ward.id + ">" + ward.name + "</option>");
                    })
                }
            });
        }

        $("select[name='district_id']").on('change', function () {
            getWards($(this).val());
        });

        var token = $('input[name="_token"]').val();

        $(document).ready(function () {
            $("#submitButton").click(function () {
                $('.items').remove();
                $('#m-dropzone-two').find('img').each(function (index) {
                    // $('#submitForm').append('<input type="hidden" class="items" id="image_' + index + '" name="image_' + index + '" value="' + $(this).attr('src') + '" /> ');
                    $('#submitForm').append('<input type="hidden" class="items" id="image_' + index + '" name="image' + '" value="' + $(this).attr('src') + '" /> ');
                });
                $('#m-dropzone-two').find('.dz-filename').each(function (index) {
                    var html = $(this).find('span').html();
                    let img_ext = html.split(".").slice(-1)[0];
                    // $('#submitForm').append('<input type="hidden" class="items" name="img_ext_' + index + '" value="' + img_ext + '" /> ');
                    $('#submitForm').append('<input type="hidden" class="items" name="img_ext' + '" value="' + img_ext + '" /> ');
                });
            });
        });

        //change status
        var requesting = [];
        function changeStatus(item_id){
            if(requesting[item_id] === undefined){
                requesting[item_id] = false;
            }
            if(!requesting[item_id])
            {
                requesting[item_id] = true;
                var active = $('#active_'+item_id).prop("checked") ? 0 : 1;
                $.ajax({
                    url: "{{url('admin/restaurants/changeStatusRestaurant')}}",
                    type: "post",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'item_id': item_id,
                        'active': active
                    },
                    success:function(response){
                        if(response.error){
                            toastr.error("@lang('admin.restaurants.restaurant_status.error')");
                        }else{
                            requesting[item_id] = false;
                            toastr.success(response.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection
