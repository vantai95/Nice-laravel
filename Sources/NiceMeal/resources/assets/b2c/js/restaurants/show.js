app.controller('RestaurantShowCtrl', function($scope, $timeout, $http,cart) {
    $scope.init = function(restaurant, categories,
        dish_customizations, customizations,cart_input,
        orderPayments, orderServices, deliverySettings
    ) {
        $scope.restaurant = restaurant;
        $scope.orderPayments = orderPayments;
        $scope.cart = cart_input;
        $scope.orderServices = orderServices;
        $scope.categories = categories;
        $scope.dish_customizations = dish_customizations;
        $scope.customizations = customizations;
        $scope.deliverySettings = deliverySettings;
        $scope.formData = {};
        $scope.formData.option = [];
        $scope.formData.quantity = 1;
        $scope.formData.option_quantity = [];
        $scope.selectedOrderService = '';
        $scope.selectedOrderPayment = '';
        $scope.defaultValue = [];
        $scope.selectedDish = {};
        $scope.selectedCustomizations = {};
        $scope.selectedCustomization = null;
        $scope.optionSelectedDish = {};
        $scope.multiOption = [];
        $scope.renderingCustomization = undefined;
        $scope.selectedOption = [];
        $scope.note = '';

        $scope.minimize = true;
        $scope.currCate = $scope.categories[0];
        $scope.selectedMenuNav = 'menu';

        var infoToGetCart =  {
          'id':$scope.restaurant.id,
          'restaurant_slug':$scope.restaurant.restaurant_slug,
          'name':$scope.restaurant.name,
          'delivery':$scope.restaurant.delivery,
          'pickup':$scope.restaurant.pickup,
          'cod_payment':$scope.restaurant.cod_payment,
          'online_payment':$scope.restaurant.online_payment,
          'district_id' : $scope.restaurant.district_id
        }
        if($scope.restaurant.ward_delivery !== null){
          infoToGetCart.ward_id = $scope.restaurant.ward_delivery;
        }

        $http({
        method: "post",
        url: "/restaurants/getCart",
        data: {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'restaurant': infoToGetCart

        }
      }).then(function success(response) {
          $scope.cart = response.data;
          $scope.cart.items = Object.values($scope.cart.items).filter(function(item) {
              return item.free_item == 0;
          });
          if ($scope.getFreeItemPromotions()) $scope.cart.free_item_promotions = $scope.getFreeItemPromotions().sort(sortObjects('apply_to'));
      });
    }

    $scope.findCustomizationRender = function(customization_id){
      if($scope.renderingCustomization === undefined || $scope.renderingCustomization.id !== customization_id){
        $scope.renderingCustomization = $scope.customizations.find(cus => cus.id === customization_id);
      }
      return $scope.renderingCustomization;
    }

    $scope.selectDish = function(category, dish) {
        var customization = [];
        // angular.forEach($scope.dish_customizations, function(custom, key) {
        //     if ($scope.customizations[custom.customization_id] !== undefined) {
        //         if (custom.category_id == category.id && custom.dish_id == dish.id && $scope.customizations[custom.customization_id].has_options) {
        //             customization.push(custom.customization_id);
        //         }
        //     }
        // });
        $scope.selectedOption = [];
        $scope.selectedCate = category;
        $scope.selectedDish = {
            id: dish.id,
            name: dish.name,
            price: dish.price,
            quantity: 1,
            free_item: 0,
            options: [],
            category_id: $scope.selectedCate.id,
            promotion_id: -1
        };
        $scope.openCartModal();
        return;
        $http({
            method: "post",
            url: "/dishes/checkDish",
            data: {
                'dish': dish,
                'customization': customization,
                '_token': angular.element('meta[name=csrf-token]').attr('content')
            }
        }).then(function success(response) {
            if (response.data.changed) {
                angular.element('#changeModal').modal("show");
            } else if (response.data.cus_changed) {
                angular.element('#changeModal').modal("show");
            } else {
                angular.element('#optionsForm')[0].reset();
                $scope.selectedDish = dish;
                $scope.selectedCate = category;
                $scope.multiOption = [];
                $scope.selectedOption = [];
                $scope.defaultValue = [];
                $scope.formData.custom = {};
                $scope.formData.option_quantity = {};
                $scope.formData.option = [];
                $scope.formData.quantity = 1;
                $timeout(function() {
                    angular.element('.select2').select2();
                });
                $scope.openCartModal();
            }

        });

    }

    $scope.reloadPage = function() {
        location.reload();
    }

    $scope.openCartModal = function() {
        angular.element('#detailModal').modal("show");
    }

    $scope.multiCheckRequired = function(custom_id) {
        var data = $scope.selectedDish.options;
        var check_enough = true;
        angular.forEach(data, function(value, key) {
            if (value.custom_id == custom_id) {
                check_enough = false;
            }
        });
        return check_enough;
    }

    $scope.customChange = function(custom_id, $event) {
        if (event.target.checked) {
            $scope.formData.custom[custom_id] = $scope.customizations.find(cus => cus.id === custom_id);
        } else {
            delete $scope.formData.custom[custom_id];
        }

    }

    $scope.multioptionChange = function(custom_id, $event) {
        var total_quantity_of_customization = $scope.countChosenOptionOfCustomization(custom_id);
        if (total_quantity_of_customization == $scope.customizations.find(cus => cus.id === custom_id).max_quantity) {
            return;
        }
        if (event.target.value !== undefined) {
            var option_id = Number($scope.selectedOption[custom_id]);
            var customization = $scope.customizations.find(cus => cus.id === custom_id);
            var option = customization.options.find(op => op.id === option_id);
            if ($scope.selectedDish.options[option_id] === undefined) {
                $scope.selectedDish.options[option_id] = {
                    "custom_name": customization.name,
                    "custom_id": custom_id,
                    "option_id": option_id,
                    "option_name": option.name,
                    "quantity": 1,
                    "price": option.price
                };
            }
        }
        $scope.selectedOption[custom_id] = "";
    }

    $scope.deleteOption = function(option_id) {
        delete $scope.selectedDish.options[option_id];
    }

    $scope.optionChange = function(custom_id, $event) {
        if (event.target.value !== undefined) {

            var option_id = Number($scope.selectedOption[custom_id]);
            var customization = $scope.customizations.find(cus => cus.id === custom_id);
            var option = customization.options.find(op => op.id === option_id);
            angular.forEach($scope.selectedDish.options, function(value, key) {
                if (custom_id == value.custom_id) {
                    delete $scope.selectedDish.options[key];
                }
            })
            if ($scope.selectedDish.options[option_id] === undefined) {
                $scope.selectedDish.options[option_id] = {
                    "custom_name": customization.name,
                    "custom_id": custom_id,
                    "option_id": option_id,
                    "option_name": option.name,
                    "quantity": 1,
                    "price": option.price
                };
            }
        }
    }

    $scope.validateNumber = function() {
        var quantity = $scope.selectedDish.quantity;
        if (quantity < 0 || isNaN(quantity)) {
            quantity = 1;
        }
        if (!isNaN(quantity) && quantity > 100) {
            quantity = 99;
        }
        $scope.selectedDish.quantity = quantity;
    }

    $scope.checkValue = function(customization_id, option_id) {

        var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
        var option = $scope.customizations.find(cus => cus.id === customization_id).options.find(op => op.id === option_id);
        var quantity = $scope.selectedDish.options[option_id].quantity;



        if (format.test(quantity)) {
            quantity = 1;
        }
        if (quantity > option.max_quantity && option.max_quantity !== 0) {
            quantity = option.max_quantity;
        }
        if (quantity < option.min_quantity) {
            quantity = option.min_quantity;
        }

        if ($scope.customizationEnough(customization_id)) {
            quantity = 1;
        }

        $scope.selectedDish.options[option_id].quantity = quantity;
    }

    $scope.countChosenOptionOfCustomization = function(customization_id) {
        var total_quantity_of_customization = 0;
        angular.forEach($scope.selectedDish.options, function(value, key) {
            if (value.custom_id == customization_id) {
                total_quantity_of_customization += value.quantity;
            }
        });
        return total_quantity_of_customization;
    }

    $scope.customizationEnough = function(customization_id) {
        var total_quantity_of_customization = $scope.countChosenOptionOfCustomization(customization_id);
        console.log(total_quantity_of_customization);
        if (total_quantity_of_customization > $scope.customizations.find(cus => cus.id === customization_id).max_quantity) {
            return true;
        }
        return false;
    }

    $scope.skipValues = function(value, index, array) {
        return $scope.skip_array.indexOf(value) === -1;
    };

    $scope.checkCustomizationOfDish = function() {
        var count = 0;
        angular.forEach($scope.dish_customizations, function(value, key) {
            if (value.dish_id == $scope.selectedDish.id) {
                count++;
            }
        });
        if (count > 0) {
            return true;
        } else {
            return false;
        }
    }

    $scope.minimize = function($event) {
        var categorySectionElement = $event.currentTarget.parentElement.parentElement;
        categorySectionElement.element('.category__content').show();
    }

    $scope.getFreeItemPromotions = function() {
        if ($scope.cart.promotions) {
            return Object.values($scope.cart.promotions).filter(function(promotion) {
                return promotion.free_item != null;
            })
        }
    }

    $scope.chooseFreeItems = function() {
        var promotions = $scope.cart.free_item_promotions;
        if (promotions.length > 0) {
            angular.element('#cartModal').modal("hide");
            angular.element('#freeItemModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        } else $scope.proceedToCheckout();
    }

    $scope.getAllFreeItems = function() {
        return Object.values($scope.cart.items).filter(function(item) {
            return item.free_item == 1;
        })
    }

    $scope.changeFreeItem = function(promotion, selectedDishId) {
        var promotion = $scope.getPromotionById(promotion.id);
        var freeItemOption = promotion.selected_free_items.filter(function(item) { return item.id == selectedDishId; });
        var dish = Object.values(promotion.dishes).filter(function(dish) { return dish.id == selectedDishId; }).shift();
        $timeout(function() {
            if (selectedDishId != '' && freeItemOption.length == 0) {
                dish.quantity = 0;
                promotion.selected_free_items.push(dish);
            }
        }, 100);
    }

    $scope.deleteFreeItem = function(promotion, dishId) {
        var promotion = $scope.getPromotionById(promotion.id);
        promotion.selected_free_items = Object.values(promotion.selected_free_items).filter(function(dish) { return dish.id != dishId; });
    }

    $scope.setFreeItemValue = function($event, promotion, dish) {
        var promotion = $scope.getPromotionById(promotion.id);
        var totalQuantity = $scope.getPromotionById(promotion.id).free_item_quantity;
        var sumOthersQuantity = 0;
        angular.forEach(promotion.selected_free_items, function(item) { if (dish.id != item.id) sumOthersQuantity += item.quantity });
        if (sumOthersQuantity + dish.quantity > totalQuantity) {
            dish.quantity = totalQuantity - sumOthersQuantity;
        }
    }

    $scope.getPromotionById = function(promotionId) {
        return $scope.cart.promotions.filter(function(promotion) {
            return promotion.id == promotionId;
        }).shift();
    }

    $scope.proceedToCheckout = function() {
        // save free items
        angular.forEach($scope.cart.promotions, function(promotion) {
            angular.forEach(promotion.selected_free_items, function(dish) {
                if (!dish.quantity) return;
                $freeItems = $scope.getAllFreeItems();
                if (Object.values($freeItems).filter(function(d) { return d.id == dish.id; }).length == 0) {
                    $scope.cart.items.push({
                        'id': dish.id,
                        'name': dish.name,
                        'price': 0,
                        'quantity': dish.quantity,
                        'options': [],
                        'free_item': 1,
                        'category_id': 0,
                        'promotion_id': promotion.id
                    })
                } else {
                    angular.forEach($scope.cart.items, function(item) {
                        if (item.id == dish.id) {
                            item.quantity += dish.quantity
                        }
                    });
                }
            });
        });
        cart.saveCart($scope.cart).then(function(returndata) {
            $scope.cart = returndata;
            var ward_delivery = $scope.restaurant.ward_delivery ? '&ward=' + $scope.restaurant.ward_delivery : '';
            // redirect to checkout page
            window.location = '/checkout?district=' + $scope.restaurant.district_slug + ward_delivery;
        })
    }

    /**
     * cart function must implement if user UI have cart
     */
    $scope.saveCart = function() {
        cart.saveCart($scope.cart).then(function(returndata) {
            $scope.cart = returndata;
        })
    }

    $scope.addToCart = function() {
        $scope.validateNumber();
        cart.addToCart($scope.selectedDish).then(function(data) {
            $scope.cart = data;
            $scope.cart.items = Object.values($scope.cart.items);
            angular.element('#detailModal').modal("hide");
            $scope.cart.total_item = cart.calAmountItem();
            $scope.cart.free_item_promotions = $scope.getFreeItemPromotions().sort(sortObjects('apply_to'));
        });
    }

    $scope.subtractFromCart = function(index) {
        cart.subtractFromCart(index).then(function(data) {
            $scope.cart = data;
            $scope.cart.total_item = cart.calAmountItem();
            $scope.cart.free_item_promotions = $scope.getFreeItemPromotions().sort(sortObjects('apply_to'));
        });
    }

    $scope.calculateDish = function(index) {
        return cart.calculateDish($scope.cart.items[index]);
    }

    $scope.dishAmountChange = function(quantity, index) {
        cart.dishAmountChange(quantity, index).then(function(data) {
            $scope.cart = data;
            $scope.cart.total_item = cart.calAmountItem();
            if ($scope.getFreeItemPromotions()) $scope.cart.free_item_promotions = $scope.getFreeItemPromotions().sort(sortObjects('apply_to'));
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

        if (serviceKey == 'delivery' && ($scope.cart.items).length == 0) {
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

    $scope.checkBill = function($event) {
            var checkBillOrNot = event.target.checked;
            cart.checkBill($scope.cart, $scope.restaurant.rate, $scope.restaurant.type, checkBillOrNot).then(function(response) {
                $scope.cart = response;
            });
        }
        /**
         * end cart function
         */

    $scope.goToCate = function(category) {
        $scope.currCate = category;
        angular.element('html, body').animate({
            scrollTop: angular.element("#category-position-" + category.id).offset().top
        }, 500);
    }

    $scope.goToDish = function() {
        angular.forEach($scope.categories, function(cate, key) {
            var count = 0;
            angular.forEach($scope.dishes, function(dish, key) {
                if (dish.category_id == cate.id && dish.name.toUpperCase().indexOf($scope.dishfilter.toUpperCase()) !== -1) {
                    count = count + 1;
                }
            });
            if (count == 0) {
                angular.element(".widget-categories #category-" + cate.id).hide();
                angular.element(".category-wrapper #category-" + cate.id).hide();
            } else {
                angular.element(".widget-categories #category-" + cate.id).show();
                angular.element(".category-wrapper #category-" + cate.id).show();
            }
        });
        angular.forEach($scope.dishes, function(dish, key) {
            if (dish.name.toUpperCase().indexOf($scope.dishfilter.toUpperCase()) !== -1) {
                if (!angular.element("#dish-" + dish.id))
                    return false;
                angular.element('html, body').animate({
                    scrollTop: angular.element("#dish-" + dish.id).offset().top
                }, 500);
                return false;
            }
        });
    }

    $scope.sumObject = function sum(obj) {
        var sum = 0;
        for (var el in obj) {
            if (obj.hasOwnProperty(el)) {
                sum += parseFloat(obj[el]);
            }
        }
        return sum;
    }

    $scope.goBack = function() {
        var ward_delivery = $scope.restaurant.ward_delivery  ? '/' + $scope.restaurant.ward_delivery : '';
        window.location = `/locations/${$scope.restaurant.district_slug}${ward_delivery}`;
    }

});

app.filter('trustHtml', function($sce) {
    return function(html) {
        return $sce.trustAsHtml(html)
    }
});
