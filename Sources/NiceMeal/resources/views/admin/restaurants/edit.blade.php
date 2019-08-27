@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($restaurant, ['method' => 'PATCH',
                    'url' => ['/admin/restaurants', $restaurant->id],
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.restaurants.form', ['submitButtonText' => @trans('admin.restaurants.buttons.update')])
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
                    'url': "{{ url('/admin/restaurants/upload') }}",
                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
                    init: function () {
                        @if(!empty($restaurant->image))
                            this.addCustomFile = function (file, thumbnail_url, responce) {
                            // Push file to collection

                            file.name = "{{$restaurant->image}}";
                            this.files.push(file);
                            // Emulate event to create interface
                            this.emit("addedfile", file);
                            // Add thumbnail url
                            this.emit("thumbnail", file, '{{url('images/uploads/'.$restaurant->image)}}');
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

        //focus when select2 option is selected
        $(".tags-select2").on('select2:close', function(e) {
            var select2SearchField = $(this).parent().find('.select2-search__field'),
                setfocus = setTimeout(function() {
                    select2SearchField.focus();
                }, 100);
        });
        $(document).ready(function () {
            $("#submitButton").click(function () {
                    $('.news').remove();
                    $('#m-dropzone-two').find('img').each(function (index) {
                        $('#submitForm').append('<input type="hidden" class="news" name="image_' + $(this).attr('alt') + '" value="' + $(this).attr('src') + '" /> ');
                    });
                }
            )
            $('.province-select2').select2();
            $('.district-select2').select2();
            $('.ward-select2').select2();
            $('.status-select2').select2();
            $('.vip-select2').select2();
            $(".select2.tags-select2").select2({
                maximumSelectionLength: 3,
                language: {
                    maximumSelected: function (e) {
                        return "{{trans('admin.restaurants.maximum_selection')}}";
                    }
                }
            });

            var slug = $("input[name='slug']").value;
            var regex = /^([A-Za-z0-9-]+)$/;
            if (regex.test(slug)) {
                $('.slug .regex').hide();
            }
            else {
                $('.slug .regex').show();
            }
        });

        $("select[name='district_id']").on('change', function() {
            var district_id = $("select[name='district_id']").val();
            var url = "/locations/" + district_id + "/wards";
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                success:function(res){
                    console.log(res);
                }

            });
        })

        $("input[name='slug']").bind('keyup', function () {
            var slug = this.value;
            var regex = /^([A-Za-z0-9-]+)$/;

            if (regex.test(slug)) {
                $('.slug .regex').hide();
            }
            else {
                $('.slug .regex').show();
            }
        });

        function getWards(district_id) {
            var url = "/locations/" + district_id + "/wards";
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                success:function(res){
                    $("select[name='ward_id']").html('');
                    $("select[name='ward_id']").append("<option disabled >--@lang('admin.restaurants.forms.choose_district')--</option>");
                    $.each(res.wards, function(key, ward) {
                        $("select[name='ward_id']").append("<option value=" + ward.id + ">" + ward.name + "</option>");
                    })
                }
            });
        }

        $("select[name='district_id']").on('change', function() {
            getWards($(this).val());
        })
        

        // var IONRangeSlider={
        //     init: function() {
        //         $("#vip_restaurant").ionRangeSlider({
        //             skin: 'big',
        //             min: 0,
        //             max: 10,
        //             step: 1,
        //            disable: "false" !== "{{ Auth::user()->isAdmin() ? 'false' : 'true' }}",
        //            from: '{{ isset($restaurant) ? $restaurant->vip_restaurant : 0 }}',
        //             prefix: 'VIP '
        //           })
        //     }
        //  };
        jQuery(document).ready(function(){
            // IONRangeSlider.init();
            var $tag = '{{$tag}}';
            $tag = JSON.parse($tag);
            jQuery(".select2").val($tag).trigger('change');  ;
        });

        // Increase Decrease OPT
        $('#otp').mask("#.##0",{reverse:true});
        $('#otp_value').mask("#.##0",{reverse:true});

        $('#submitForm').submit(function(){
            $('#otp').unmask();
            $('#otp_value').unmask();
        });

        function increaseOtp() {
            var value = parseInt(document.getElementById('otp').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('otp').value = value;
        }

        function decreaseOtp() {
            var value = parseInt(document.getElementById('otp').value, 10);
            value = isNaN(value) ? 1 : value;
            value < 1 ? value = 1 : '';
            value--;
            if(value<1)
                value =1
            document.getElementById('otp').value = value;
        }

        function increaseOtpValue() {
            $('#otp_value').unmask();
            var value = parseInt(document.getElementById('otp_value').value);
            value+=10000;
            document.getElementById('otp_value').value = value;
            $('#otp_value').mask("#.##0",{reverse:true});
        }

        function decreaseOtpValue() {
            $('#otp_value').unmask();
            var value = parseInt(document.getElementById('otp_value').value);
            value = isNaN(value) ? 0 : value;
            value < 0 ? value = 0 : '';
            value-=10000;
            if(value<0)
                value =0
            document.getElementById('otp_value').value = value;
            $('#otp_value').mask("#.##0",{reverse:true});
        }
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>

@endsection
