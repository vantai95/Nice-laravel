app.controller('OrderHistoryCtrl', function($scope, $http, $timeout, $interval, cart) {
    $scope.init = function() {
        $timeout(function() {
            angular.element('.md-content').removeClass('hidden');
            $scope.menuStatus = false;
        }, 10);
    };

    $scope.formatDate = function(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) {
            month = '0' + month;
        }

        if (day.length < 2) {
            day = '0' + day;
        }

        return [day, month, year].join('/');
    };

    $scope.checkNegative = function(item_key) {
        if ($scope.selectedOrder.orderItem[item_key].quantity <= 0) {
            $scope.selectedOrder.orderItem[item_key].quantity = 1;
        }
    }

    $scope.getStatus = function(status) {
        return $scope.order_status[status].name;
    };

    $scope.formatPrice = function(price) {
        return Math.round(price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' VNĐ';
    };

    $scope.openOrderDetail = function(order_id) {
        $scope.selectedOrder = [];
        $scope.selectedOrder = angular.copy($scope.ordersHistory[order_id]);
    }

    $scope.reOrderThis = function() {
        var data = [];
        angular.forEach($scope.selectedOrder['order_items'], function(item) {
            var options = [];
            angular.forEach(item['order_items_customizations'], function(option) {
                input_option = {
                    'custom_name': option.custom_name,
                    'custom_id': option.customization_id,
                    'option_name': option.option_name,
                    'quantity': option.quantity,
                    'option_id': option.customization_option_id,
                    'price': option.price
                }
                options.push(input_option);
            })
            var dish = {
                'id': item.dish_id,
                "name": item.name,
                'price': item.price,
                'quantity': item.quantity,
                'options': options,
                'free_item': item.free_item
            };
            data.push(dish);
        });
        cart.reOrder($scope.selectedOrder, data).then(function(data) {
            if (!data.error) {
                window.location = `/restaurants/${$scope.selectedOrder.restaurant_slug}?district=${$scope.selectedOrder.district_slug}`;
            }
        });
    }

    $scope.totalPrice = function() {
        var total = 0;
        angular.forEach($scope.ordersHistory, function(orderHistory, key) {
            total = total + Math.round(orderHistory.total_amount);
        });
        return total;
    };

    $scope.selectService = function(service_key) {
        $scope.selectedOrder.orderInfo.order_type = service_key;
        if (service_key == "delivery") {
            $scope.selectedOrder.orderInfo.shipping_fee = $scope.selectedOrder.orderInfo.delivery_cost;
            $scope.selectedOrder.orderInfo.total_amount = $scope.selectedOrder.orderInfo.sub_total_amount + $scope.selectedOrder.orderInfo.delivery_cost;
        } else if (service_key == "pickup") {
            $scope.selectedOrder.orderInfo.shipping_fee = 0;
            $scope.selectedOrder.orderInfo.total_amount = $scope.selectedOrder.orderInfo.sub_total_amount;
        }

    }

    $scope.selectPayment = function(payment_key) {
        $scope.selectedOrder.orderInfo.payment_method = payment_key;
    }
});
app.filter('trustHtml', function($sce) {
    return function(html) {
        return $sce.trustAsHtml(html)
    }
});