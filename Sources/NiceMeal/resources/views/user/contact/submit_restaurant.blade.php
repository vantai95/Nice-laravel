@extends('layouts.app')
@section('content') {!! Form::open(['method' => 'POST', 'url' => '/contact/submit-restaurant','name'=>'submitRestaurantForm','ng-submit'=>
'submitForm($event)','ng-controller'=>'submitCtrl', 'file' => true ,'enctype' => 'multipart/form-data']) !!} @csrf
<div class="md-content restaurant">
    <section class="hero text-center" style="background-image: url('https://i.imgur.com/n1shiqq.jpg')">
        <div style="color:white; font-size:2.5em; text-align:center; position:relative;width:100%">Submit Restaurant</div>
    </section>
    <div class="container">
        <div class="row" style="font-size:2em;font-weight: bold;color:black; text-align:center; margin-top:20px">Restaurant's Information</div>
        <hr>
        <div class="row">
            <div class="col-md-6 pb-2em">
                <label class="form__label ">Restaurant name<span>*</span></label> {!! Form::text('ri_restaurant_name', null,
                ['class' => 'form-control m-input','ng-model'=>'ri_restaurant_name']) !!}
                <div ng-show="error['ri_restaurant_name']" style="color:red; margin-top: 1em">You must be input this field</div>
            </div>

            <div class="col-md-6 pb-2em">
                <label class="form__label">Address<span>*</span></label> {!! Form::text('ri_address', null, ['class' => '
                form-control m-input','ng-model'=>'ri_address']) !!}
                <div ng-show="error['ri_address']" style="color:red; margin-top: 1em">You must be input this field</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pb-2em">
                <label class="form__label">District<span>*</span></label>
                {{-- {!! Form::select('ri_district',\App\Models\District::pluck("name_$language",'id') ,null,['class' => 'form-control district-select2','id' => 'ri_district','ng-model' => 'ri_district']) !!} --}}
                <select id="ri_district" name="ri_district" class="district-select2" ng-model='ri_district'>
                    <option  value="" disabled selected >--Choose District--</option>
                    @foreach ($districts as $index =>$district)
                    <option value="{{$district->id}}" name="{{$district->id}}">{{$district->name}}</option>
                    @endforeach
                </select>
                <div ng-show="error['ri_district']" style="color:red; margin-top: 1em">Please choose option</div>
            </div>
            <div class="col-md-6 pb-2em">
                <label class="form__label">Ward<span>*</span></label>
                {{-- {!! Form::select('ri_ward',\App\Models\Ward::pluck("name_$language",'id') ,null,['class' => 'form-control ward-select2','id' => 'ri_ward','ng-model' => 'ri_ward']) !!} --}}
                <select id="ri_ward" name="ri_ward" class="district-select2" ng-model='ri_ward'>
                    <option  value="" disabled selected >--Choose District--</option>
                    @foreach ($wards as $index =>$ward)
                    <option value="{{$ward->id}}" name="{{$ward->id}}">{{$ward->name}}</option>
                    @endforeach
                </select>
                <div ng-show="error['ri_ward']" style="color:red; margin-top: 1em">Please choose option </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pb-2em">
                <label class="form__label">Phone<span>*</span></label> {!! Form::text('ri_phone', null, ['class' => 'form-control
                m-input', 'maxlength' =>'8','onkeypress' => 'return isNumber(event)','ng-model'=>'ri_phone']) !!}
                <div ng-show="error['ri_phone']" style="color:red; margin-top: 1em">You must be input this field and Phone number must be 8 digits</div>

            </div>
            <div class="col-md-6 pb-2em">
                <label class="form__label">Email<span>*</span></label> {!! Form::text('ri_email', null, ['class' => ' form-control
                m-input','ng-model'=>'ri_email']) !!}
                <div ng-show="error['ri_email']" style="color:red; margin-top: 1em">You must be input this field and The Email must be a valid email address</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pb-2em">
                <label class="form__label">Link<span>*</span></label> {!! Form::text('ri_link', null, ['class' => 'form-control
                m-input','ng-model'=>'ri_link']) !!}
                <div ng-show="error['ri_link']" style="color:red; margin-top: 1em">You must be input this field</div>
            </div>
            <div class="col-md-6 pb-2em">
                <label class="form__label">Food cuisine<span>*</span></label>
                {!! Form::select('ri_food_cuisine',\App\Models\Tag::pluck("name_$language",'id') ,null,['class' => 'form-control select2 tags-select2','id' => 'ri_food_cuisine','multiple' => 'multiple','ng-model' => 'ri_food_cuisine']) !!}
                <div ng-show="error['ri_food_cuisine']" style="color:red; margin-top: 1em">You must be choose at least one option</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pb-2em">
                <label class="form__label">Services<span>*</span></label>
                <div class="widget__content" style="border: 1px solid #ededed; border-radius:5px; text-align:center">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="checkbox custom-checkbox-02">
                                <label class="custom-control custom-checkbox">
                                    {!! Form::checkbox('delivery','delivery',false,['class'=>'custom-control-input','ng-init'=>'item.delivery = false','ng-model'=>'item.delivery']) !!}
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description" value="delivery">Delivery</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="checkbox custom-checkbox-02">
                                <label class="custom-control custom-checkbox">
                                    {!! Form::checkbox('pickup','pickup',false,['class'=>'custom-control-input','ng-init'=>'item.pickup = false','ng-model'=>'item.pickup']) !!}
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description" value="pickup">Pick up</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-2em">
                <label class="form__label">Payment<span>*</span></label>
                <div class="widget__content" style="border: 1px solid #ededed; border-radius:5px; text-align:center">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="checkbox custom-checkbox-02">
                                <label class="custom-control custom-checkbox">
                                    {!! Form::checkbox('cod_payment','cod_payment',false,['class'=>'custom-control-input','ng-init'=>'item.cod = false','ng-model'=>'item.cod']) !!}
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description" value="cod">COD</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="checkbox custom-checkbox-02">
                                <label class="custom-control custom-checkbox">
                                    {!! Form::checkbox('online_payment','online_payment',false,['class'=>'custom-control-input','ng-init'=>'item.pay_online = false','ng-model'=>'item.pay_online']) !!}
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description" value="payonline">Pay Online</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 pb-2em">
                <label class="form__label">Delivery location<span>*</span></label>
                <div class="widget__content" style="border: 1px solid #ededed; border-radius:5px; text-align:center">
                    <div style="padding:1em 2em">
                        <table class="table" style="width:100%; word-break:break-word;">
                            <thead>
                                <tr style="border-bottom: 1px solid #ededed; text-align:left">
                                    <th scope="col" style="padding: 1em 1em 1em 0em; color:black;width:20%">District</th>
                                    <th scope="col" style="color:black;width:20%">Minium</th>
                                    <th scope="col" style="color:black;width:20%">From</th>
                                    <th scope="col" style="color:black;width:20%">To</th>
                                    <th scope="col" style="color:black;width:20%">Fee</th>
                                </tr>
                            </thead>
                            <tbody style=" text-align:left">
                                <tr style="border-bottom: 1px solid #ededed" ng-repeat="row in tableDeliveryLocation">
                                    <td style="padding: 1em 1em 1em 0em;">
                                        <% row.district %>
                                    </td>
                                    <td style="padding: 1em 1em 1em 0em;">
                                        <% row.minimum.formatCurrency() %>
                                    </td>
                                    <td style="padding: 1em 1em 1em 0em;">
                                        <% row.from.formatCurrency() %>
                                    </td>
                                    <td style="padding: 1em 1em 1em 0em;">
                                        <% row.to.formatCurrency() %>
                                    </td>
                                    <td style="padding: 1em 1em 1em 0em;">
                                        <% row.fee.formatCurrency() %>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="" style="padding:1em 1em 1em 0em">
                                            <select id="district" class="district-select2" ng-model='district'>
                                                    <option  value="" disabled selected >--Choose District--</option>
                                                    @foreach ($districts as $index =>$district)
                                                    <option value="{{$district->id}}" name="{{$district->id}}">{{$district->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <th style="padding: 1em 1em 1em 0em;">
                                        {!! Form::text(null, null, ['class' => ' form-control m-input','style' => 'font-weight: normal', 'ng-model' =>'minimum','onkeypress'
                                        => 'return isNumber(event)','id'=>'minimum']) !!}</th>
                                    <th style="padding: 1em 1em 1em 0em;">{!! Form::text(null, '', ['class' => ' form-control m-input','style' => 'font-weight:
                                        normal', 'ng-model' =>'from','onkeypress' => 'return isNumber(event)','id'=>'from'])
                                        !!}
                                    </th>
                                    <th style="padding: 1em 1em 1em 0em;">{!! Form::text(null, '', ['class' => ' form-control m-input','style' => 'font-weight:
                                        normal', 'ng-model' =>'to','onkeypress' => 'return isNumber(event)','id'=>'to'])
                                        !!}
                                    </th>
                                    <th style="padding: 1em 0em 1em 0em;">{!! Form::text(null, '', ['class' => ' form-control m-input','style' => 'font-weight:
                                        normal', 'ng-model' =>'fee','onkeypress' => 'return isNumber(event)','id'=>'fee'])
                                        !!}
                                    </th>
                                </tr>
                                <tr style="text-align:center">
                                    <th colspan="5"> <button type="button" class="btn btn-info md-btn--primary " ng-disabled="!validateDeliveryLocation()"
                                            ng-click="addDeliveryLocation()">Apply Now</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 pb-2em">
                <label class="form__label">Opening time<span>*</span></label>
                <div class="widget__content" style="border: 1px solid #ededed; border-radius:5px; text-align:center">
                    <div style="padding:1em 2em">
                        <table class="table" style="width:100%; word-break:break-word;">
                            <thead>
                                <tr style="border-bottom: 1px solid #ededed; text-align:left">
                                    <th scope="col" style="padding: 1em 1em 1em 0em; color:black;width:33.33%">Day</th>
                                    <th scope="col" style="color:black;width:33.33%">Start time</th>
                                    <th scope="col" style="color:black;width:33.33%">End time</th>
                                </tr>
                            </thead>
                            <tbody style=" text-align:left">
                                <tr style="border-bottom: 1px solid #ededed" ng-repeat="row in tableOpeningTime track by $index">
                                    <td style="padding: 1em 1em 1em 0em;">
                                        <% row.day %>
                                    </td>
                                    <td style="padding: 1em 1em 1em 0em;">
                                        <% row.start_time %>
                                            <% row.time_start %>
                                    </td>
                                    <td style="padding: 1em 1em 1em 0em;">
                                        <% row.end_time %>
                                            <% row.time_end %>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="" style="padding:1em 1em 1em 0em">
                                            <select name="day" id="day" class="district-select2" ng-model="day">
                                                <option value="" disabled selected  >--Choose Day In A Week--</option>
                                                <option value="1" >All day</option>
                                                <option value="0" >Specific day</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="specific_day">
                                    <td colspan="3">
                                        <div style="justify-content: space-between;display: flex;">
                                            <div class="checkbox custom-checkbox-02">
                                                <label class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('mon','mon',true,['class'=>'custom-control-input', 'id' => 'mon' ,'ng-init'=>'item.mon = true','ng-model'=>'item.mon']) !!}
                                                    <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description" value="all">Monday</span>
                                            </label>
                                            </div>
                                            <div class="checkbox custom-checkbox-02">
                                                <label class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('tue','tue',true,['class'=>'custom-control-input', 'id' => 'tue' ,'ng-init'=>'item.tue = true','ng-model'=>'item.tue']) !!}
                                                        <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description" value="all">Tuesday</span>
                                            </label>
                                            </div>
                                            <div class="checkbox custom-checkbox-02">
                                                <label class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('wed','wed',true,['class'=>'custom-control-input', 'id' => 'wed' ,'ng-init'=>'item.wed = true','ng-model'=>'item.wed']) !!}
                                                        <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description" value="all">Wednesday</span>
                                            </label>
                                            </div>
                                            <div class="checkbox custom-checkbox-02">
                                                <label class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('thu','thu',true,['class'=>'custom-control-input', 'id' => 'thu' ,'ng-init'=>'item.thu = true','ng-model'=>'item.thu']) !!}
                                                        <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description" value="all">Thursday</span>
                                            </label>
                                            </div>
                                            <div class="checkbox custom-checkbox-02">
                                                <label class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('fri','fri',true,['class'=>'custom-control-input', 'id' => 'fri' ,'ng-init'=>'item.fri = true','ng-model'=>'item.fri']) !!}
                                                        <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description" value="all">Friday</span>
                                            </label>
                                            </div>
                                            <div class="checkbox custom-checkbox-02">
                                                <label class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('sat','sat',true,['class'=>'custom-control-input', 'id' => 'sat' ,'ng-init'=>'item.sat = true','ng-model'=>'item.sat']) !!}
                                                        <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description" value="all">Saturday</span>
                                            </label>
                                            </div>
                                            <div class="checkbox custom-checkbox-02">
                                                <label class="custom-control custom-checkbox">
                                                    {!! Form::checkbox('sun','sun',true,['class'=>'custom-control-input', 'id' => 'sun' ,'ng-init'=>'item.sun = true','ng-model'=>'item.sun']) !!}
                                                    <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description" value="all">Sunday</span>
                                            </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:1em 1em 1em 0em">
                                        <select id="time" class="district-select2" ng-model="time">
                                                <option value="" disabled selected  >--Choose Work Time--</option>
                                                <option value="1" >All time</option>
                                                <option value="0" >Specific time</option>
                                            </select>
                                    </td>
                                    <td style="padding: 1em 1em 1em 0em;">
                                        <div class="row start-time">
                                            <div class="col-md-6" style="padding-right: 0px">
                                                {!! Form::number('null', null, ['class' => 'form-control m-input','id' => 'start_time', 'onkeypress' => 'return isNumber(event)',
                                                'min' => '1', 'ng-model' => 'start_time']) !!}
                                            </div>
                                            <div class="col-md-6" style="padding-left: 0px">
                                                <select id="time_start" class="district-select2" ng-model="time_start">
                                                    <option value="" disabled selected  >--AM OR PM--</option>
                                                    <option value="AM">AM</option>
                                                    <option value="PM">PM</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1em 0em 1em 0em;">
                                        <div class="row end-time">
                                            <div class="col-md-6" style="padding-right: 0px">
                                                {!! Form::number('null', null, ['class' => 'form-control m-input','id' => 'end_time', 'onkeypress' => 'return isNumber(event)',
                                                'min' => '1', 'ng-model' => 'end_time']) !!}
                                            </div>
                                            <div class="col-md-6" style="padding-left: 0px">
                                                <select id="time_end" class="district-select2" ng-model="time_end">
                                                    <option value="" disabled selected  >--AM OR PM--</option>
                                                    <option >AM</option>
                                                    <option>PM</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr ng-if="start_time > 12">
                                    <td style="color:red">
                                        Start Time must be less than 12 or equal to 12
                                    </td>
                                </tr>
                                <tr ng-if="end_time > 12">
                                    <td style="color:red">
                                        End Time must be less than 12 or equal to 12
                                    </td>
                                </tr>
                                <tr style="text-align:center">
                                    <th colspan="5"> <button type="button" class="btn btn-info md-btn--primary" ng-disabled="!validateOpeningTime()"
                                            ng-click="addOpeningTime()">Apply Now</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size:2em;font-weight: bold;color:black; text-align:center; margin-top:20px">Owner's Information</div>
        <hr>
        <div class="row">
            <div class="col-md-4 pb-2em">
                <label class="form__label">Full name<span>*</span></label> {!! Form::text('oi_fullname', null, ['class' =>
                'form-control m-input','ng-model'=>'oi_fullname']) !!}
                <div ng-show="error['oi_fullname']" style="color:red; margin-top: 1em">
                    You must be input this field
                </div>

            </div>
            <div class="col-md-4 pb-2em">
                <label class="form__label">Phone<span>*</span></label> {!! Form::text('owner_phone', null, ['class' => '
                form-control m-input','onkeypress' => 'return isNumber(event)', 'maxlength' =>'8','ng-model'=>'owner_phone'])
                !!}
                <div ng-show="error['owner_phone']" style="color:red; margin-top: 1em">
                    You must be input this field, Phone number must be 8 digits and Phone numbers must be unique
                </div>

            </div>
            <div class="col-md-4 pb-2em">
                <label class="form__label">Email<span>*</span></label> {!! Form::text('owner_email', null, ['class' => '
                form-control m-input','ng-model'=>'owner_email']) !!}
                <div ng-show="error['owner_email']" style="color:red; margin-top: 1em">
                    You must be input this field, The Email must be a valid email address and Email address must be unique
                </div>

            </div>


        </div>
        <div class="row">
            <div class="col-md-12 pb-2em" style="text-align:center">
                <div class="col-md-4 ">
                    <input type="file" name="imgContract" ng-model="imgContract" onchange="angular.element(this).scope().imageUploadContract(event)"
                        id="inputUploadContract" class="real-file" hidden>
                    <button type="button" id="btnUploadContract" class="upload-button">Upload Contract</button>
                    <div id="textUploadContract" class="custom-text">No file chosen</div>
                    <div ng-show="error['imgContract']" style="color:red; margin-top: 1em">Please choose File image or File fdf</div>
                </div>
                <div class="col-md-4">
                    <input type="file" name="imgCV" id="inputUploadCV" ng-model="imgCV" onchange="angular.element(this).scope().imageUploadCV(event)"
                        class="real-file" hidden>
                    <button type="button" id="btnUploadCV" class="upload-button">Upload CV</button>
                    <div id="textUploadCV" class="custom-text">No file chosen</div>
                    <div ng-show="error['imgCV']" style="color:red; margin-top: 1em">Please choose File image or File fdf</div>
                </div>
                <div class="col-md-4">
                    <input type="file" name="imgBusinessLicense" id="inputUploadBL" ng-model="imgBusinessLicense" onchange="angular.element(this).scope().imageUploadBusinessLicense(event)"
                        class="real-file" hidden>
                    <button type="button" id="btnUploadBL" class="upload-button">Upload Business License</button>
                    <div id="textUploadBL" class="custom-text">No file chosen</div>
                    <div ng-show="error['imgBusinessLicense']" style="color:red; margin-top: 1em">Please choose File image or File fdf</div>
                </div>
            </div>
        </div>

        <div class="row" style="text-align:center">
            <button type="submit" class="btn btn-info md-btn--primary">Submit Restaurant</button>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection

@section('extra_scripts')
    @include('user.contact.script')
@endsection
