@extends('layouts.app')
@section('content')

    <div class="md-content restaurant hidden" ng-controller="OrderHistoryCtrl">

    @include('user.social-tools')

    <!-- hero -->
        <section class="hero" style="background-image: url('https://i.imgur.com/n1shiqq.jpg')">
            <div class="info-text">Order History</div>
        </section>
        <!-- End / hero -->


        <!-- Section -->
        <div class="container">
            <div class="row user__info">
                <ui-view>
                    @include('user.order_histories.user_order_history')
                </ui-view>
            </div>
        </div>

    @include('user.order_histories.order_detail_modal')


    <!-- End / Section -->
    </div>

@endsection

@section('extra_scripts')
    <script src="/b2c-assets/js/cart/cart.js"></script>
    <script src="/b2c-assets/js/users/order_history.js"></script>

    <script>
        setTimeout(function () {
            $scope = angular.element('[ng-controller=OrderHistoryCtrl]').scope();
            $scope.selectedOrder = [];
            $scope.user = {!! $user !!};
            $scope.ordersHistory = {!! $ordersHistory !!};
            $scope.services = {!! $services !!};
            $scope.payments = {!! $payments !!};
            $scope.order_status = {!! $order_status !!};

            $scope.init();

            $('.widget-categories.hidden').removeClass('hidden');
            $('.category-wrapper.hidden').removeClass('hidden');
        }, 200)
    </script>

@endsection
