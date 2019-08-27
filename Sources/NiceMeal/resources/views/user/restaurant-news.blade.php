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


    <!-- sortbox -->
    <div class="sortbox">
      <div class="sortbox__left">
        <h3 class="sortbox__title">{{restaurant.news.length}} posts now</h3>
      </div>
      <!-- <div class="sortbox__right"><span class="text">Sort By: </span>
        <select class="form-control select-sort" data-placeholder="Select an Account">
          <option>Groupon</option>
          <option>AMEX</option>
          <option>Cash</option>
          <option>Breadcrumb</option>
        </select>
      </div> -->
    </div>
    <!-- End / sortbox -->

    <div class="new-wrap">

      <!-- new -->
      <div class="new" ng-repeat="news in restaurant.news">
        <div class="new__media"><a class="click-show-popup" data-ui-sref="pageNews.pageDetail({subSlug: '1'})" data-effect="mfp-zoom-in"><img ng-src="{{news.thumbnail_image}}" alt=""/></a></div>
        <div class="new__body">
          <h2 class="new__title"><a href="#">{{news.title}}</a></h2>
          <div class="new__meta">
            <span class="meta-date">{{ news.published_time | date : "longDate" }}</span>
            <span class="meta-view"> <i class="fa fa-eye"></i>{{::news.num_of_view}}</span>
            <span class="meta-heart"> <i class="fa fa-heart"></i>{{::news.num_of_like}}</span>
            <!-- <span class="meta-out"> <i class="fa fa-mail-forward"></i>100</span> -->
          </div>
          <p class="new__text">
            {{news.excerpt}}
          </p>
          <a class="new__readmore click-show-popup" ng-click="openNewsDetails(news)" data-effect="mfp-zoom-in">Read more <i class="fa fa-angle-double-right"></i></a>
        </div>
      </div><!-- End / new -->


    </div>
    <div class="md-text-center">
      <a class="md-btn md-btn--danger md-btn--sm " href="#">load again
      </a>
    </div>
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
