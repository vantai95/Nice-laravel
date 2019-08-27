@extends('layouts.app')

@section('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endsection

@section('content')
    <div class="md-content res-info restaurant" ng-controller="ReviewInfoCtrl">

    @include('user.social-tools')

        <!-- hero -->
        <section class="hero" style="background-image: url('https://i.imgur.com/n1shiqq.jpg')">
            <div class="md-tb">
                <div class="md-tb__cell">
                    <div class="container">
                        <div class="container">
                            <div class="hero__page">
                                <div class="row">
                                    <div class="col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-3 ">
                                        <h1 class="hero__page_title">Review order</h1>
                                        <p class="hero__page_text">Order number #{{ $order->order_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- #hero -->

        <!-- Section -->
        <section class="md-section">
            <div class="container">
                <form ng-submit="finishReview()" id="checkoutForm" name="checkoutForm" class="ng-dirty ng-valid-parse ng-invalid ng-invalid-required ng-valid-email ng-valid-min">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="main-content">
                                <div class="form-wrap">
                                    <h3 class="form-wrap__title">Review</h3>
                                    <div class="form-wrap__inner">
                                        <!-- form-item -->
                                        <div class="form-item form-item--half">
                                            <label class="form__label">Food</label>
                                            <div id="rateFood"></div>
                                        </div>
                                        <!-- End / form-item -->


                                        <!-- form-item -->
                                        <div class="form-item form-item--half">
                                            <label class="form__label">Service</label>
                                            <div id="rateService"></div>
                                        </div>
                                        <!-- End / form-item -->

                                        <!-- form-item -->
                                        <div class="form-item">
                                            <label class="form__label">Comment</label>
                                            <input class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" type="text" name="comment" id="comment" placeholder="Enter your comment" >
                                        </div>
                                        <!-- End / form-item -->

                                        <div class="form-item pull-right">
                                            <button id="btnSubmit" class="md-btn md-btn--primary md-btn--sm">Submit</button>
                                        </div>

                                        <input type="hidden" name="token" id="token" value="{{ $token }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- End / Section -->

    </div>
@endsection

@section('extra_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        $(function () {
            $("#rateFood").rateYo({
                rating: 5,
                ratedFill: 'red'
            });
            $("#rateService").rateYo({
                rating: 5,
                ratedFill: 'red'
            });
        });
    </script>
    <script>
        app.controller('ReviewInfoCtrl', function ($scope, $http) {
            $scope.finishReview = function () {
                $('#btnSubmit').attr('disabled',true);
                var ratingFood = $("#rateFood").rateYo("option", "rating");
                var ratingService = $("#rateService").rateYo("option", "rating");
                var commentReview = $('#comment').val();
                var token = $('#token').val();

                $http({
                    method: 'post',
                    url: '/reviews/order/submit',
                    data: {
                        ratingFood,
                        ratingService,
                        commentReview,
                        token
                    }
                }).then(function(response) {
                    if(response.data.is_success) {
                        toastr.success('Thank you for your review');
                        window.location.href = '/';
                    }
                }).catch(function (error) {
                    $('#btnSubmit').removeAttr('disabled');
                });

            };
        });
    </script>
@endsection