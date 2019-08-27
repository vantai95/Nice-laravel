@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::open(['url' => '/admin/restaurants-categories', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'novalidate'=>'novalidate','class' => 'category-form m-form m-form--fit m-form--label-align-right', 'id' => 'submitForm', 'files' => true]) !!}
        @include ('admin.restaurants_categories.form')
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        var FormControls = {
            init: function () {
                $(".category-form").validate(
                    {
                        invalidHandler: function (e, r) {
                            var i = $("#m_form_1_msg");
                            i.removeClass("m--hide").show(), mApp.scrollTo(i, -200)
                        }
                    })
            }
        };
        jQuery(document).ready(function () {
            FormControls.init()
        });

        // dropzone
        var token = $('input[name="_token"]').val();
        var DropzoneDemo = {
            init: function () {
                Dropzone.options.mDropzoneTwo = {
                    paramName: "file",
                    maxFiles: 10,
                    init: function () {
                        this.on("maxfilesexceeded", function (file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        });
                    },
                    maxFilesize: 10,
                    addRemoveLinks: !0,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    accept: function (e, o) {
                        "fishSauce.jpg" == e.name ? o("No, you don't.") : o()
                    },
                    'url': "{{ url('/admin/uploads/upload') }}",

                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                }
            }
        };
        DropzoneDemo.init();
        $(document).ready(function () {
            $("#submitButton").click(function () {
                $('.items').remove();
                $('#m-dropzone-two').find('img').each(function (index) {
                    $('#submitForm').append('<input type="hidden" class="items" id="image_' + index + '" name="image_' + index + '" value="' + $(this).attr('src') + '" /> ');
                });
                $('#m-dropzone-two').find('.dz-filename').each(function (index) {
                    var html = $(this).find('span').html();
                    let img_ext = html.split(".").slice(-1)[0];
                    $('#submitForm').append('<input type="hidden" class="items" name="img_ext_' + index + '" value="' + img_ext + '" /> ');
                });

                if ($("#image_0").val() == undefined) {
                    return false;
                }
            });
        });

    </script>
@endsection
