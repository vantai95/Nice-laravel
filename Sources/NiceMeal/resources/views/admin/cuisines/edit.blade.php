@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($cuisine, ['method' => 'PATCH',
                    'url' => ['/admin/cuisines', $cuisine->id],
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.cuisines.form', ['submitButtonText' => @trans('admin.cuisines.buttons.update')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

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
                    'url': "{{ url('/admin/cuisines/upload') }}",
                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                    init: function () {
                        @if(!empty($restaurant->image))
                            this.addCustomFile = function (file, thumbnail_url, responce) {
                            // Push file to collection

                            file.name = "{{$cuisine->image}}";
                            this.files.push(file);
                            // Emulate event to create interface
                            this.emit("addedfile", file);
                            // Add thumbnail url
                            this.emit("thumbnail", file, '{{url('images/uploads/'.$cuisine->image)}}');
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

        $(document).ready(function () {
            $("#submitButton").click(function () {
                    $('.news').remove();
                    $('#m-dropzone-two').find('img').each(function (index) {
                        $('#submitForm').append('<input type="hidden" class="news" name="image_' + $(this).attr('alt') + '" value="' + $(this).attr('src') + '" /> ');
                    });
                }
            )
        });
    </script>
@endsection