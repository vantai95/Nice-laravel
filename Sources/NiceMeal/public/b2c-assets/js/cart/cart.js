/**
 * When use this service implement these function
 * -addToCart
 * -subtractFromCart
 * -calculateSubTotal
 * -dishAmountChange
 * -calculateDish
 * -saveCart
 */

app.service('cart', function($http) {

    this.addToCart = function(item) {

        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'item': item
        };
        return $http({
            method: "post",
            url: "/cart/addToCart",
            data: data
        }).then(function success(response) {
            return response.data.data;
        });
    }

    this.subtractFromCart = function(index) {
        return $http({
            method: "POST",
            url: "/cart/subtractFromCart/" + index,
            data: { '_token': angular.element('meta[name=csrf-token]').attr('content') }
        }).then(function success(response) {
            return response.data.data;

        });
    }

    this.calculateSubTotal = function(cart) {
        sub_total = 0;
        angular.forEach(cart.items, function(item) {
            var dish_price = item['dish'].price;
            angular.forEach(item['custom'], function(custom, custom_id) {
                var custom_price = custom.price;
                dish_price += custom_price;
                angular.forEach(item['option'], function(option, option_id) {

                    if (option.customization_id == custom.id) {
                        var option_price = option.price * item['option_quantity'][option_id];
                        dish_price += option_price;
                    }
                });
            });

            sub_total += dish_price * item['quantity'];
        });
        return sub_total;
    }

    this.dishAmountChange = function(quantity, index) {
        return $http({
            method: "POST",
            url: "/cart/dishAmountChange/" + index,
            data: {
                'quantity': quantity,
                '_token': angular.element('meta[name=csrf-token]').attr('content')
            }
        }).then(function success(response) {
            return response.data.data;
        });
    }

    this.checkBill = function(cart, rate, type, checkBillOrNot) {
        cart.checkbill = (checkBillOrNot) ? 1 : 0;
        cart.tax_type = (angular.isDefined(type)) ? type : -1;
        cart.tax = rate;
        return this.saveCart(cart);
    }

    this.calculateDish = function(item) {
        var price = item.price;
        angular.forEach(item.options, function(option) {
            price += option.price;
        });
        return price * item['quantity'];
    }

    this.saveCart = function(cart) {
        var data = {
            'cart': cart,
            '_token': angular.element('meta[name=csrf-token]').attr('content')
        };
        return $http({
            method: "POST",
            url: "/cart/saveCart",
            data: data
        }).then(function success(response) {
            return response.data.data;
        });
    }

    this.applyCurrentPriceToDish = function(cart, list_dishes, apply_type) {
        var new_cart = cart;
        angular.forEach(cart.items, function(item, key) {
            if (list_dishes[item.id]) {
                if (apply_type == "change") {
                    new_cart.items[key].price = list_dishes[item.id].price;
                } else if (apply_type == "disappear") {
                    new_cart.items.splice(key, 1);
                }
            }
        });
        return this.saveCart(new_cart);
    }

    this.reOrder = function(order_info, cart_items) {
        return $http({
            method: "post",
            url: "/cart/reOrder",
            data: {
                'old_order_info': order_info,
                'items': cart_items,
                '_token': angular.element('meta[name=csrf-token]').attr('content')
            }
        }).then(function success(response) {
            return response.data;
        });
    }

    this.calAmountItem = function() {
        var amount = 0;
        angular.forEach(this.getValidItems(), function (item) {
            amount += item.quantity;
        });
        return amount;
    }

    this.getValidItems = function () {
        return Object.values($scope.cart.items).filter(function (item) {
            return item.id != null;
        })
    }
});