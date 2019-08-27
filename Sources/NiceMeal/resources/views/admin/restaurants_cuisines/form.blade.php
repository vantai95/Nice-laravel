<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        {{--@if(Auth::user()->isAdmin())--}}
        {{--<div class="col-lg-6 {{ $errors->has('restaurant_id') ? 'has-error' : ''}}">--}}
            {{--{!! Form::label('restaurant_id', trans('admin.restaurants_cuisines.forms.restaurant').' *', ['class' => 'col-form-label col-sm-12']) !!}--}}
            {{--<div class="col-sm-12">--}}
                {{--<select required name="restaurant_id" class="form-control select2" id="restaurant_id">               --}}
                    {{--<option readonly selected value="{{$res->id}}">{{ $res->name_en }}</option>--}}
                {{--</select>--}}
                {{--{!! $errors->first('restaurant_id', '<p class="help-block">:message</p>') !!}--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--@endif--}}
         <div class="col-lg-12 {{ $errors->has('cuisine_id') ? 'has-error' : ''}}">
            {!! Form::label('cuisine_id', trans('admin.restaurants_cuisines.forms.cuisines').' *', ['class' => 'col-form-label col-sm-12']) !!}
            <div class="col-sm-12">
                <select required name="cuisine_id" class="form-control select2" id="cuisines_id">
                    <option disabled selected>--Chọn cuisines--</option>

                    @foreach($cuisines as $key => $cuisine)
                        @if(isset($restaurant_cuisines))
                            @if($restaurant_cuisines->cuisine_id == $cuisine->id)
                                <option selected value="{{$cuisine->id}}">{{$cuisine->name_en}}</option>
                            @else
                                <option value="{{$cuisine->id}}">{{$cuisine->name_en}}</option>
                            @endif
                        @else
                            <option value="{{$cuisine->id}}">{{$cuisine->name_en}}</option>
                        @endif
                    @endforeach
                </select>
                {!! $errors->first('cuisine_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.restaurants_cuisines.buttons.assign'), ['class' => 'btn btn-accent m-btn m-btn--air m-btn--custom', 'id' => 'submitButton']) !!}
                {{--<a href="{{url('admin/'. $res->res_Slug .'/restaurants-cuisines')}}" type="reset"--}}
                   {{--class="btn btn-secondary m-btn m-btn--air m-btn--custom btn-cancel">--}}
                    {{--@lang('admin.restaurants_cuisines.buttons.cancel')--}}
                {{--</a>--}}
            </div>
        </div>
    </div>
</div>