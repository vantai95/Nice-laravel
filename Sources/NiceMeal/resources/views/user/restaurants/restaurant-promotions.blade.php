<div class="col-lg-9 col-lg-push-3">
  <div class="main-content">

    <!-- nav-menu -->
    <nav class="nav-menu">
      <div class="nav-menu__toggle"><span class="toggle__text" data-text="Hide">Show </span>menu</div>
      <ul class="nav-menu__list">
        <li ng-repeat="item in nav" ng-class="{'current': item.url === currentStateName}">
          <a ui-sref="{{item.url}}({restaurant_slug: restaurant_slug})">{{item.name}}</a>
        </li>
      </ul>
    </nav><!-- End / nav-menu -->


    <!-- promotions -->
    <div class="promotions">
      <ul class="promotions__list">
        <li ng-repeat="item in promotions">
          <a href="#">
            <h3 class="promotions__title">{{item.title}}</h3>
            <p class="promotions__text">{{item.description}}</p>
          </a>
        </li>
      </ul>
    </div><!-- End / promotions -->

  </div>
</div>
<div class="col-lg-3 col-lg-pull-9">
  <div class="sidebar-left">

    <!-- widget -->
    <div class="widget">
      <h2 class="widget__title">Choose Cuisine</h2>
      <div class="widget__content">

        <!-- widget-categories -->
        <ul class="widget-categories">
          <li ng-repeat="(category_name, category) in restaurant_dishes">
            <a href="#section-{{$index}}">{{::category_name}}</a>
          </li>
        </ul><!-- End / widget-categories -->

      </div>
    </div><!-- End / widget -->

  </div>
</div>
