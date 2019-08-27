@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="upload">
        <div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
            <div class="form-group m-form__group row">
                <div class="col-lg-9 ml-lg-auto">
                    <button class="btn btn-success float-right btn-add-new">@lang('admin.uploads.buttons.add_new')</button>
                </div>
            </div>
        </div>
       
        <div class="form-upload">
            {!! Form::open(['url' => '/admin/'.$res->res_Slug.'/uploads', 'class' => 'm-form m-form--fit m-form--label-align-right', 'files' => true,'id' => 'submitForm']) !!}
            
                <div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                    <div class="form-group m-form__group row">
                                        
                            <div class="col-sm-12">
                                <div class="m-dropzone dropzone m-dropzone--primary" id="m-dropzone-two">
                                    <div class="m-dropzone__msg dz-message needsclick">
                                        <h3 class="m-dropzone__msg-title">
                                            @lang('admin.uploads.text.upload_text')
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        @if ($errors->any())
                            {!! implode('', $errors->all('<div class="form-control-feedback field-error">:message</div>')) !!}
                        @endif
                    </div>
                    
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-9 ml-lg-auto">
                                    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success','id' => 'submitButton']) !!}
                                    <a href="{{url('admin/'.$res->res_Slug.'/uploads')}}" class="btn btn-secondary">
                                        @lang('admin.buttons.cancel')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}   
            </div>
            <div class="result-upload">
                <div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                    <div class="form-group m-form__group row">
                        @foreach( $imageLists as $img)           
                            <img src="{{ $img->imageUrl() }}" title="{{ $img->file_name }}" img-id="{{ $img->id }}" class="thum-image" width="80px" height="60px" />
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="modal fade" id="imageDetail" tabindex="-1" role="dialog" aria-labelledby="imageDetail">
                <div class="modal-dialog modal-upload" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        
                    </div>
                    
                    <div class="modal-body">
                        <div class="form-group m-form__group row ">         
                            <div class="col-7">
                                <img src="" width="100%" id="myModalImage"/>
                                <input type="hidden" value="" id="myModalId">
                                {{csrf_field()}}
                            </div>
                            <div class="col-5">
                                <div class="form-group m-form__group row">         
                                    <label for="" class="col-12 col-form-label">@lang('admin.uploads.text.file_name')</label>
                                    <div class="col-12">
                                    <input disabled class="form-control" placeholder="File Name" name="filename" id="myModalFileName" type="text" value="">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">         
                                    <label for="" class="col-12 col-form-label">@lang('admin.uploads.text.url')</label>
                                    <div class="col-12">
                                    <input disabled class="form-control" placeholder="URL" name="url" id="myModalURl" type="text" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btn-delete">@lang('admin.uploads.buttons.delete')</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.uploads.buttons.close')</button>
                        
                    </div>
                   
                    </div>
                </div>
        </div>

        
    </div>


    
@endsection

@section('extra_scripts')
    <script>
        var token = $('input[name="_token"]').val();
        var DropzoneDemo = {
            init: function(){
                Dropzone.options.mDropzoneTwo = {
                    paramName: "file",
                    acceptedFiles: 'image/*',
                    maxFiles: 10,
                    init: function() {
                        this.on("maxfilesexceeded", function(file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        });
                    },
                    maxFilesize: 10,
                    addRemoveLinks: !0,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    accept: function(e, o){
                        "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                    },
                    'url': "{{ url('/admin/'.$res->res_Slug.'/uploads/upload') }}",

                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                }
            }
        };
        DropzoneDemo.init();
        $(document).ready(function(){
            $("#submitButton").click(function(){
                $('.items').remove();
                $('#m-dropzone-two').find('img').each(function(index){
                    $('#submitForm').append('<input type="hidden" class="items" id="image_'+ index +'" name="image_'+ index +'" value="'+ $(this).attr('src') +'" /> ');
                });
                $('#m-dropzone-two').find('.dz-filename').each(function(index){
                    var html = $(this).find('span').html();                    
                    let img_ext =  html.split(".").slice(-1)[0];
                    $('#submitForm').append('<input type="hidden" class="items" name="img_ext_'+ index +'" value="'+ img_ext +'" /> ');
                });
              
                if($("#image_0").val()==undefined){
                    return false;
                }
            });

            $(".form-upload").fadeOut(1000);
            $(".btn-add-new").click(function(){
                $(".form-upload").fadeIn(1000);
            });
            $(".thum-image").click(function(e){
                var src = $( this ).attr('src');
                $("#myModalImage").attr('src',src);
                $("#myModalURl").val(src);
                $("#myModalFileName").val($( this ).attr('title'));
                $("#myModalLabel").html("File : "+$( this ).attr('title'));
                $("#myModalId").val($( this ).attr('img-id'));
                $("#imageDetail").modal();
            });
            $(".btn-delete").click(function(e){
                $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/admin/{{ $res->res_Slug }}/uploads/' + $("#myModalId").val(),
                    type: 'DELETE'
                }).done(function( data ) {
                    toastr.success("{{ session('flash_message') }}")
                    location.reload();
                    
                });
          
            });
        });

    </script>
@endsection
