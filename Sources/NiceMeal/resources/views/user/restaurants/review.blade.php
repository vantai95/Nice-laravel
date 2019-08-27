@extends('layouts.app')

@section('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endsection

@section('content')
    <div class="md-content res-info restaurant" ng-controller="ReviewCtrl">

        @include('user.social-tools')

        <!-- hero -->
        @include('user.restaurants.partial.header')
        <!-- #hero -->

        <!-- Section -->
        <section class="md-section">
            <div class="container">
                <div class="row main-sticky">
                    <div class="col-lg-3 sticky">
                        <div class="sidebar-left">
                            <!-- widget -->
                            @include('user.restaurants.partial.left_menu')
                            <!-- End / widget -->

                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="main-content">
                            @include('user.restaurants.partial.tabs')
                            <!-- commentbox -->
                            <div class="commentbox">
                                @if($showCountDown)
                                    <div class="comment-header">
                                        <p>Your review will avaiable after
                                        <% counter | secondsToDateTime | date:'HH:mm:ss' %></p>
                                    </div>
                                @endif
                                @if(!empty($token) && !$showCountDown && !$expired)
                                <form ng-submit="finishReview()" id="checkoutForm" name="checkoutForm" class="ng-dirty ng-valid-parse ng-invalid ng-invalid-required ng-valid-email ng-valid-min">
                                <div class="comment-header">
                                    <p>Welcome to send your review  for restaurant:</p>
                                    <div class="comment_container">
                                        <div class="comment-avatar">
                                            <a href="#">
                                                <img class="avatar" src="{{ url('common-assets/img/profile.jpg') }}" alt=""/>
                                            </a>
                                        </div>
                                        <div class="comment-text">
                                            <div class="comment-meta">
                                                <span class="author">{{ $reviewer->full_name ?? '' }}</span>
                                                <span class="date">{{ $today}}</span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="comment-star" style="float: left">
                                                <div class="comment-star-item">
                                                    <span>Food:</span>
                                                    <div class="rating">
                                                        <div id="rateFood"></div>
                                                    </div>
                                                    <span style="margin-left: 30px;">Service:</span>
                                                    <div class="rating">
                                                        <div id="rateService"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="comment-description">
                                                <textarea name="comment" id="comment" class="form-control" cols="30" rows="3" autofocus></textarea>
                                            </div>
                                            <input type="hidden" name="token" id="token" value="{{ $token }}" />
                                            <div class="comment-footer" style="float: right">
                                                <button type="submit" class="md-btn md-btn--primary md-btn--sm">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                @endif
                                <div class="comment-header">
                                    <!-- rating -->
                                    <div class="rating">
                                        <span class="rating__point"></span>
                                        <div class="rating__rating" title="{{ $restaurant->star }}" count="{{ $restaurant->star }}">
                                            <span class="rating__icon" style="width: {{ $restaurant->star / 5 * 100 }}%;"></span>
                                        </div>
                                    </div><!-- End / rating -->
                                    <span>Average score {{ $restaurant->star }} star(s) in this week  </span>
                                </div>
                                <ol id="review-list" class="commentlist">
                                    @foreach($reviews as $review)
                                    <li class="comment">
                                        <div class="comment_container">
                                            <div class="comment-avatar">
                                                <a href="#">
                                                    <img class="avatar" src="{{ url('common-assets/img/profile.jpg') }}" alt=""/>
                                                </a>
                                            </div>
                                            <div class="comment-text">
                                                <div class="comment-meta">
                                                    <span class="author">{{ $review->full_name }}</span>
                                                    <span class="date">{{ date('d-m-Y h:i:s',$review->created_time) }}</span>
                                                </div>
                                                <div class="comment-star">
                                                    <div class="comment-star-item"><span>Food:</span>
                                                        <!-- rating -->
                                                        <div class="rating">
                                                            <div class="rating__rating" title="{{ $review->food_rate }}" count="{{ $review->food_rate }}">
                                                                <span  class="rating__icon" style="width: {{ round($review->food_rate / 5 * 100,0) }}%;"></span>
                                                            </div>
                                                        </div><!-- End / rating -->
                                                    </div>
                                                    <div class="comment-star-item"><span>Service:</span>
                                                        <!-- rating -->
                                                        <div class="rating">
                                                            <div class="rating__rating" title="{{ $review->service_rate }}" count="{{ $review->service_rate }}">
                                                                <span  class="rating__icon" style="width: {{ round($review->service_rate / 5 * 100,0) }}%;"></span>
                                                            </div>
                                                        </div><!-- End / rating -->
                                                    </div>
                                                </div>
                                                <div class="comment-description">
                                                    <p>{{ $review->comment }}</p>
                                                </div>
                                                <div class="comment-footer"><span class="comment-note"></span></div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ol>
                            </div><!-- End / commentbox -->
                            <div class="comment-footer" style="float: right;margin: 16px;">
                                <button id="btnReadMoreReview" class="btn btn-danger md-btn--danger">Read more</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End / Section -->

        @include('user.restaurants.cartmodal')
    </div>
@endsection
@section('extra_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        $(function () {
            $("#rateFood").rateYo({
                rating: 5,
                ratedFill: 'red',
                starWidth: '19px',
                normalFill: '#e2e2e2',
                fullStar: true
            });
            $("#rateService").rateYo({
                rating: 5,
                ratedFill: 'red',
                starWidth: '19px',
                normalFill: '#e2e2e2',
                fullStar: true
            });
        });
    </script>

    <script src="/b2c-assets/js/cart/cart.js"></script>
    <script src="/b2c-assets/js/restaurants/review.js"></script>

    <script>
        setTimeout(function() {

            $scope = angular.element('[ng-controller=ReviewCtrl]').scope();
            $scope.restaurant = {!! $restaurant !!};
            $scope.categories = {!! $categories !!};
            $scope.cart = {!! $cart !!};
            $scope.orderServices = {!! $orderServices !!};
            $scope.orderPayments = {!! $orderPayments !!};

            $scope.counter = {!! $counDownValue !!};
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

    <script>
        $(document).ready(function () {
            let offset = 0;
            const slug = '{{ $restaurant->restaurant_slug }}';
            const district_slug = '{{ request()->query("district") }}';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#btnReadMoreReview').click(function () {
                offset++;
                $('.md-section').css('opacity',0.3);
                $.ajax({
                    url: "{{ url('restaurants/'. $restaurant->restaurant_slug . '/reviews-paging') }}",
                    data: {
                        offset,
                        slug,
                        district_slug
                    },
                    method: 'post',
                    success: function(data) {
                        $('.md-section').css('opacity',1);
                        if(!data.error) {
                            if(data.data) {
                                $('#review-list').append(data.data);
                            } else {
                                $('#btnReadMoreReview').addClass('hidden');
                            }
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseText);
                        $('.md-section').css('opacity',1);
                    }
                });
            });
        });
    </script>


@endsection
