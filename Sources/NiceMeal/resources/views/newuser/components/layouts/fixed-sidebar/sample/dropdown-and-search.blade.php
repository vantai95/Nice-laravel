<div class="widget" style="display:none;" ng-controller="{{$ngController}}">
  @include('newuser.components.layouts.fixed-sidebar.sample.items.header',['header' => $header])
  @include('newuser.components.layouts.fixed-sidebar.sample.items.dropdown')
  <div class="widget__content fixed-sidebar-content">
    @yield('dropdownandsearch-sample-content')
  </div>
  @include('newuser.components.layouts.fixed-sidebar.sample.items.search')
</div>
