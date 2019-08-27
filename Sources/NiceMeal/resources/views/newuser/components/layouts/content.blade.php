
@if(Route::getCurrentRoute()->uri() == '/')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  @yield('content')
</div>
@else
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
  @yield('content')
</div>
@endif
