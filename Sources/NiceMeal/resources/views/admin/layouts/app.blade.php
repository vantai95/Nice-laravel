<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <?php
        $url = \Request::path();
    ?>

    <title>{{ $url }}</title>

    <!-- Icon -->
    @if(CommonService::isTakeawayDomain())
        <!-- Icon -->
        <link rel="shortcut icon" href="/common-assets/img/favicon1.ico"/>
    @else  
    <!-- Icon -->
    <link rel="shortcut icon" href="/common-assets/img/favicon.ico"/>
    @endif
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <!-- Web fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/common-assets/js/jquery.validate.min.js"></script>
    <script src="/b2c-assets/js/angular.min.js" type="text/javascript"></script>

    <script>
        // localization for Vue component
        window.trans = @php
            // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
            $lang_files = \Illuminate\Support\Facades\File::files(resource_path() . '/lang/' . \Illuminate\Support\Facades\App::getLocale());
            $trans = [];
            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename);
            }
            echo json_encode($trans);
        @endphp

        @if(app()->getLocale() == 'vi')
        WebFont.load({
            google: {"families": ["Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
        @else
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
        @endif
    </script>

    <!-- Base Styles -->
    <link href="/admin-assets/theme/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="/admin-assets/theme/sites/style.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
   <!-- Custom Styles -->
    <link href="/admin-assets/css/app.css" rel="stylesheet" type="text/css"/>
    @yield('stylesheet')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{env('GOOGLE_ANALYTICS_ID')}}"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{env('GOOGLE_ANALYTICS_ID_ADMIN')}}');
    </script>
</head>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<div class="m-grid m-grid--hor m-grid--root m-page">

    @include('admin.layouts.header')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        @include('admin.layouts.aside-left')

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            @yield('content')
        </div>
    </div>

    @include('admin.layouts.footer')
</div>

{{--@include('admin.layouts.quick-sidebar')--}}
@include('admin.layouts.scroll-top')
@include('admin.layouts.quick-nav')

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<!-- Base Scripts -->
<script src="/admin-assets/theme/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="/admin-assets/theme/sites/scripts.bundle.js" type="text/javascript"></script>

<!-- Scripts -->
<script src="/admin-assets/js/admin.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>


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
<!-- include summernote css/js-->
<script>
    $(document).ready(function () {
        $('.price').mask("#.##0",{reverse:true});

        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
            ],
            tooltip: false,
            disableResizeEditor: true
        });

        $('.note-statusbar').hide(); 

        $('.summernote-textarea').summernote({
            height: 170,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['insert',['faicon']],
            ]
        });

        $('.select2').select2();
    });

    String.prototype.capitalize = function () {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }
</script>

<script>
    // seo
    window.onload = function ()
    {
        @if ($url!= "")
            @if($url == 'admin')
                jQuery('title').text("@lang('seo.home.dashboard')");
            @else
                var title = '{{$url}}';
                title = title.replace('admin/', '').replace('/', '-');
                jQuery('title').text(title);
            @endif
        @else
            jQuery('title').text("@lang('seo.home.title_admin')");
        @endif
    }
</script>

<script>
    // set active item sidebar
    $('#m_ver_menu').find('a').each(function(){
        if(window.location.href.includes($(this).attr('href'))) {
            $(this).parent('li').addClass('m-menu__item--active');
            $(this).parents('.m-menu__item.m-menu__item--submenu').addClass('m-menu__item--open');
        }
    });
</script>

<script src="/admin-assets/js/app.js" type="text/javascript"></script>

@yield('extra_scripts')
</body>
</html>
