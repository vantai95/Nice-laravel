@php
    $image = isset($variable)  && $variable != '' && $variable->image != '' ? $variable->image : '';
@endphp
<div class="col-lg-{{ $width }}">
    <label class="col-form-label col-lg-3 col-sm-12">
        @lang('admin.restaurants.columns.image')
    </label>
    <div class="col-sm-12">
        <div class="pt-3">
            @include('admin.components.media.popup')
        </div>
        <div class="pt-3 save-message alert alert-success alert-dismissible fade">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span class="save-message-detail"></span>
        </div>
    </div>
    {!! $errors->first('image', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
    <input type="hidden" value="{{$image}}" name="{{ $img_name_attr }}"
           id="{{$name}}-image_upload">
</div>