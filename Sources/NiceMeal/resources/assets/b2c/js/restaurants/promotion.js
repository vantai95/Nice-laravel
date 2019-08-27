app.controller('RestaurantPromotionCtrl', function($scope, $http, $timeout, $interval, cart) {
    $scope.init = function() {
        $timeout(function() {
            $scope.currCate = $scope.categories[0];
            angular.element('.md-content').removeClass('hidden');
            angular.element('.select2').select2();
        });       
        
        $scope.selectedMenuNav = 'promotion';
        /**
         * cart function must implement if user UI have cart
         */
        $scope.saveCart = function() {
            var data = {
                'delivery_fee': $scope.cart.delivery_fee,
                'payment': $scope.cart.payment,
                'service': $scope.cart.service,
                'order_note': $scope.cart.order_note,
                'sub_total': $scope.cart.sub_total,
                'order_total': $scope.cart.order_total,
                '_token': angular.element('meta[name=csrf-token]').attr('content')
            };
            cart.saveCart(data).then(function(returndata) {
                $scope.cart = returndata;
            })
        }

        $scope.addToCart = function() {
            var item = {
                'restaurant': $scope.restaurant.slug,
                'dish': $scope.selectedDish,
                'quantity': 1,
                'custom': $scope.formData.custom,
                'option': $scope.formData.option,
                'option_quantity': $scope.formData.option_quantity
            };

            cart.addToCart(item).then(function(data) {
                $scope.cart = data;
                angular.element('#detailModal').modal("hide");
            });

        }

        $scope.subtractFromCart = function(index) {
            cart.subtractFromCart(index).then(function(data) {
                $scope.cart = data;
            });
        }

        $scope.calculateDish = function(index) {
            return cart.calculateDish($scope.cart.items[index]);
        }

        $scope.dishAmountChange = function(quantity, index) {
            cart.dishAmountChange(quantity, index).then(function(data) {
                $scope.cart = data;
            })
        }

        $scope.selectPayment = function(paymentKey) {
            $scope.cart.payment = paymentKey;
            $scope.saveCart();
        }

        $scope.checkPayment = function(paymentKey) {
            if ($scope.cart.payment == paymentKey) {

                return 1;
            }
            return 0;

        }

        $scope.selectService = function(serviceKey, fee) {
            $scope.selectedOrderService = serviceKey;
            $scope.cart.service = serviceKey;
            if (serviceKey == 'delivery') {
                $scope.cart.delivery_fee = $scope.restaurant.deliveryCost;

            } else {
                $scope.cart.delivery_fee = 0;
            }
            $scope.saveCart();

        }

        $scope.checkService = function(serviceKey) {
            if ($scope.cart.service == serviceKey) {
                return 1;
            }
            return 0;
        }
        /**
         * end cart function
         */

    };
});
app.filter('timeFilter',function(){
    return function(time){
        return time.split(":")[0] + ':' + time.split(":")[1];
    };
});