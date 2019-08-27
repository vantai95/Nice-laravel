<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-4 {{$errors->has('district_id') ? 'has-danger' : ''}}">
            <label for="district_id" class="col-form-label col-sm-12">
                @lang('admin.restaurant_delivery_settings.columns.district_id')
                <span class="text-danger">*</span></label>
            <div class="col-sm-12">
                <select class="form-control m-input select2" id="district_id" name="district_id">
                    @php
                        $districts = \App\Models\District::select('id','type_en','name_en')->get();
                    @endphp
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ (isset($mainRes) && $mainRes->district_id  == $district->id ) ? 'selected' : '' }}>
                            {{ $district->name_en }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('district_id', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{$errors->has('ward_id') ? 'has-danger' : ''}}">
            <label for="ward_id" class="col-form-label col-sm-12">
                @lang('admin.restaurant_delivery_settings.columns.ward_id')
            </label>
            <div class="col-sm-12">
                <select class="form-control m-input select2" id="ward_id" name="ward_id">
                    <option value="">Any</option>
                    @foreach(\App\Models\Ward::select('id','type_en','name_en')->where('district_id',(isset($mainRes) ? $mainRes->district_id : $districts[0]->id))->get() as $ward)
                        <option value="{{ $ward->id }}" {{ (isset($mainRes) && $mainRes->ward_id  == $ward->id ) ? 'selected' : '' }}>
                            {{ $ward->type_en . " " . $ward->name_en }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('ward_id', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('min_order_amount') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurant_delivery_settings.columns.min_order_amount')
                <span class="text-danger">*</span></label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('min_order_amount',null, ['class' => 'form-control number-format','id' => 'min_order_amount','onkeypress' => 'return isNumber(event)']) !!}
                {!! $errors->first('min_order_amount', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">        
        <div class="col-lg-4 {{ $errors->has('delivery_cost') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurant_delivery_settings.columns.delivery_cost')
                <span class="text-danger">*</span></label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('delivery_cost',null, ['class' => 'form-control number-format','id' => 'delivery_cost', 'onkeypress' => 'return isNumber(event)']) !!}
                {!! $errors->first('delivery_cost', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('from') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">
            @lang('admin.restaurant_delivery_settings.columns.from')
                <span class="text-danger">*</span></label></label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('from',null, ['class' => 'form-control number-format','id' => 'from','onkeypress' => 'return isNumber(event)']) !!}
                {!! $errors->first('from', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-4 {{ $errors->has('to') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurant_delivery_settings.columns.to')
                <span class="text-danger">*</span></label></label>
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('to',null, ['class' => 'form-control number-format','id' => 'to','onkeypress' => 'return isNumber(event)']) !!}
                {!! $errors->first('to', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group">   
        <div class="col-lg-4 row {{ $errors->has('time') ? 'has-error' : ''}}">
            <label class="col-form-label col-sm-12">@lang('admin.restaurant_delivery_settings.columns.time_delivery')
                <span class="text-danger">*</span></label>
            <div class="col-lg-12 col-md-12 col-sm-12 bootstrap-timepicker-widget">
                {!! Form::text('time',null, ['class' => 'form-control timepicker','id' => 'time']) !!}
                {!! $errors->first('time', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row col-sm-12" style="margin-bottom: 20px">
    <div class="col-lg-6">
        <h5 class="modal-title"> Extra delivery setting</h5>
    </div>
    <div class="col-lg-6">
        <button type="button" onclick="addMoreDeliveryItem()" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add more</button>
    </div>
</div>

<div class="extra-delivery-setting-section">
</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/'.$res->res_Slug.'/restaurant-delivery-settings')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    @if(isset($subDS))
        @include('admin.restaurant_delivery_settings.script',['subDS' => $subDS]);
    @else
        @include('admin.restaurant_delivery_settings.script');
    @endif
    <script>
        $('.number-format').mask("#.##0", {reverse: true});

        $('#submitForm').submit(function () {
            $('.number-format').unmask();
        });


        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        $(document).ready(function () {
            $('#delivery_district_id').select2();
            $('#delivery_time').timepicker({
                format: 'HH:mm',
                showMeridian: false,
                minuteStep: 1,
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#district_id').change(function () {
                mApp.blockPage({overlayColor:"#000000",type:"loader",state:"success",message:"Please wait..."});
                $.ajax({
                    url: '/admin/get-wards?district_id='+$(this).val(),
                    type: 'get',
                    success: function (data) {
                        appendWards(data);
                        mApp.unblockPage();
                    }
                });
            });
        });
        function appendWards(wards) {
            $('#ward_id').html(`<option value="">Any</option>`);
            $.each(wards,function () {
                $('#ward_id').append(`<option value="${this.id}">${this.type} ${this.name}</option>`);
            });
        }
    </script>
@endsection
