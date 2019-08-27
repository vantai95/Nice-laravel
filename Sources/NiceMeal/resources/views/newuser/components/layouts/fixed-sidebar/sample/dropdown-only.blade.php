<div class="widget" style="display:none;" ng-controller="{{$ngController}}">
  <div id="promotion-overlay" class="centered-overlay"></div>
  @include('newuser.components.layouts.fixed-sidebar.sample.items.header',['header' => $header])
  @include('newuser.components.layouts.fixed-sidebar.sample.items.dropdown')
  <div class="widget__content fixed-sidebar-content">
    @yield('dropdownandsearch-sample-content')
  </div>
</div>
