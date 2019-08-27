<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta content="INDEX,FOLLOW" name="robots" />
    <meta name="viewport" content="width=device-width" />
    <meta name="copyright" content="@lang('seo.copyright')" />
    <meta name="author" content="@lang('seo.author')" />
    <meta property="og:site_name" content="{{env('APP_URL')}}" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="{{App::getLocale()}}" />
    <meta property="fb:pages" content="@lang('seo.fb_pages')" />

    <!-- Title -->
    <title>{{ config('app.name', 'Career IMT') }}</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="/common-assets/img/favicon.ico"/>
    <link href="/b2c-assets/css/themes.css" rel="stylesheet" type="text/css"/>

    <!-- Fonts-->
    <link rel="stylesheet" type="text/css" href="/b2c-assets/css/fonts/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/b2c-assets/css/fonts/pe-icon.css">
    <!-- Vendors-->
    <link rel="stylesheet" type="text/css" href="/b2c-assets/vendors/bootstrap/grid.css">
    <link rel="stylesheet" type="text/css" href="/b2c-assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/b2c-assets/vendors/magnific-popup/magnific-popup.min.css">
    <!-- App & fonts-->
    <link rel="stylesheet" href="/b2c-assets/css/d16fbfb1.app.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,500,700&amp;amp;subset=vietnamese">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Scripts -->
    <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{env('FACEBOOK_PIXEL_ID')}}');
        fbq('track', 'PageView');
        </script>
        <noscript>
        <img height="1" width="1"
        src="https://www.facebook.com/tr?id={{env('FACEBOOK_PIXEL_ID')}}&ev=PageView
        &noscript=1"/>
        </noscript>
    <!-- End Facebook Pixel Code -->
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

<div class="page-wrap">
    <div class="error-box">
        <div class="error-body text-center">
            @yield('content')

            <div class="small text-danger" style="margin: 0 20px 30px; max-height:220px; overflow: scroll;">
                {{ isset($message) ? $message : '' }}
            </div>

            <a href="/" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Về Trang Chủ</a>
        </div>
        <footer class="footer text-center">
            <?php echo date("Y"); ?> &copy; IMT Solution.
        </footer>
    </div>)
</div>
<div modal-render="true" tabindex="-1" role="dialog" class="modal fade ng-isolate-scope in" uib-modal-animation-class="fade" modal-in-class="in" ng-style="{'z-index': 1050 + index*10, display: 'block'}" uib-modal-window="modal-window" window-top-class="modal" index="0" animate="animate" modal-animation="true" style="z-index: 1050; display: none;">
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
    setInterval(function() {
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
        jQuery('title').text("@lang($seo_path.'.title')" + " | IMT Solutions - Career");
        @else
        jQuery('title').text("@lang('seo.home.title')" + " | IMT Solutions - Career");
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
    $(window).scroll(function(event){
        var st = $(this).scrollTop();
        if (st > lastHeight){
            // downscroll code
            $('.btn-chat').addClass('active');
        } else if(st == 0) {
            // upscroll code
            $('.btn-chat').removeClass('active');
        }
        lastHeight = st;
    });

    $(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })


</script>
<script>
    // go to dropdown seleted locations
    function goLocations() {
        window.location = "/locations/" + $('.select-location').val();
    }

    // go to top page
    function goTopPage() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
@yield('extra_scripts')
</html>
