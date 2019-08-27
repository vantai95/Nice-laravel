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
    <link href="/b2c-assets/css/vendor.css" rel="stylesheet" type="text/css"/>
    <link href="/b2c-assets/css/themes.css" rel="stylesheet" type="text/css"/>

    <link href="/b2c-assets/css/app.css" rel="stylesheet" type="text/css"/>
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
<body id="">

@yield('content')
</body>


<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>

<script src="/b2c-assets/js/themes.js" type="text/javascript"></script>
<script src="/b2c-assets/js/app.js" type="text/javascript"></script>
<script src="/b2c-assets/js/vendor.js" type="text/javascript"></script>

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

@yield('extra_scripts')
</html>
