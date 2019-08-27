@extends('layouts.app')
@section('content')

    <div class="md-content mg-t-100">
        <!-- your-location -->
        <section class="your-location">
            <div class="md-tb">
                <div class="md-tb__cell">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-2 ">
                                <div class="your-location__inner">
                                    <div class="your-location__logo">
                                        <a href="#"><img src="/b2c-assets/img/{{ CommonService::getLogoHomePage()}}" alt=""></a>
                                    </div>
                                    @if(!CommonService::isTakeawayDomain())
                                    <h1 class="your-location__title">@lang('b2c.home.content.title')</h1>
                                    @endif
                                    <div class="your-location__form">
                                        <div class="ui-select-box has-button">
                                            <div class="ui-select-container select2 select2-container select2-width">
                                                <label for="state">District</label>
                                                <select class="select-location" name="state" id="state">
                                                    <option value="" selected >@lang('b2c.home.content.where_do_you')</option>
                                                    @foreach($districts as $key => $district)
                                                        <option value="{{ $district->slug }}">{{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="select-wards" class="ui-select-container select2 select2-container select2-width">
                                                <label for="wards">Ward</label>
                                                <select class="select-location" name="wards" id="wards">
                                                    <option value="" selected >All</option>
                                                </select>
                                            </div>
                                        </div>
                                        <a class="md-btn md-btn--primary go-btn pull-right" style="margin-top: 8px;" href="" onclick="goLocations()">
                                            @lang('b2c.home.content.button')
                                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </div>

                                    <div class="your-location__process">
                                        <ul>
                                            <li>
                                                <img src="/b2c-assets/img/home_location.png" alt="">
                                                <span>01. @lang('b2c.home.content.des_1')</span>
                                            </li>
                                            <li>
                                                <img src="/b2c-assets/img/home_order.png" alt="">
                                                <span>02. @lang('b2c.home.content.des_2')</span>
                                            </li>
                                            <li>
                                                <img src="/b2c-assets/img/home_delivery.png" alt=""
                                                ><span>03. @lang('b2c.home.content.des_3')</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- End / your-location -->

        @include('user.social-tools')

    </div>

@endsection
@section('extra_scripts')
    <script>
        /*$('#select-wards').hide();*/
        $('.select-location').select2({

        });
    </script>
    <script>
        $(document).ready(function () {
            checkCookie("location_info");
            $('#state').change(function () {
                $.blockUI({
                    css: {
                        border: 'none',
                        backgroundColor: '#ff002a',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .8,
                        color: '#fff4f6'
                    },
                    message: `<p>Please wait...</p>`
                });
                $.ajax({
                    url: '/get-wards?slug='+$(this).val(),
                    type: 'get',
                    success: function (data) {
                        $('#select-wards').slideDown(300);
                        appendWards(data);
                        $.unblockUI();
                    }
                });
            });
        });
        function appendWards(wards) {
            $('#wards').html(`<option value="" selected >All</option>`);
            $.each(wards,function () {
               $('#wards').append(`<option value="${this.id}">${this.type} ${this.name}</option>`);
            });
        }
      function getCookie(cname){
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }
      function checkCookie(cname){
        var cookie = getCookie(cname);
        if(cookie !== ""){
          $("body").html("");
          window.location.reload();
        }
      }
    </script>
@endsection
