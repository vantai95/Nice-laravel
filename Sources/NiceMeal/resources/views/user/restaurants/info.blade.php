@extends('layouts.app')
@section('content')

    <div class="md-content res-info restaurant" ng-controller="RestaurantInfoCtrl">

    @include('user.social-tools')

    <!-- hero -->

    @include('user.restaurants.partial.header')
        <!-- End / hero -->


        <!-- Section -->
        <section class="md-section">
            <div class="container">
                <div class="row sticky-wrap">
                    <ui-view>
                        <div class="col-lg-3 sticky">
                            <div class="sidebar-left">
                                <!-- widget -->
                                @include('user.restaurants.partial.left_menu')
                                <!-- End / widget -->

                            </div>
                        </div>

                        <div class="col-lg-9">
                            <div class="main-content">

                                <!-- nav-menu -->
                                @include('user.restaurants.partial.tabs')
                                <!-- End / nav-menu -->

                                <div class="row">
                                    <div class="col-lg-6 ">

                                        <!-- title -->
                                        <div class="title">
                                            <h2 class="title__title">Working time:</h2>
                                        </div><!-- End / title -->


                                        <!-- work-time -->
                                        <ul class="work-time">
                                          <li ng-repeat="working_time in restaurant.restaurant_work_times">
                                            <div class="row" ng-if="working_time.time_setting.period_type == 0">
                                              <div class="col-lg-6" ng-if="working_time.time_setting.all_days">
                                                All days
                                              </div>
                                              <div style="word-wrap: break-word;" class="col-lg-6" ng-if="!working_time.time_setting.all_days">
                                                  <span style="float:left;margin-left:5px" ng-repeat="date in dateInWeek" ng-if="working_time.time_setting[date]">
                                                    <% dateName[date] %>,
                                                  </span>
                                              </div>
                                              <div class="col-lg-6" ng-if="working_time.time_setting.all_times">
                                                <div>All Times</div>
                                              </div>

                                              <div class="col-lg-6" ng-if="!working_time.time_setting.all_times">
                                                <div ng-repeat="detail in working_time.time_setting.time_setting_details"><% detail.from_time + ' - ' + detail.to_time %></div>
                                              </div>
                                            </div>

                                            <div class="row" ng-if="working_time.time_setting.period_type != 0">
                                              <div class="col-lg-6">
                                                <% working_time.time_setting.from_date %>
                                              </div>
                                              <div class="col-lg-6" ng-if="working_time.time_setting.time_setting_details.length == 0">
                                                <div>All Times</div>
                                              </div>

                                              <div class="col-lg-6" ng-if="working_time.time_setting.time_setting_details.length > 0">
                                                <div ng-repeat="detail in working_time.time_setting.time_setting_details"><% detail.from_time + ' - ' + detail.to_time %></div>
                                              </div>
                                            </div>
                                          </li>
                                        </ul><!-- End / work-time -->

                                    </div>
                                    <div class="col-lg-5 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-1 ">

                                        <!-- infostore -->
                                        <div class="infostore">
                                            <div class="infostore__item">

                                                <!-- title -->
                                                <div class="title">
                                                    <h2 class="title__title">Payment method:</h2>
                                                </div><!-- End / title -->

                                                <div class="infostore__text">
                                                    <div class="checkbox" ng-class="{'checkbox-success': restaurant.cod_payment}">
                                                        <label class="custom-control custom-checkbox">
                                                            <i class="fa ng-scope"
                                                            ng-class="{'fa-circle-o': !restaurant.cod_payment,'fa-check-circle checkbox-color': restaurant.cod_payment}"></i>
                                                            <span class="custom-control-description">COD</span>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox" ng-class="{'checkbox-success': restaurant.online_payment}">
                                                        <label class="custom-control custom-checkbox">
                                                            <i class="fa ng-scope"
                                                            ng-class="{'fa-circle-o': !restaurant.online_payment,'fa-check-circle checkbox-color': restaurant.online_payment}"></i>
                                                            <span class="custom-control-description">Online Payment</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="infostore__item">

                                                <!-- title -->
                                                <div class="title">
                                                    <h2 class="title__title">Available services:</h2>
                                                </div><!-- End / title -->

                                                <div class="infostore__text">
                                                    <div class="checkbox" ng-class="{'checkbox-success': restaurant.delivery}">
                                                        <label class="custom-control custom-checkbox">
                                                            <i class="fa ng-scope"
                                                            ng-class="{'fa-circle-o': !restaurant.delivery,'fa-check-circle checkbox-color': restaurant.delivery}"></i>
                                                            <span class="custom-control-description">Delivery</span>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox" ng-class="{'checkbox-success': restaurant.pickup}">
                                                        <label class="custom-control custom-checkbox">
                                                            <i class="fa ng-scope"
                                                            ng-class="{'fa-circle-o': !restaurant.pickup,'fa-check-circle checkbox-color': restaurant.pickup}"></i>
                                                            <span class="custom-control-description">Pick up</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="infostore__item">

                                                <!-- title -->
                                                <div class="title">
                                                    <h2 class="title__title">Restaurant address:</h2>
                                                </div><!-- End / title -->

                                                <div class="infostore__text">
                                                    <p><i class="fa fa-map-marker"></i>
                                                        <span><% restaurant.address %></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div><!-- End / infostore -->

                                    </div>
                                </div>
                                <hr>

                                <!-- title -->
                                <div class="title">
                                    <h2 class="title__title">Available locations that can be delivered:</h2>
                                </div><!-- End / title -->

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="ui-select-box" style="margin-bottom: 20px;">

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 ">
                                        <!-- location -->
                                        <table class="location">
                                            <colgroup>
                                                <col/>
                                                <col/>
                                                <col/>
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <td>
                                                    <h6 class="location__title">Location</h6>
                                                </td>
                                                <td>
                                                    <h6 class="location__title">Minimum</h6>
                                                </td>
                                                <td>
                                                    <h6 class="location__title">Delivery fee</h6>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="deliverySetting in restaurant.restaurant_delivery_setting">
                                                <td><% deliverySetting.district_name %></td>
                                                <td><% deliverySetting.min_order_amount.formatCurrency() %></td>
                                                <td><% deliverySetting.delivery_cost.formatCurrency() %></td>
                                            </tr>
                                            </tbody>
                                        </table><!-- End / location -->

                                    </div>
                                </div>
                            </div>
                        </div>


                    </ui-view>
                </div>
            </div>
        </section>
        @include('user.restaurants.cartmodal')
        <!-- End / Section -->
    </div>

@endsection

@section('extra_scripts')
    <script src="/b2c-assets/js/cart/cart.js"></script>
    <script src="/b2c-assets/js/restaurants/info.js"></script>

    <script>
        setTimeout(function() {
            $scope = angular.element('[ng-controller=RestaurantInfoCtrl]').scope();
            $scope.restaurant = {!! $restaurant !!};
            $scope.categories = {!! $categories !!};
            $scope.dateInWeek = {!! $dateInWeek !!};
            $scope.cart = {!! $cart !!};
            $scope.orderServices = {!! $orderServices !!};
            $scope.orderPayments = {!! $orderPayments !!};
            $scope.dateName = {
              "sun" : "Sunday",
              "mon" : "Monday",
              "tue" : "Tuesday",
              "wed" : "Wednesday",
              "thu" : "Thursday",
              "fri" : "Friday",
              "sat" : "Saturday",
            };
            $scope.init();

            $('.widget-categories.hidden').removeClass('hidden');
            $('.category-wrapper.hidden').removeClass('hidden');

            var iScrollPos = 0;
            window.addEventListener("scroll",function(){
                var iCurScrollPos = $(this).scrollTop();
                if (iCurScrollPos > iScrollPos) {
                    // Scrolling Down
                    if(window.pageYOffset >= 550)
                        $('.hero__menu').css({"position": "fixed", "top": 0, "bottom": "unset", "background-color": "rgba(0, 0, 0, 0.7)", "z-index": "10"});
                } else {
                    // Scrolling Up
                    if(window.pageYOffset < 550)
                        $('.hero__menu').css({"position": "absolute", "top": "unset", "bottom": 0, "background-color": "rgba(38, 38, 38, 0.5)", "z-index": "10"});
                }
                iScrollPos = iCurScrollPos;
            });
        }, 200)
    </script>

    {{--<script>--}}
        {{--function doLike(element){--}}
            {{--if($(element).has('.fa-heart').length != 0){--}}
                {{--$(element).html('<i class="fa fa-heart-o"></i>');--}}

            {{--}else{--}}
                {{--$(element).html('<i class="fa fa-heart"></i>');--}}
            {{--}--}}
        {{--}--}}

        {{--function openItem(element) {--}}
            {{--var list = $(element).parent('.widget-filter__item').children('.widget-filter__list');--}}
            {{--var toggle = $(element).children('.widget-filter__toggle');--}}
            {{--if ($(list).is(":visible")) {--}}
                {{--$(toggle).html('+');--}}
                {{--$(list).slideUp('slow', function () {--}}
                    {{--$(list).hide();--}}
                {{--});--}}
            {{--} else {--}}
                {{--$(toggle).html('-');--}}
                {{--$(list).slideDown('fast', function () {--}}
                    {{--$(list).show();--}}
                {{--});--}}
            {{--}--}}
        {{--}--}}

    {{--</script>--}}

@endsection
