<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="otp-popup-time" content="{{ env('TIME_SHOW_POPUP') }}">
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width"/>
    <meta name="copyright" content="@lang('seo.copyright')"/>
    <meta name="author" content="@lang('seo.author')"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="INDEX,FOLLOW" name="robots"/>
    <meta property="og:site_name" content="{{env('APP_URL')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:locale" content="{{App::getLocale()}}"/>
    <meta property="fb:pages" content="@lang('seo.fb_pages')"/>

  
    @if(CommonService::isTakeawayDomain())
        <!-- Title -->
        <title>VnTakeaway.com</title>
        <!-- Icon -->
        <link rel="shortcut icon" href="/common-assets/img/favicon1.ico"/>
    @else  
    <!-- Title -->
    <title>{{ config('app.name', 'Nice Meal') }}</title>
    <!-- Icon -->
    <link rel="shortcut icon" href="/common-assets/img/favicon.ico"/>
    @endif

    <!-- Fonts-->
    <link rel="stylesheet" type="text/css" href="/b2c-assets/css/fonts/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/b2c-assets/css/fonts/pe-icon.css">

    <!-- Vendors-->
    <link rel="stylesheet" type="text/css" href="/b2c-assets/vendors/bootstrap/grid.css">
    <link rel="stylesheet" type="text/css" href="/b2c-assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/b2c-assets/vendors/magnific-popup/magnific-popup.min.css">
    <link rel="stylesheet" type="text/css" href="/b2c-assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">

    <!-- App & fonts-->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,500,700&amp;amp;subset=vietnamese">
    <link rel="stylesheet" href="/b2c-assets/css/themes.css">
    <link rel="stylesheet" href="/b2c-assets/css/d16fbfb1.app.css">
    <link rel="stylesheet" href="/b2c-assets/css/main.css">
    <link rel="stylesheet" href="/b2c-assets/css/toastr.css">

    @yield('stylesheet')

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/common-assets/js/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    <script src="/b2c-assets/js/angular.min.js"></script>
    <script src="/b2c-assets/js/app.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/b2c-assets/js/toastr.min.js"></script>
    <script src="/b2c-assets/vendors/select2/select2.min.js"></script>
    <script src="/b2c-assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{env('GOOGLE_ANALYTICS_ID')}}"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{env('GOOGLE_ANALYTICS_ID')}}');
    </script>
</head>
<body id="TdoZ1yn8hH9IWafN0GpT5z38CliWDnzr">

<div class="page-wrap" ng-app="userApp">

    @include('layouts.header_mealrest')
    @yield('content')
    @include('layouts.footer')
</div>
<div modal-render="true" tabindex="-1" role="dialog" class="modal fade ng-isolate-scope in"
     uib-modal-animation-class="fade" modal-in-class="in" ng-style="{'z-index': 1050 + index*10, display: 'block'}"
     uib-modal-window="modal-window" window-top-class="modal" index="0" animate="animate" modal-animation="true"
     style="z-index: 1050; display: none;">
    <div class="modal-dialog" ng-class="size ? 'modal-' + size : ''">
        <div class="modal-content" uib-modal-transclude="">
            @yield('modal')
        </div>
    </div>
</div>


</body>


<script>
    var TEMP_TOKEN = "aea6e62f91f90a820631cd2b35412f7f";
    function getCurrentTime() {
        var date = new Date();
        var hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
        var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
        return hours + ":" + minutes;
    };
    $('li.clock span').text(getCurrentTime());
    setInterval(function () {
        $('li.clock span').text(getCurrentTime());
    }, 1000000)
</script>

<script>
    window.onload = function () {
        <?php
        $url = \Request::path();
        $seo_path = 'seo.' . str_replace('/', '.', str_replace('-', '_', $url));
        ?>

        @if (\Lang::has($seo_path.'.title') && \Lang::get($seo_path.'.keywords') != "" && strcmp($url, '/'))
        jQuery('title').text("@lang($seo_path.'.title')" + "");
        @else
            @if(CommonService::isTakeawayDomain())
            jQuery('title').text("VnTakeaway.com" + "");
            @else
            jQuery('title').text("@lang('seo.home.title')" + "");
            @endif
        @endif
        @if (\Lang::has($seo_path.'.keywords') && \Lang::get($seo_path.'.keywords') != "" && strcmp($url, '/'))
        jQuery('meta[name=keywords]').attr('content', "@lang($seo_path.'.keywords')");
        @else
        jQuery('meta[name=keywords]').attr('content', "@lang('seo.home.keywords')");
        @endif

        @if (\Lang::has($seo_path.'.description') && \Lang::get($seo_path.'.description') != "" && strcmp($url, '/'))
        jQuery('meta[name=description]').attr('content', "@lang($seo_path.'.description')");
        @else
        jQuery('meta[name=description]').attr('content', "@lang('seo.home.description')");
        @endif
    }
</script>


<script type="text/javascript">
    @if (session('flash_message'))
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr.success("{{ session('flash_message') }}");
    });
    @endif

    @if (session('flash_error'))
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.error("{{ session('flash_error') }}");
    });
    @endif
</script>
<!-- <script type="text/javascript" src="/b2c-assets/js/b8450493.app.js"></script> -->
<script>
    // event scroll page
    var lastHeight = 0;
    $(window).scroll(function (event) {
        var st = $(this).scrollTop();
        if (st > lastHeight) {
            // downscroll code
            $('.btn-chat').addClass('active');
        } else if (st == 0) {
            // upscroll code
            $('.btn-chat').removeClass('active');
        }
        lastHeight = st;
    });

</script>
<script>
    // go to dropdown seleted locations
    function goLocations() {
        if($('.select-location').val()!=null){
            window.location = "/locations/" + $('.select-location').val();
        }
        else{
            toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.error("@lang('b2c.home.content.error_location')");
        }

    }

    // go to top page
    function goTopPage() {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    }

    function backToOrderPage(){
        window.location = document.referrer;
    }

    /**
     * Number.prototype.format(n, x, s, c)
     *
     * @param integer n: length of decimal
     * @param integer x: length of whole part
     * @param mixed   s: sections delimiter
     * @param mixed   c: decimal delimiter
     */
    Number.prototype.format = function(n, x, s, c) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
            num = this.toFixed(Math.max(0, ~~n));

        return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
    };

    /**
     * Number.prototype.format(n, x, s, c)
     *
     * @param integer n: length of decimal
     * @param integer x: length of whole part
     * @param mixed   s: sections delimiter
     * @param mixed   c: decimal delimiter
     * @param mixed   u: currency unit
     */
    Number.prototype.format = function(n, x, s, c, u) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
            num = this.toFixed(Math.max(0, ~~n));

        return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','))  + u;
    };

    /**
     * Format currency
     */
    Number.prototype.formatCurrency = function() {
        return this.format(0, 3, '.', ' ', ' VNĐ');
    };

    $(document).ready(function () {

        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('.back-to-top').fadeIn();
            } else {
                $('.back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('.back-to-top').click(function () {
            $('.back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });

        $('#back-to-top').tooltip('show');

    });
</script>

<script>
    $('#submitEmailForm').submit( function (form) { // <- pass 'form' argument in
        $(".submit").attr("disabled", true);
        $('#submitEmailForm .response-field').remove();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'post',
            url: '/email-marketing',
            data: $('form').serialize(),
            success: function () {
                $('#email').val('');
                $(".submit").attr("disabled", false);
                $('#submitEmailForm').append("<p class='success-field response-field'>@lang('b2c.footer.success')</p>");
            },
            error: function () {
                $('#email').val('');
                $(".submit").attr("disabled", false);
                $('#submitEmailForm').append("<p class='error-field response-field'>@lang('b2c.footer.error')</p>");
            }
        });
    });
    
    function sortObjects(key, order = 'asc') {
        return function (a, b) {
            if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
                return 0;
            }

            const varA = (typeof a[key] === 'string') ?
                a[key].toUpperCase() : a[key];
            const varB = (typeof b[key] === 'string') ?
                b[key].toUpperCase() : b[key];

            let comparison = 0;
            if (varA > varB) {
                comparison = 1;
            } else if (varA < varB) {
                comparison = -1;
            }
            return (
                (order == 'desc') ? (comparison * -1) : comparison
            );
        };
    }

    const array_column = (array, column) => array.map(e => e[column]);

    function checkStrongPassword(passValue) {
        var strongPassword = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");

        if(strongPassword.test(passValue)) {
            return true;
        } else {
            return false;
        }
    }

</script>

@yield('extra_scripts')
</html>
