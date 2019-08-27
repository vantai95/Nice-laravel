app.controller('CartCtrl', function ($scope, $http) {
    $scope.togglePromotion = function () {
        angular.element("#promotion-form").css("top", "205px");
        angular.element("#promotion-overlay").css("top", "0");
    };

    $scope.cancelInputPromotion = function () {
        angular.element("#promotion-form").css("top", "1000px");
        angular.element("#promotion-overlay").css("top", "1000px");
    };

    $scope.init = function () {
        $scope.$apply();

    }

    $scope.toggleVAT = function () {
        angular.element('div.toggle').addClass('not-allow-click');
        angular.element('div.toggle').toggleClass('checked');
        setTimeout(function () {
            angular.element('div.toggle').removeClass('not-allow-click');
        },800);
        if(angular.element('div.toggle').hasClass('checked')){
            $scope.cart.checkbill = 1;
        }else{
            $scope.cart.checkbill = 0;
        }
        $scope.saveCart();
    }

    $scope.initCart = function (restaurant = undefined) {
        if (restaurant === undefined) {
            var data = {
                '_token': angular.element('meta[name=csrf-token]').attr('content')
            };
        } else {
            var infoToGetCart = {
                'id': restaurant.id,
                'restaurant_slug': restaurant.restaurant_slug,
                'name': restaurant.name,
                'delivery': restaurant.delivery,
                'pickup': restaurant.pickup,
                'cod_payment': restaurant.cod_payment,
                'online_payment': restaurant.online_payment,
                'district_id': restaurant.district_id,
                'min_order_amount': restaurant.minOrderAmount
            }
            if (restaurant.ward_delivery !== null) {
                infoToGetCart.ward_id = restaurant.ward_delivery;
            }
            var data = {
                '_token': angular.element('meta[name=csrf-token]').attr('content'),
                'restaurant': infoToGetCart
            };
        }
        $http({
            method: "post",
            url: "/restaurants/getCart",
            data: data
        }).then(function success(response) {
            $scope.cart = response.data;
            $scope.cart.items = Object.values($scope.cart.items).filter(function (item) {
                return item.free_item == 0;
            });
            if ($scope.getFreeItemPromotions()) $scope.cart.free_item_promotions = $scope.getFreeItemPromotions().sort(sortObjects('apply_to'));
        });
    }

    $scope.getFreeItemPromotions = function () {
        if ($scope.cart.promotions) {
            return Object.values($scope.cart.promotions).filter(function (promotion) {
                return promotion.free_item != null;
            })
        }
    }

    $scope.itemTotalCalculate = function (item) {
        var total = 0;
        if (item !== undefined) {
            total += item.price;
            item.options.forEach(function (option) {
                total += option.price * option.quantity;
            });
            total *= item.quantity;
        }
        return total.formatCurrency();
    }

    $scope.subtractFromCart = function (index) {
        return $http({
            method: "POST",
            url: "/cart/subtractFromCart/" + index,
            data: {'_token': angular.element('meta[name=csrf-token]').attr('content')}
        }).then(function success(response) {
            $scope.cart = response.data.data;
        });
    }

    $scope.saveCart = function () {
        var data = {
            'cart': $scope.cart,
            '_token': angular.element('meta[name=csrf-token]').attr('content')
        };
        return $http({
            method: "POST",
            url: "/cart/saveCart",
            data: data
        }).then(function success(response) {
            $scope.cart = response.data.data;
        });
    }

    $scope.dishAmountChange = function (quantity, index) {
        return $http({
            method: "POST",
            url: "/cart/dishAmountChange/" + index,
            data: {
                'quantity': quantity,
                '_token': angular.element('meta[name=csrf-token]').attr('content')
            }
        }).then(function success(response) {
            $scope.cart = response.data.data;
            $scope.cart.total_item = $scope.calAmountItem();
            if ($scope.getFreeItemPromotions()) $scope.cart.free_item_promotions = $scope.getFreeItemPromotions().sort(sortObjects('apply_to'));
        });
    }

    $scope.calAmountItem = function () {
        var amount = 0;
        angular.forEach($scope.getValidItems(), function (item) {
            amount += item.quantity;
        });
        return amount;
    }

    $scope.getValidItems = function () {
        return Object.values($scope.cart.items).filter(function (item) {
            return item.id != null;
        })
    }

    $scope.applySynchronizeData = function (cart, list_dishes, apply_type) {
        var new_cart = cart;
        angular.forEach(cart.items, function (item, key) {
            if (list_dishes[item.id]) {
                if (apply_type == "change") {
                    new_cart.items[key].price = list_dishes[item.id].price;
                } else if (apply_type == "disappear") {
                    new_cart.items.splice(key, 1);
                }
            }
        });
        return $scope.saveCart(new_cart);
    }

    $scope.saveCart = function () {
        var data = {
            'cart': $scope.cart,
            '_token': angular.element('meta[name=csrf-token]').attr('content')
        };
        $http({
            method: "POST",
            url: "/cart/saveCart",
            data: data
        }).then(function success(response) {
            $scope.cart = response.data.data;
        });
    }

    $scope.proceedToCheckout = function () {
        var ward_delivery = $restaurantDetailScope.restaurant.ward_delivery ? '&ward=' + $restaurantDetailScope.restaurant.ward_delivery : '';
        // redirect to checkout page
        window.location = '/checkout?district=' + $restaurantDetailScope.restaurant.district_slug + ward_delivery;
    }

    $scope.orderNow = function () {
        $checkoutScope.orderNow();
    }

})
