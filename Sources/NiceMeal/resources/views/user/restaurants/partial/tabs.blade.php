<nav class="nav-menu menu-restaurants-detail">
    <div class="nav-menu__toggle"><span class="toggle__text" data-text="Hide">Show </span>menu</div>
    <ul class="nav-menu__list" style="display: none;">
        <li value="menu" ng-class="selectedMenuNav =='menu' ?'current':''">
            <a href="/restaurants/{{$slug}}?district={{ Request::get('district') }}&ward={{ Request::get('ward') }}">Menu </a>
        </li>
        <li  ng-class="selectedMenuNav =='intro' ?'current':''">
            <a href="/restaurants/{{$slug}}/intro?district={{ Request::get('district') }}&ward={{ Request::get('ward') }}">Intro</a>
        </li>
        <li  ng-class="selectedMenuNav =='info' ?'current':''">
            <a href="/restaurants/{{$slug}}/info?district={{ Request::get('district') }}&ward={{ Request::get('ward') }}">Info </a>
        </li>
        <li  ng-class="selectedMenuNav =='promotion' ?'current':''">
            <a href="/restaurants/{{$slug}}/promotion?district={{ Request::get('district') }}&ward={{ Request::get('ward') }}">Promotions </a>
        </li>
        <li   ng-class="selectedMenuNav =='review' ?'current':''">
        <a href="/restaurants/{{$slug}}/reviews?district={{ Request::get('district') }}&ward={{ Request::get('ward') }}" value="reviews">Reviews </a>
      </li>
    </ul>
</nav>
<script type="text/javascript">
    $(document).ready(function(){
        $(".menu-restaurants-detail .nav-menu__toggle").click(function(){
        $(".menu-restaurants-detail .nav-menu__list").toggle(1000);
      });
    });
</script>