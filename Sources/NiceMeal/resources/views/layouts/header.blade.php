<!-- header -->
@php
    $currentPath= Route::getFacadeRoot()->current()->uri();
@endphp
<header class="header header-border">
    <div class="container">
        <div class="header__inner">
            <div class="header__left header-left-content">
                @if($currentPath != 'home' && $currentPath != '/')
                    <div class="header__logo"><a href="{{ url('/') }}"><img src="/b2c-assets/img/{{ CommonService::getLogo()}}"/></a>
                    </div>
                @endif
            </div>

           <div class="support-mail-content">
                @if(strpos($currentPath, 'locations') !== 0)
                    @if(CommonService::isTakeawayDomain())
                     <a href="mailto:contact.VnTakeaway@gmail.com">Contact us: VnTakeaway@gmail.com</a>
                    @else
                        <a href="mailto:contact.nicemeal@gmail.com">Support via: contact.nicemeal@gmail.com</a>
                    @endif
                @endif
           </div>

            <nav class="header__nav">
                @if(CommonService::isTakeawayDomain())
                <ul class="header__menu">
                    @if(strpos($currentPath, 'locations') === 0)
                    <li>
                    @if(CommonService::isTakeawayDomain())
                     <a href="mailto:contact.VnTakeaway@gmail.com">Contact us: VnTakeaway@gmail.com</a>
                    @else
                        <a href="mailto:contact.nicemeal@gmail.com">Support via: contact.nicemeal@gmail.com</a>
                    @endif
                    </li>
                    @endif
                    @if(!auth()->check())
                    <li>
                        <a href="{{ url('login') }}"><img class="menu-img" src="/b2c-assets/img/user.png"><span>@lang('b2c.header.login_register')</span></a>
                    </li>
                    @endif
                    @if(auth()->check())
                        <li>
                            <a href="#" onclick="$('#logout-form').submit()">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                <i class="fa fa-sign-out"></i>
                                <span>@lang('b2c.header.logout')</span>
                            </a>
                        </li>
                    @endif
                </ul>
                @else
                <ul class="header__menu">
                    @if(auth()->check())
                        <li><a href="{{ url('my-info') }}"><img class="menu-img" src="/b2c-assets/img/user.png"><span>@lang('b2c.header.info')</span></a></li>
                        <li><a href="#"><img class="menu-img" src="/b2c-assets/img/home.png"><span>@lang('b2c.header.my_page')</span></a></li>
                    @else
                        <li>
                            <a href="{{ url('login') }}"><img class="menu-img" src="/b2c-assets/img/user.png"><span>@lang('b2c.header.login_register')</span></a>
                        </li>
                        <li>
                            <a href="#"><img class="menu-img" src="/b2c-assets/img/support.png"><span>@lang('b2c.header.support')</span></a>
                        </li>
                    @endif
                    <li>
                        <div class="dropdown">
                            <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="d-flex-menu">
                                    @if (\Session::get('locale') == 'en')
                                        ENG
                                    @else
                                        JAP
                                    @endif
                                    <i id="dropdown_arrow" class="fa fa-angle-down arrow-style"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-width" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{url('/languages/en')}}">English</a>
                                <a class="dropdown-item" href="{{url('/languages/ja')}}">Japanese</a>
                            </div>
                        </div>
                    </li>
                    <li class="clock"><a href=""><i class="fa fa-clock-o"></i><span>12 : 00</span></a></li>
                    @if(auth()->check())
                        <li>
                            <a href="#" onclick="$('#logout-form').submit()">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                <i class="fa fa-sign-out"></i>
                                <span>@lang('b2c.header.logout')</span>
                            </a>
                        </li>
                    @endif
                </ul>
                <span class="header-toggle-search"><i class="fa fa-search"></i><span>@lang('b2c.header.search')</span></span>
                @endif

            </nav>
        </div>
    </div>
</header><!-- End / header -->
