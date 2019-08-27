<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        @if(Auth::user()->isAdmin())
        <div class="col-lg-6 {{ $errors->has('restaurant_id') ? 'has-error' : ''}}">
        
            {!! Form::label('restaurant_id', trans('admin.dishes.forms.restaurant').' *', ['class' => 'col-form-label col-sm-12']) !!}
            <div class="col-sm-12">
                <select required name="restaurant_id" class="form-control select2" id="restaurant_id">               
                    <option disabled selected>--Chọn restaurants--</option>
                    
                    @foreach($restaurants as $item)    
                        @if(isset($category))                   
                            <option @if($category->restaurant_id == $item->id) selected @endif value="{{$item->id}}">{{$item->name_en}}</option>                       
                        @else
                        <option value="{{$item->id}}">{{$item->name_en}}</option> 
                        @endif
                    @endforeach               
                </select>
                
                {!! $errors->first('restaurant_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        @endif
         <div class="col-lg-6 {{ $errors->has('category_id') ? 'has-error' : ''}}">
            {!! Form::label('category_id', trans('admin.dishes.forms.category').' *', ['class' => 'col-form-label col-sm-12']) !!}
            <div class="col-sm-12">
                <select required name="category_id" class="form-control select2" id="category_id">
               
                    <option disabled selected>--Chọn category--</option>
                    @foreach($categories as $item)                       
                        @if(isset($category))                   
                            <option @if($category->id == $item->id) selected @endif value="{{$item->id}}">{{$item->title_en}}</option>                       
                        @else
                        <option value="{{$item->id}}">{{$item->title_en}}</option> 
                        @endif                      
                    @endforeach               
                </select>
                
                {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>



    

    <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-12 col-sm-12 text-left">
            @lang('admin.categories.forms.image') {{ csrf_field() }}
        </label>
        <div class="col-lg-12 col-md-9 col-sm-12">
            {{--id="{{ $configuration->config_value['image'] }}"--}}
            <div class="m-dropzone  dropzone m-dropzone--primary" id="m-dropzone-two">
                {{--id="{{$configuration->id}}"  {{'m-dropzone_'}}--}}
                <div class="m-dropzone__msg dz-message needsclick">
                    <h3 class="m-dropzone__msg-title">
                        @lang('admin.categories.text.upload_text')
                    </h3>
                </div>
            </div>
        </div>
        {!! $errors->first('image', '<div id="email-error" class="form-control-feedback">:message</div>') !!}
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.categories.buttons.create'), ['class' => 'btn btn-accent m-btn m-btn--air m-btn--custom', 'id' => 'submitButton']) !!}
                <a href="{{url('admin/restaurants-categories')}}" type="reset"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom btn-cancel">
                    @lang('admin.categories.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>

{{--@section('extra_scripts')--}}
{{--<script type="text/javascript">--}}
{{--var FormControls = {--}}
{{--init: function () {--}}
{{--$(".category-form").validate(--}}
{{--{--}}
{{--invalidHandler: function (e, r) {--}}
{{--var i = $("#m_form_1_msg");--}}
{{--i.removeClass("m--hide").show(), mApp.scrollTo(i, -200)--}}
{{--}--}}
{{--})--}}
{{--}--}}
{{--};--}}
{{--jQuery(document).ready(function () {--}}
{{--FormControls.init()--}}
{{--});--}}

{{--</script>--}}
{{--@endsection--}}