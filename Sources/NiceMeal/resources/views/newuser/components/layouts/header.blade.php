<!-- header -->
@php
    $currentPath= Route::getFacadeRoot()->current()->uri();
@endphp
<header class="header header-border" ng-controller="LayoutHeaderCtrl" ng-cloak>
    <div style="margin-left:15px" class="container">
        <div class="header__inner">
            <div class="header__left header-left-content">
                <div class="header__logo"><a href="{{ url('/') }}"><img src="/b2c-assets/img/header_icon.png"/></a>
                </div>
            </div>

            <div class="support-mail-content">
                <div class="header-location-info" data-toggle="modal" data-target="#myModalLocation">
                    <div class="header-location-info-text"><% getService() %></div>
                    <a class="header-location-info-button" href="#">
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
            </div>

            <div class="support-mail-content" id="header-search">
                <div class="header__search">
                    <div class="form-item form-item--button header-search-wrapper">
                        <input style="font-size:16px;" class="form-control header-search-input" type="text"
                               name="search" placeholder="Search Restaurant, Cuisine, Category, ...">
                        <a style="font-size:20px;color:#c02e40 !important;" class="md-btn md-btn--primary" href="#">
                            <i class="fa fa-search"></i>
                        </a>
                    </div><!-- End / form-item -->
                </div>
            </div>

            <div class="header-button-group">
                <button class="md-btn md-btn--primary header-extra-info-button" type="button" name="button">
                    <img src="/b2c-assets/img/piggy-bank.png" alt="">
                </button>
                @if(Auth::check())
                    <span class="dropdown">
                        <button class="md-btn md-btn--primary header-extra-info-button dropdown-toggle" type="button" data-toggle="dropdown">
                            @if(Auth::user()->avatar)
                                <img src="/b2c-assets/img/example_avata.png" alt="">
                            @else
                                <img src="/b2c-assets/img/avatar_empty.png" alt="">
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-header-mg">
                            <li>
                                <a href="#">Profile</a>
                                <a href="{{url('logout')}}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        Logout
                                </a>
                            </li>
                        </ul>
                    </span>
                @endif
                <span class="dropdown">
                    <button class="md-btn md-btn--primary header-extra-info-button" type="button" name="button" data-toggle="dropdown">
                        <img src="/b2c-assets/img/list.png" alt="">
                    </button>
                    <ul class="dropdown-menu dropdown-header-mg">
                        <li>
                            @if(!Auth::check())
                                <a href="#" data-target="#myModalLogin" data-toggle="modal">Login</a>
                                <a href="#" data-target="#myModalRegister" data-toggle="modal">Register</a>
                            @endif
                            <a href="#">Advance option 1</a>
                            <a href="#">Advance option 2</a>
                            <a href="#">Advance option 3</a>
                        </li>
                    </ul>
                </span>
            </div>
        </div>
    </div>
</header>
@push('extra_scripts')
    <script src="/b2c-assets/js/newuser/header/layout-header-ctrl.js"></script>
    <script type="text/javascript">
        angular.element(document).ready(function(){
            $headerScope = angular.element('[ng-controller=LayoutHeaderCtrl]').scope();
        })
    </script>
@endpush
