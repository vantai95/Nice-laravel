@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::open([
                    'url' => '/admin/restaurants',
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.restaurants.form')
                {!! Form::close() !!}
            <!--end::Form-->
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
                    maxFiles: 1,
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
                    'url': "{{ url('/admin/restaurants/upload') }}",

                    "headers":
                        {
                            'X-CSRF-TOKEN': token
                        },
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

        $(document).ready(function(){
            $("#submitButton").click(function(){
                $('.news').remove();
                $('#m-dropzone-two').find('img').each(function(index){
                    $('#submitForm').append('<input type="hidden" class="news" name="image_'+ index +'" value="'+ $(this).attr('src') +'" /> ');
                });
            });
            getWards($("select[name='district_id']").val());

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

            $("#otp").val(1);
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
        });

        // var IONRangeSlider={
        //     init: function() {
        //         $("#vip_restaurant").ionRangeSlider({
        //             skin: 'big',
        //             min: 0,
        //             max: 10,
        //             step: 1,
        //            disable: "false" !== "{{ Auth::user()->isAdmin() ? 'false' : 'true' }}",
        //            from: '{{ isset($restaurant) ? $restaurant->vip_restaurant : 0 }}',
        //            prefix: 'VIP '
        //        })
        //    }
        // };
        // jQuery(document).ready(function(){
            // IONRangeSlider.init();
        // });

        // Increase Decrease OPT
        $('#otp').mask("#.##0",{reverse:true});
        $('#otp_value').mask("#.##0",{reverse:true});

        $('#submitForm').submit(function(){
            $('#otp').unmask();
            $('#otp_value').unmask();
        });

        function increaseOtp() {
            var value = parseInt(document.getElementById('otp').value, 10);
            value = isNaN(value) ? 1 : value;
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
