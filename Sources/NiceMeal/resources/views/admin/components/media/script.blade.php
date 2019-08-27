<script type="text/javascript">
    var dropzoneFile = [];
    @if(empty($variable))
        if ('{{$maxFiles}}' == 1) {
            var img_list = '';
        } else {
            img_list = [];
        }
    @else
        img_list = $('#{{$name}}-image_upload').val();
    @endif

    // return;
    Dropzone.autoDiscover = false;
    $('#{{$name}}-dropzone').dropzone({
        paramName: "file",
        maxFiles: '{{$maxFiles}}',
        maxFilesize: 10,
        addRemoveLinks: !0,
        thumbnailWidth: null,
        thumbnailHeight: null,
        'url': "{{ url('/admin/image-list/upload') }}",
        "headers":
            {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
        init: function () {
            var dz_element = this;
            this.on('addedfile', function (files) {
                dropzoneFile['{{$name}}-dropzone'] = this.files;
                if ('{{$maxFiles}}' == 1) {
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                    }
                } else {
                    var files_length = this.files.length;
                    if (files_length > parseInt("{{$maxFiles}}")) {
                        for (i = 0; i < files_length - parseInt("{{$maxFiles}}"); i++) {
                            this.removeFile(this.files[files_length - 1]);
                        }
                        alert('You can upload {{$maxFiles}} file only!');
                    }
                }

            });
        }
    })

    //button upload image
    $('#{{$name}}_upload_image').click(function () {
        var fd = new FormData();
        var img_length = dropzoneFile['{{$name}}-dropzone'].length;
        fd.append('_token', "{{ csrf_token() }}");
        // remove redundant file when has reach max file allow
        if (img_length > parseInt('{{$maxFiles}}')) {
            dropzoneFile['{{$name}}-dropzone'].splice(-1, 1);
        }
        $.each(dropzoneFile['{{$name}}-dropzone'], function (key, file) {
            fd.append('files[]', file);
        });

        if (dropzoneFile['{{$name}}-dropzone'].length > 0) {
            $.ajax({
                url: "{{url('admin/upload-image')}}",
                type: "post",
                dataType: 'json',
                contentType: false,
                processData: false,
                data: fd,
                success: function (response) {
                    $(".save-message-detail").html('');
                    $(".save-message").removeClass('alert-success').addClass('fade').removeAttr('style');
                    $(".save-message-detail").html(response.message);
                    $(".save-message").removeClass('alert-warning').addClass('alert-success').removeClass('fade').fadeOut(2000);
                    if ('{{$maxFiles}}' > 1) {
                        for (let i = 0; i < response.data.length; i++) {
                            img_list.push(response.data[i].imageURL);
                        }
                    } else {
                        img_list = response.data[0].imageURL;
                    }
                    Dropzone.forElement("#{{$name}}-dropzone").removeAllFiles(true);
                    imageConvert("{{$maxFiles}}", img_list);
                    getImagesThumb();
                }
            });
        }
        $('#{{$name}}mediaModal').modal('toggle');
    });

    //button library
    $('#{{$name}}-library-tab').click(function () {
        $('#{{$name}}-library.library-sub').remove();
        $.ajax({
            url: "{{url('admin/image-list/get')}}",
            beforeSend: function () {
                $("#image-wait").show();
            },
            success: function (respone) {
                var data = respone.data;
                var eleImage = '';
                $.each(data, function (key, data) {
                    eleImage += '<div id="{{$name}}-library" class="col-3 mt-4 library-sub"><img class="library-img img-thumbnail" style="width:130px; height:130px" src="' + "{{config('filesystems.disks.azure.url')}}" + "/" + data.image + '" alt="" onclick="librarySelect(this)"></div>';
                })
                $('.{{$name}}-library-section').append(eleImage);
                $("#image-wait").hide();
                if(img_list != '' || img_list.length > 0){
                    getSelectedImage();
                }
            }
        });
    });

    //load image preview
    function getImagesThumb() {
        $('#{{$name}}-dz.row.image-list').html('');
        var value = $('input#{{$name}}-image_upload').val();
        if (value != '') {
            if (!value.includes('[')) {
                $('#{{$name}}-dz.row.image-list').append("<div class='col-4 image-col img-list'>"
                    + "<img src=" + "{{config('filesystems.disks.azure.url')}}" + "/" + value + '>'
                    + " <button type='button' id='{{$name}}-remove' style='margin-top:20px;' aria-label='Close' class='close remove-btn position-absolute'><span aria-hidden='true'>×</span></button>"
                    + "</div>");
            } else {
                $.each(eval(value), function () {
                    $('#{{$name}}-dz.row.image-list').append("<div class='col-4 image-col img-list'>"
                        + "<img src=" + "{{config('filesystems.disks.azure.url')}}" + "/" + this + '>'
                        + " <button type='button' id='{{$name}}-remove' style='margin:20px 0;' aria-label='Close' class='close remove-btn position-absolute'><span aria-hidden='true'>×</span></button>"
                        + "</div>");
                });
            }
        } else {
            $('#{{$name}}-dz.row.image-list').html('');
        }

        // handle event elements
        $("#{{$name}}-remove.close.remove-btn").each(function () {
            $(this).on("click", function () {
                let src = $(this).siblings("img").attr('src');
                let img_name = src.split("/").slice(-1)[0];
                if ('{{$maxFiles}}' > 1) {
                    // console.log(img_list);
                    var array_img = eval(img_list);
                    array_img.splice(array_img.indexOf(img_name), 1);
                    img_list = array_img;
                } else {
                    img_list = '';
                }
                $(this).closest("div").remove();
                imageConvert("{{$maxFiles}}", img_list);

                if (img_list.length == 0 || img_list == '') {
                    $("#{{$name}}-library.library-sub .library-img[class*='selected']").removeClass('selected');
                }
                $("#{{$name}}-library.library-sub .library-img").not('.selected').removeClass('not-allowed');
                $('#{{$name}}mediaModal div#{{$name}}-library p').hide();
                $("#{{$name}}-library.library-sub .library-img[src='" + src + "'][class*='selected']").removeClass('selected');
            });
        });
    }

    function librarySelect(elem) {
        $(elem).toggleClass('selected');
        var imageListSelected = $("#{{$name}}-library.library-sub .library-img[class*='selected']").length;
        validateImageSelection(imageListSelected);
    }

    //button save image
    $('#{{$name}}_save_image').click(function () {
        var imageListSelected = $("#{{$name}}-library.library-sub .library-img[class*='selected']").length;
        if (imageListSelected > 0) {
            if ($('#{{$name}}-library.library-sub .library-img').hasClass('selected')) {
                if ('{{$maxFiles}}' == 1) {
                    img_list = '';
                    img_list = $("#{{$name}}-library.library-sub .library-img[class*='selected']").attr('src').split('/')[4];
                    $('#{{$name}}-image_upload').val(img_list);
                } else {
                    img_list = [];
                    var element = $("#{{$name}}-library.library-sub .library-img[class*='selected']");
                    $(element).each(function () {
                        var src = $(this).attr('src').split('/')[4];
                        img_list.push(src);
                    });
                }
                imageConvert("{{$maxFiles}}", img_list)
            }
        } else {
            if ('{{$maxFiles}}' == 1) {
                img_list = '';
            } else {
                img_list = [];
            }
            imageConvert("{{$maxFiles}}", img_list)
        }

        getImagesThumb();
        $('#{{$name}}mediaModal').modal('toggle');
    });

    function imageConvert(max_file, image) {
        if (max_file == 1) {
            $('#{{$name}}-image_upload').val(image);
        } else {
            $('#{{$name}}-image_upload').val(JSON.stringify(image));
        }
    }

    function getSelectedImage() {
        console.log(eval(img_list));
        if (img_list.includes('[')) {
            $.each(eval(img_list), function (key, value) {
                var image_src = "{{config('filesystems.disks.azure.url')}}" + "/" + value;
                $("#{{$name}}-library.library-sub .library-img[src='" + image_src + "']").addClass('selected');
            });
        } else {
            var image_src = "{{config('filesystems.disks.azure.url')}}" + "/" + img_list;
            $("#{{$name}}-library.library-sub .library-img[src='" + image_src + "']").addClass('selected');
        }
        var imageListSelected = $("#{{$name}}-library.library-sub .library-img[class*='selected']").length;
        validateImageSelection(imageListSelected);
    }

    function validateImageSelection(image_select) {
        if (image_select == parseInt('{{$maxFiles}}')) {
            $('#{{$name}}mediaModal div#{{$name}}-library p').show();
            $("#{{$name}}-library.library-sub .library-img").not('.selected').addClass('not-allowed');
        } else {
            $('#{{$name}}mediaModal div#{{$name}}-library p').hide();
            $("#{{$name}}-library.library-sub .library-img").not('.selected').removeClass('not-allowed');
        }
    }

    $(document).ready(function () {
        getImagesThumb();
    });
</script>