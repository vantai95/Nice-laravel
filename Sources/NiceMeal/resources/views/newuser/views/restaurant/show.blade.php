@extends('newuser.layouts.app')
@section('content')
    <div class="detail-restaurant" ng-init="" ng-controller="RestaurantDetailCtrl" ng-cloak>
        <div class="header row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-img">
                @if(!$restaurant->res_image)
                    <img src="/b2c-assets/img/restaurant_image.jpg"
                         style="width: 100%"/>
                @else
                    <img src="{{config('filesystems.disks.azure.url').'/'}}/<% restaurant.res_image %>"
                         style="width: 100%"/>
                @endif
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-text">
                <p class="res-name"><% restaurant.name %><i class="fa fa-heart-o icon-heart" aria-hidden="true"></i></p>
                <p class="res-title"><% restaurant.title_brief %></p>
                <p class="res-btn" style="margin: 10px 0px 20px 0;">
                    <button class="btn-talk" style="">Let's Talk</button>
                </p>
            </div>
            <div class="col-xs-7 col-sm-7 col-md-7 col-description">
                <p class="description"><% htmlToPlaintext(restaurant.description) %></p>
                <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="fa-ellipsis-h" style="font-family: FontAwesome;"></span>
                                </a>
                                <span class="glyphicon glyphicon-option-horizontal"></span>
                                <ul class="dropdown-menu">
                                    <li><a href="/restaurants/<% restaurant.restaurant_slug %>/faqs"><i class="fa fa-question-circle" aria-hidden="true"></i><span>FAQs</span></a></li>
                                    <li><a href="#"><i class="fa fa-share" aria-hidden="true"></i><span>Share</span></a>
                                    </li>
                                    <li><a href="#" ng-click="selectRestaurant()"><i class="fa fa-info" aria-hidden="true"></i><span>Info</span></a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><span>Report</span></a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-ban" aria-hidden="true"></i><span>CUT</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        @include('newuser.components.restaurant.restaurant-detail-menu')
        @include('newuser.components.restaurant.restaurant-detail-main')
        @include('newuser.components.popup.restaurant.popup-add-to-cart')
        @include('newuser.components.restaurant.popup-info-res')
    </div>

@endsection
@push('extra_scripts')
    <script type="text/javascript" src="/b2c-assets/js/newuser/restaurants/detail.js"></script>
    <script type="text/javascript">
        angular.element(document).ready(function () {
            $restaurantDetailScope = angular.element('[ng-controller=RestaurantDetailCtrl]').scope();
            $restaurantDetailScope.restaurant = @json($restaurant);
            $restaurantDetailScope.categories = @json($resCategories);
            $restaurantDetailScope.beingRenderedCustomization = undefined;
            $restaurantDetailScope.selectedCategory = undefined;
            $restaurantDetailScope.selectedDish = undefined;
            $restaurantDetailScope.selectedCustomizations = [];
            $restaurantDetailScope.init();
            $cartScope.initCart($restaurantDetailScope.restaurant);
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $("#owl-demo").owlCarousel({
            items:6,
            navigation : true,
            goToFirst: true,
            navigationText: [
                  "<i class='fa fa-chevron-left'></i>",
                  "<i class='fa fa-chevron-right'></i>"
                ],
          });
        });
    </script>
@endpush
