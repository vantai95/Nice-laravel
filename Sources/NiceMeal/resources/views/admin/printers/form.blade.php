@php
    $restaurants = \App\Models\Restaurant::where('active', 1)->get();
@endphp

<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    @if(Auth::user()->isAdmin() && !isset($slug))
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('restaurant_id') ? 'has-error' : ''}}">
            <label for="name" class="col-form-label col-sm-12">@lang('admin.dishes.forms.restaurant')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                <select required name="restaurant_id" class="form-control select2" id="restaurant_id">
                    <option disabled selected>--Chọn restaurants--</option>

                    @foreach($restaurants as $item)
                        @if(isset($printer))
                            <option @if($printer->restaurant_id == $item->id) selected @endif value="{{$item->id}}">{{$item->name_en}}</option>
                        @else
                            <option value="{{$item->id}}">{{$item->name_en}}</option>
                        @endif
                    @endforeach
                </select>

                {!! $errors->first('restaurant_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    @endif

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name') ? 'has-error' : ''}}">
            <label for="name" class="col-form-label col-sm-12">@lang('admin.printers.forms.name')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name', isset($printer) ? $printer->name : '', ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('ip') ? 'has-error' : ''}}">
            <label for="ip" class="col-form-label col-sm-12">@lang('admin.printers.forms.ip')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('ip', isset($printer) ? $printer->ip : '', ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('ip', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('port') ? 'has-error' : ''}}">
            <label for="port" class="col-form-label col-sm-12">@lang('admin.printers.forms.port')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('port', isset($printer) ? $printer->port : '', ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('port', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('polling_url') ? 'has-error' : ''}}">
            <label for="polling_url" class="col-form-label col-sm-12">@lang('admin.printers.forms.polling_url')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('polling_url', isset($printer) ? $printer->polling_url : '', ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('polling_url', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('callback_url') ? 'has-error' : ''}}">
            <label for="callback_url" class="col-form-label col-sm-12">@lang('admin.printers.forms.callback_url')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('callback_url', isset($printer) ? $printer->callback_url : '', ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('callback_url', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('check_interval') ? 'has-error' : ''}}">
            <label for="check_interval" class="col-form-label col-sm-12">@lang('admin.printers.forms.check_interval')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('check_interval', isset($printer) ? $printer->check_interval : 30, ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('check_interval', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('token') ? 'has-error' : ''}}">
            <label for="token" class="col-form-label col-sm-12">@lang('admin.printers.forms.token')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('token', isset($printer) ? $printer->token : '', ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('token', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('page_header') ? 'has-error' : ''}}">
            <label for="page_header" class="col-form-label col-sm-12">@lang('admin.printers.forms.page_header')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('page_header', isset($printer) ? $printer->page_header : 'Welcome/r-------------------------', ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('page_header', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('page_footer') ? 'has-error' : ''}}">
            <label for="page_footer" class="col-form-label col-sm-12">@lang('admin.printers.forms.page_footer')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('page_footer', isset($printer) ? $printer->page_footer : '--------------------------\rThanks!' , ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('page_footer', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('reject_reason') ? 'has-error' : ''}}">
            <label for="reject_reason" class="col-form-label col-sm-12">@lang('admin.printers.forms.reject_reason')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('reject_reason', isset($printer) ? $printer->reject_reason : 'TOO BUSY;FOOD UNAVAILABLE;UNABLE TO DELIVER;DONT DELIVER TO AREA;UNKNOWN ADDRESS;TIME UNAVAILABLE;JAM - PLEASE REORDER;' , ['class' => 'form-control m-input','required'=>'required']) !!}
                {!! $errors->first('reject_reason', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                @if(isset($printer))
                    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.printers.buttons.upgrate'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                @else
                    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.printers.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                @endif
                <a href="{{url('admin/'.$res->res_Slug.'/printers')}}" class="btn btn-secondary">
                    @lang('admin.printers.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>

