@extends('layouts.app')
@section('content')

    <div class="md-content res-info restaurant" ng-controller="RestaurantPromotionCtrl">

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

                               <!-- promotions -->
                                <div class="promotions">
                                    <ul class="promotions__list">
                                        <li ng-repeat="promotion in restaurant.promotions" >
                                             <a href="javascript:void(0)">
                                                <h3 class="promotions__title"><% promotion.name %></h3>
                                                <p class="promotions__text"><% promotion.description %></p></a>

                                        </li>

                                    </ul>
                                </div><!-- End / promotions -->


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
    <script src="/b2c-assets/js/restaurants/promotion.js"></script>

    <script>
        setTimeout(function() {
            $scope = angular.element('[ng-controller=RestaurantPromotionCtrl]').scope();
            $scope.restaurant = {!! $restaurant !!};
            $scope.categories = {!! $categories !!};
            $scope.cart = {!! $cart !!};
            $scope.orderServices = {!! $orderServices !!};
            $scope.orderPayments = {!! $orderPayments !!};
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

@endsection
