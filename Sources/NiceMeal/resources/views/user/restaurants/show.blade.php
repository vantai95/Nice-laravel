@extends('layouts.app')
@section('content')

    <div class="md-content restaurant hidden" ng-controller="RestaurantShowCtrl">

        @include('user.social-tools')

        <!-- hero -->
        @include('user.restaurants.partial.header')
        <!-- End / hero -->

        <!-- Section -->
        <section class="md-section">
            <div class="container">
                <div class="row sticky-wrap">
                    <ui-view>
                        @include('user.restaurants.detail')
                    </ui-view>
                </div>
            </div>
        </section>
        <!-- End / Section -->

        @include('user.restaurants.popup-add-to-cart')
        @include('user.restaurants.cartmodal')
        @include('user.restaurants.freeitemmodal')
        @include('user.restaurants.change')
    </div>

@endsection
@section('extra_scripts')
    <script src="/b2c-assets/js/cart/cart.js"></script>
    <script src="/b2c-assets/js/restaurants/show.js"></script>

    <script>
        $(function(){
          $scope = angular.element('[ng-controller=RestaurantShowCtrl]').scope();
          $scope.init(
                  @json($restaurant,JSON_PRETTY_PRINT),
                  @json($categories,JSON_PRETTY_PRINT),
                  @json($dish_customizations,JSON_PRETTY_PRINT),
                  @json($customizations,JSON_PRETTY_PRINT),
                  @json($cart,JSON_PRETTY_PRINT),
                  @json($orderPayments,JSON_PRETTY_PRINT),
                  @json($orderServices,JSON_PRETTY_PRINT)
          );

          // $('.widget-categories.hidden').removeClass('hidden');
          // $('.category-wrapper.hidden').('hidden');

          $('.back-to-top.click-to-top').remove();
          $('.md-content').removeClass('hidden');
          var iScrollPos = 0;
          window.addEventListener("scroll",function(){
              var iCurScrollPos = $(this).scrollTop();
              if (iCurScrollPos > iScrollPos) {
                  // Scrolling Down
                  if(window.pageYOffset >= 550)
                      $('.hero__menu').css({"position": "relative", "top": 0, "bottom": "unset", "background-color": "rgba(0, 0, 0, 0.7)", "z-index": "10"});
              } else {
                  // Scrolling Up
                  if(window.pageYOffset < 550)
                      $('.hero__menu').css({"position": "absolute", "top": "unset", "bottom": 0, "background-color": "rgba(38, 38, 38, 0.5)", "z-index": "10"});
              }
              iScrollPos = iCurScrollPos;
          });
        })

    </script>
    <script>
        function doLike(element){
            if($(element).has('.fa-heart').length != 0){
                $(element).html('<i class="fa fa-heart-o"></i>');

            }else{
                $(element).html('<i class="fa fa-heart"></i>');
            }
        }

        function openItem(element) {
            var list = $(element).parent('.widget-filter__item').children('.widget-filter__list');
            var toggle = $(element).children('.widget-filter__toggle');
            if ($(list).is(":visible")) {
                $(toggle).html('+');
                $(list).slideUp('slow', function () {
                    $(list).hide();
                });
            } else {
                $(toggle).html('-');
                $(list).slideDown('fast', function () {
                    $(list).show();
                });
            }
        }

        const PROMOTION_APPLY_TO = @json(\App\Models\Promotion::PROMOTION_APPLY_TO);
    </script>

@endsection
