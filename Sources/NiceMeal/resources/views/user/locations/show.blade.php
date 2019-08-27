@extends('layouts.app')
@section('content')
    <div class="md-content" ng-controller="LocationShowCtrl">

        @include('user.social-tools')
        <section class="md-section search show">
            <div class="container">
                <div class="header__search">
                    <!-- form-item -->
                    <div class="form-item form-item--button">
                        <input class="form-control" type="text" name="search" ng-change="searchRes()" ng-model="searchKey"
                               placeholder="Search Restaurant, Cuisine, Category, ..."/>
                        <a class="md-btn md-btn--primary" href="#">@lang('b2c.header.search')
                        </a>
                    </div><!-- End / form-item -->
                </div>
            </div>
        </section>

        <!-- Section -->
        <section class="md-section hidden" style="padding-top: 0">
            <div class="container" >
                <div class="row">
                    <div class="col-lg-3">
                        <div class="sidebar-left">

                            <div class="location your-location__form mgt-go-btn">
                                <div class="ui-select-box has-button">
                                    <div class="ui-select-container select2 select2-container">
                                        <label for="state">District</label>
                                        <select class="select-location" name="state" id="state">
                                            <option ng-repeat="district in allDistricts" value="<% district.slug %>" ng-model="district"
                                                    ng-selected="<% district.slug == '{{ $slug }}' %>" ><% district.name %></option>
                                        </select>
                                    </div>
                                    <div class="ui-select-container select2 select2-container">
                                        <label for="wards">Ward</label>
                                        <select class="select-location" name="wards" id="wards">
                                            <option value="" selected >All</option>
                                            <option ng-repeat="ward in allWards" value="<% ward.id %>" ng-model="ward"
                                                    ng-selected="<% ward.id == '{{ Request::get('ward') }}' %>" ><% ward.type %> <% ward.name %></option>
                                        </select>
                                    </div>
                                    <div class="ui-select-box has-button">
                                        <a class="md-btn md-btn--primary go-btn pull-right" href="" style="margin-top: 10px;border-radius: 5px;" onclick="goLocations()">Go</a>
                                    </div>
                                </div>

                            </div>

                            <!-- widget -->
                            <div class="widget">
                                <!-- <div class="widget__content"> -->
                                <h2 class="widget__title text-active">Filter
                                    <span class="widget-filter__toggle" id="filterAll">+</span>
                                </h2>

                                <div class="widget__content">

                                    <!-- widget-filter -->
                                    <div class="widget-filter">
                                        <div class="widget-filter__item">
                                            <h3 class="widget-filter__title" ng-click="openItem($event)">
                                                Cusine<span class="widget-filter__toggle"></span>
                                            </h3>
                                            <ul class="widget-filter__list cuisine-list" ng-class="{'half': filter.half}">
                                                <li class="col-md-6">
                                                    <!-- checkbox -->
                                                    <div class="checkbox custom-checkbox-02">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" value="1" checked="checked" ng-click="checkAll($event);">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description"
                                                                  value="all">All</span>
                                                        </label>
                                                    </div>
                                                    <!-- End / checkbox -->
                                                </li>
                                                <li class="col-md-6" ng-repeat="cuisine in cuisines">
                                                    <!-- checkbox -->
                                                    <div class="checkbox custom-checkbox-02">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" value="0" ng-click="checkOne($event);">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description"
                                                                  value="<% cuisine.id %>"><% cuisine.name %></span>
                                                        </label>
                                                    </div>
                                                    <!-- End / checkbox -->
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="widget-filter__item">
                                            <h3 class="widget-filter__title" ng-click="openItem($event)">
                                                Category<span class="widget-filter__toggle"></span>
                                            </h3>
                                            <ul class="widget-filter__list category-list" ng-class="{'half': filter.half}">
                                                <li>
                                                    <!-- checkbox -->
                                                    <div class="checkbox custom-checkbox-02">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" value="1" checked="checked" ng-click="checkAll($event);">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description"
                                                                  value="all">All</span>
                                                        </label>
                                                    </div>
                                                    <!-- End / checkbox -->
                                                </li>
                                                <li ng-repeat="category in categories">
                                                    <!-- checkbox -->
                                                    <div class="checkbox custom-checkbox-02">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" value="0" ng-click="checkOne($event);">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description"
                                                                  value="<% category.id %>"><% category.name %></span>
                                                        </label>
                                                    </div>
                                                    <!-- End / checkbox -->
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="widget-filter__item">
                                            <h3 class="widget-filter__title" ng-click="openItem($event)">
                                                Status<span class="widget-filter__toggle"></span>
                                            </h3>
                                            <ul class="widget-filter__list status-list" ng-class="{'half': filter.half}">
                                                @foreach (\App\Models\Restaurant::STATUSES_FILTER as $key=>$value )
                                                    <li class="col-md-6">
                                                        <!-- checkbox -->
                                                        <div class="checkbox custom-checkbox-02">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" value="1" checked="checked" ng-click="checkOne($event);">
                                                                <span class="custom-control-indicator"></span>
                                                                <span class="custom-control-description"
                                                                      value="{{ $value }}">{{  ucfirst(strtolower($key)) }}</span>
                                                            </label>
                                                        </div>
                                                        <!-- End / checkbox -->
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="widget-filter__item">
                                            <h3 class="widget-filter__title" ng-click="openItem($event)">
                                                Service<span class="widget-filter__toggle"></span>
                                            </h3>
                                            <ul class="widget-filter__list service-list" ng-class="{'half': filter.half}">
                                                @foreach (\App\Models\Restaurant::SERVICES_FILTER as $key=>$serviceFilter )
                                                    <li class="col-md-6">
                                                        <!-- checkbox -->
                                                        <div class="checkbox custom-checkbox-02">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" value="1" checked="checked" ng-click="checkOne($event);">
                                                                <span class="custom-control-indicator"></span>
                                                                <span class="custom-control-description"
                                                                      value="{{ $key }}">{{  $serviceFilter }}</span>
                                                            </label>
                                                        </div>
                                                        <!-- End / checkbox -->
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="widget-filter__item">
                                            <h3 class="widget-filter__title" ng-click="openItem($event)">
                                                Payment<span class="widget-filter__toggle"></span>
                                            </h3>
                                            <ul class="widget-filter__list payment-method-list">
                                                @foreach (\App\Models\Restaurant::PAYMENTS_FILTER as $key=>$paymentFilter )
                                                    <li>
                                                        <!-- checkbox -->
                                                        <div class="checkbox custom-checkbox-02">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" value="1" checked="checked" ng-click="checkOne($event);">
                                                                <span class="custom-control-indicator"></span>
                                                                <span class="custom-control-description"
                                                                      value="{{ $key }}">{{  $paymentFilter }}</span>
                                                            </label>
                                                        </div>
                                                        <!-- End / checkbox -->
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- End / widget-filter -->
                                </div>
                            </div><!-- End / widget -->
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="main-content">

                            <!-- sortbox -->
                            <div class="sortbox">
                                <div class="sortbox__left">
                                    <p class="sortbox__text" ng-if="restaurants"><span class="filter-number"><% amountResWork %>  Restaurants</span> ready to serve you now</p>
                                </div>
                                <div class="sortbox__right">
                                    <span class="text font-bold">Sort By: </span>
                                    <div class="sortbox-element">
                                        <select class="form-control select-sort" ng-model="selectedKeySort" ng-change="sortRestaurantList()">
                                            <option value="" label="Sort by">Sort by</option>
                                            <option value="ranking" label="Ranking">Ranking</option>
                                            <option value="min_order_amount" label="Min. order amount">Min. order
                                                amount
                                            </option>
                                            <option value="max_delivery_cost" label="Delivery fee">Delivery fee</option>
                                            <option value="name" label="Name" selected="selected">Name</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!-- End / sortbox -->

                            <div class="row restaurant-list loaded">
                                <div class="col-sm-6 col-md-6 col-lg-12" data-restaurant-id="<% restaurant.id %>" ng-repeat="restaurant in restaurants">
                                    <div class="listing-02">
                                        <div class="listing-02__media">
                                            <a ng-href="/restaurants/<%restaurant.slug%>?district={{$district->slug}}&ward=<% restaurant.restaurant_delivery_setting[0].ward_id %>">
                                                <img ng-src="<% restaurant.image ? restaurant.image_url : RESTATURANT_DEFAULT_IMAGE %>">
                                            </a>
                                            <a class="md-btn md-btn--primary md-btn--sm" ng-href="/restaurants/<%restaurant.slug%>?district={{$district->slug}}&ward=<% restaurant.restaurant_delivery_setting[0].ward_id %>">view menu</a>

                                            <span ng-if="restaurant.promotion_count > 0" class="listing-02__label ng-binding ng-scope"
                                                  ng-class="{'info': restaurant.promotion_count}">promotion
                                            </span>

                                            <span ng-if="restaurant.promotion_count == 0 && restaurant.status !=='no status'" class="listing-02__label ng-binding ng-scope" ng-class="{'success': restaurant.status == 'popular',
                                                'warning': restaurant.status === 'high quality',
                                                'error': restaurant.status === 'new',
                                                'info': restaurant.status === 'promotion'}"><% restaurant.status %>
                                            </span>
                                        </div>
                                        <div class="listing-02__body">
                                            <h2 class="listing-02__name">
                                                <a class="ng-binding" ng-href="/restaurants/<%restaurant.slug%>?district={{$district->slug}}&ward={{ Request::get('ward') }}"><% restaurant.name %></a>
                                                {{--<span class="btn-like" ng-click="favorite = !favorite"><i class="fa fa-heart-o" ng-class="{'fa-heart': favorite,'fa-heart-o': !favorite}"></i></span>--}}
                                            </h2>
                                            <p class="listing-02__text"><% restaurant.title_brief %></p>
                                            <ul class="listing-02__list">
                                                <li>
                                                    <span ng-if="restaurant.is_open_now == true" class="text-success ng-scope">Open Now</span>
                                                    <span ng-if="restaurant.is_open_now == false" style="color: red">Closed</span>
                                                </li>
                                                <li>
                                                    <span class="ng-binding"><i class="fa fa-motorcycle"></i><% restaurant.restaurant_delivery_setting[0].delivery_cost.formatCurrency() %></span>
                                                </li>
                                                <li>
                                                    <span class="ng-binding"><i class="fa fa-map-marker"></i><% restaurant.restaurant_delivery_setting[0].district_name %></span>
                                                </li>
                                                <li>
                                                    <span class="ng-binding"><i class="fa fa-cart-plus"></i>Min: <% restaurant.restaurant_delivery_setting[0].min_order_amount.formatCurrency() %></span>
                                                </li>
                                                <li ng-class="{'disable': !restaurant.pickup}">
                                                    <span class="ng-binding"><i class="fa fa-check-square-o"></i>Pick Up</span>
                                                </li>
                                                <li ng-class="{'disable': !restaurant.online_payment}">
                                                    <span class="ng-binding"><i class="fa fa-check-square-o"></i>Online Payment</span>
                                                </li>
                                                <li ng-class="{'disable': !restaurant.delivery}">
                                                    <span class="ng-binding"><i class="fa fa-check-square-o"></i>Delivery</span>
                                                </li>
                                                <li ng-class="{'disable': !restaurant.cod_payment}">
                                                    <span class="ng-binding"><i class="fa fa-check-square-o"></i>COD</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="listing-02__footer">
                                            <div class="rating">
                                                <span class="rating__point ng-binding"><% restaurant.review.star %></span>
                                                <div class="rating__rating ng-isolate-scope" title="<% restaurant.review.star %>" count="<% restaurant.review.star %>">
                                                    <span class="rating__icon" ng-style="{'width': (restaurant.review.star * 10) + '%'}" style="width: 30%;"></span>
                                                </div>
                                            </div>
                                            <span class="listing-02__show_rating">
                                                <a class="ng-binding" ng-href="">(<% restaurant.review.count_review %>  review) </a>
                                            </span>
                                            <a class="md-btn md-btn--primary md-btn--sm" ng-href="/restaurants/<%restaurant.slug%>">view menu</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-12 text-center" id="data-loading">
                                  <i class="fa fa-spinner fa-spin" style="color:black;font-size:100px;"></i>
                                </div>
                            </div>

                            <!-- <div class="md-text-center">
                                <button class="md-btn md-btn--danger md-btn--sm md-btn--outline-danger"
                                        style="min-width:150px;"
                                        ng-click="getMoreResList()">
                                    load more
                                </button>
                            </div> -->
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- End / Section -->

        <section class="md-section">
            <div class="container">
                <div class="row sticky-wrap">
                    <ui-view class="ng-scope">

                    </ui-view>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('extra_scripts')

    <script src="/b2c-assets/js/locations/show.js"></script>

    <script>
        setTimeout(function() {
            // get angular scope
            $scope = angular.element('[ng-controller=LocationShowCtrl]').scope();

            // init angular variables
            $scope.allDistricts = @json($allDistricts);
            $scope.district = @json($district);
            $scope.allWards = @json($allWards);
            $scope.cuisines = @json($cuisines);
            $scope.categories = @json($categories);
            $scope.slug = '{!! $slug !!}';
            $scope.LIMIT_SEARCH_ITEMS = '{!! env('LIMIT_SEARCH_ITEMS') !!}';
            $scope.RESTATURANT_DEFAULT_IMAGE = '{!! url(config('constants.DEFAULT.RESTAURANT_IMAGE')) !!}';
            $scope.segIdx = 0;
            $scope.direction = 'asc';
            $scope.wardSelected = {{ (Request::get('ward')) ? Request::get('ward') : "0" }};
            $scope.selectedKeySort = 'name';
            $scope.searchKey = '';

            // init page
            $scope.init();

            if($(window).width() < 1200) {
                $('.md-section.search').hide();
                $('.widget-filter__toggle').trigger('click');
            }
        }, 200)


    </script>

    <script>
        $('.header-toggle-search').click(function() {
            if($('.md-section.search').css('display') == 'block')
                $('.md-section.search').hide();
            else $('.md-section.search').show();
        });

         $('#filterAll').click(function() {
            if($('.widget__content').css('display') == 'block')
            {
                $('.widget__content').hide();
                $('#filterAll').text('+');
            }
            else
            {
                $('.widget__content').show();
                $('#filterAll').text('-');
            }
        });

        $( window ).resize(function() {
            setTimeout(function(){
                if ($(window).width() < 1200) {
                    $('.md-section.search').hide();
                    $('.widget-filter__toggle').each(function(){
                        // if($(this).text() == '-') {
                        //     $('.widget-filter__toggle').trigger('click');
                        // }
                    });
                }
                else {
                    $('.md-section.search').show();
                    $('.widget-filter__toggle').each(function(){
                        if($(this).text() == '+')
                            $('.widget-filter__toggle').trigger('click');
                    });
                }
            }, 500);
        });

    </script>

    <script>
        $(document).ready(function () {
          $('body,html').animate({
              scrollTop: 0
          }, 800);
            $('#state').on('change',function () {
                $.blockUI({
                    css: {
                        border: 'none',
                        backgroundColor: '#ff002a',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .8,
                        color: '#fff4f6'
                    },
                    message: `<p>Please wait...</p>`
                });
                $.ajax({
                    url: '/get-wards?slug='+$(this).val(),
                    type: 'get',
                    success: function (data) {
                        appendWards(data);
                        $.unblockUI();
                    }
                });
            });
        });
        function appendWards(wards) {
            $('#wards').html(`<option value="" selected >All</option>`);
            $.each(wards,function () {
                $('#wards').append(`<option value="${this.id}">${this.type} ${this.name}</option>`);
            });
        }
    </script>

@endsection
