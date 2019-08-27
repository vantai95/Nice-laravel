<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>

<div id="m_aside_left" class="m-grid__item	m-aside-left m-aside-left--skin-dark ">


    <div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark"
         data-menu-vertical="true" m-menu-scrollable="true" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow ">
            @foreach($left_menu as $menu)
                @if(count($menu->children) == 0)
                    <li class="m-menu__item m-menu__item" aria-haspopup="false">
                        <a href="{{ url($menu->url) }}" class="m-menu__link" title="@lang($menu->title)">
                            <i class="{{ $menu->icon }}"></i>
                            <span class="m-menu__link-text">@lang($menu->name)</span>
                        </a>
                    </li>
                @else
                  <li class="m-menu__item m-menu__item--submenu" aria-haspopup="false">
                      <a href="{{ url($menu->url) }}" class="m-menu__link m-menu__toggle" title="@lang($menu->title)">
                          <i class="{{ $menu->icon }}"></i>
                          <span class="m-menu__link-text">@lang($menu->name)</span>
                          <i class="m-menu__ver-arrow la la-angle-right"></i>
                      </a>
                      <div class="m-menu__submenu ">
                          <span class="m-menu__arrow"></span>
                          <ul class="m-menu__subnav">
                            @foreach($menu->children as $sub_menu)
                              <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                  <a href="{{ url($sub_menu->url) }}" class="m-menu__link ">
                                      <i class="{{$sub_menu->icon}}"></i>
                                      <span class="m-menu__link-text">@lang($sub_menu->name)</span>
                                  </a>
                              </li>
                            @endforeach
                          </ul>
                      </div>
                  </li>
                @endif
            @endforeach


            <!--
            <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                    m-menu-submenu-toggle="click" m-menu-link-redirect="1">
                    <a href="javascript:;" class="m-menu__link m-menu__toggle" title="@lang('admin.layouts.aside_left.group.staff')">
                        <i class="m-menu__link-icon flaticon-interface-7"></i>
                        <span class="m-menu__link-text">@lang('admin.layouts.aside_left.group.staff')</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">

                            @if(CommonService::checkRestaurantManagement($res->res_Slug))
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('admin/'.$res->res_Slug.'/uploads') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-tea-cup"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.staff.uploads')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('admin') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-calendar"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.staff.galleries')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                -->

        </ul>
    </div>
</div>
<div class="m-aside-menu-overlay"></div>
