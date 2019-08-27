<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    {{-- <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('tags') ? 'has-error' : ''}}">
            <label for="tags"
                   class="col-form-label col-sm-12">@lang('admin.restaurants.forms.tags')</label>
            <div class="col-sm-12">
                {!! Form::select('tags',\App\Models\Tag::pluck("name_$lang",'id') ,isset($tagInfo) ? $tagInfo->tags : null,['class' => 'form-control select2 tags-select2','id' => 'tags','multiple' => 'multiple','name' => 'tags[]']) !!}
                {!! $errors->first('tags', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div> --}}
    <div class="m-form__group form-group">
        @if(count($errors)>0)
        <div class="alert alert-danger" role="alert">  @foreach ($errors -> all() as $err) {{$err}} <br> @endforeach</div>
        @endif
        <label for="tags">@lang('admin.restaurants.forms.tags')</label>
        <div class="m-checkbox-list row" style="margin: 0px" id="tag_section">
            @foreach ($allTags as $item)
            <label class="col-xl-3 col-md-4 col-sm-6 m-checkbox">
            <input type="checkbox" name= "tags[]" value="{{$item->id}}" id="tag_{{$item->id}}" {{in_array($item-> name_en,$title_brief) ? 'checked' : ''}} > {{ $item-> name_en }}
            <span></span>
            </label>
            @endforeach
        </div>
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
        //focus when select2 option is selected
        // $(".tags-select2").on('select2:close', function(e) {
        //     var select2SearchField = $(this).parent().find('.select2-search__field'),
        //         setfocus = setTimeout(function() {
        //             select2SearchField.focus();
        //         }, 100);
        // });

        // jQuery(document).ready(function(){
        //     $(".select2.tags-select2").select2({
        //         maximumSelectionLength: 3,
        //         language: {
        //             maximumSelected: function (e) {
        //                 return "{{trans('admin.restaurants.maximum_selection')}}";
        //             }
        //         }
        //     });
        //     // IONRangeSlider.init();
        //     var $tag = '{{$tags}}';
        //     $tag = JSON.parse($tag);
        //     jQuery(".select2").val($tag).trigger('change');
        // });
    </script>
@endsection
