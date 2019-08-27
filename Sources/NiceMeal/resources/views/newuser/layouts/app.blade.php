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
    <meta property="og:site_name" content="{{URL::to('/')}}"/>
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
    <link rel="stylesheet" type="text/css" href="/b2c-assets/css/bootstrap-timepicker.min.css">

    <!-- App & fonts-->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,500,700&amp;amp;subset=vietnamese">
    <link rel="stylesheet" href="/b2c-assets/css/themes.css">
    <link rel="stylesheet" href="/b2c-assets/css/d16fbfb1.app.css">
    <link rel="stylesheet" href="/b2c-assets/css/main.css">
    <link rel="stylesheet" href="/b2c-assets/css/toastr.css">
    <link rel="stylesheet" href="/b2c-assets/css/usercustom.css">
    <link rel="stylesheet" href="/b2c-assets/css/popup.css">
    <link rel="stylesheet" href="/b2c-assets/css/login.css">
    <link rel="stylesheet" href="/b2c-assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/b2c-assets/css/jquery.multiselect.css">
    <link rel="stylesheet" href="/b2c-assets/css/owl.carousel.css">
    @yield('stylesheet')

    <!-- Scripts -->
    <script src="/b2c-assets/js/jquery.min.js"></script>
    <script src="/common-assets/js/jquery.validate.min.js"></script>
    <script src="/b2c-assets/js/jquery.mask.min.js"></script>
    <script src="/b2c-assets/js/jquery.blockUI.js"></script>
    <script src="/b2c-assets/js/bootstrap.min.js"></script>
    <script src="/b2c-assets/js/toastr.min.js"></script>
    <script src="/b2c-assets/vendors/select2/select2.min.js"></script>
    <script src="/b2c-assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="/b2c-assets/js/bootstrap-timepicker.min.js"></script>
    <script src="/b2c-assets/js/owl.carousel.min.js"></script>
    <script src="/b2c-assets/js/angular.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{env('GOOGLE_ANALYTICS_ID')}}"></script>
    <!--  -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"/>
     <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{env('GOOGLE_ANALYTICS_ID')}}');
    </script>
  </head>
  <body>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
  </form>
  <div class="page-wrap" ng-app="userApp">
    @include('newuser.components.layouts.header')
    <div class="md-content content">
      @if(Route::getCurrentRoute()->uri() == '/' || Route::getCurrentRoute()->uri() == 'payment/payment-status')
        @include('newuser.components.layouts.content')
      @else
        @include('newuser.components.layouts.left-sidebar')
        @include('newuser.components.layouts.content')
        @include('newuser.components.layouts.right-sidebar')
      @endif
    </div>
    @include('newuser.components.popup.popup-location')
    @include('newuser.components.layouts.footer')
    @include('newuser.components.popup.auth.register')
    @include('newuser.components.popup.auth.login')
    @include('newuser.components.popup.auth.forgot')

  </div>

  </body>
  <script type="text/javascript" src="\b2c-assets\js\sidebar.js"></script>
  <script src="/b2c-assets/js/app.js"></script>
  <script>
      angular.element(document).ready(function () {
          $cartScope = angular.element('[ng-controller=CartCtrl]').scope();
          $cartScope.initCart();
          $cartScope.init();
      })
  </script>
  <script type="text/javascript" src="\b2c-assets\js\newuser\fixed-sidebar\component.js"></script>
  <script type="text/javascript" src="\b2c-assets\js\newuser\fixed-sidebar\cart-ctrl.js"></script>
  <script type="text/javascript" src="\b2c-assets\js\newuser\fixed-sidebar\chat-ctrl.js"></script>
  <script type="text/javascript" src="\b2c-assets\js\newuser\header\location-popup.js"></script>
  <script type="text/javascript" src="\b2c-assets\js\newuser\auth\login-popup.js"></script>
  <script type="text/javascript" src="\b2c-assets\js\newuser\auth\forgot-popup.js"></script>
  <script type="text/javascript" src="\b2c-assets\js\newuser\auth\register-popup.js"></script>
  <script type="text/javascript" src="\b2c-assets\js\newuser\fixed-sidebar\leader-board-ctrl.js"></script>
  <script type="text/javascript">
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

    $("#registerBtn").click(function(){
        $("#myModalLogin").modal("hide");
        setTimeout(function(){
            $("#myModalRegister").modal();
        }, 500);
    });
    $("#forgotBtn").click(function(){
        $("#myModalLogin").modal("hide");
        setTimeout(function(){
            $("#forgot-password").modal();
        }, 300);
    });

    // validate number
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

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
  @stack('extra_scripts')
</html>
