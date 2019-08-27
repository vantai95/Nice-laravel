app.controller('RestaurantDetailCtrl', function ($scope, $window, $http) {
    $scope.init = function () {
        $scope.$apply();
        $scope.selectCategory();
        $scope.currentIndex = 1;
    }
    $scope.htmlToPlaintext = function (text) {
        return text ? String(text).replace(/<[^>]+>/gm, '') : '';
    }

    $scope.selectCategory = function (category_id = undefined) {
        if (category_id === undefined) {
            $scope.selectedCategory = $scope.categories[0];
        } else {
            $scope.selectedCategory = $scope.categories.find(cate => cate.id === category_id);
        }
    }

    $scope.dishImage = function (image) {
        if(image.includes("[")){
            var imageValue = eval(image);
            if(imageValue.length > 1 )
                return imageValue[0];
            else 
                return image;
        }
        else return image;
    }

    $scope.selectDish = function (dish_id) {
        var dish = $scope.selectedCategory.dishes.find(dish => dish.id === dish_id);
        var images = [];
        $scope.selectedDish = {
            id: dish.id,
            name: dish.name,
            dish_image: dish.image, 
            price: dish.price,
            description: dish.description,
            quantity: 1,
            free_item: 0,
            options: [],
            category_id: $scope.selectedCategory.id,
            promotion_id: -1
        }
        $scope.selectedCustomizations = $scope.getCustomizations();
        if($scope.selectedDish.dish_image && !eval($scope.selectedDish.dish_image)){
            $scope.images = $scope.selectedDish.dish_image;
            $scope.check= 0 ;
        }
        else if ($scope.selectedDish.dish_image && eval($scope.selectedDish.dish_image)){
            $scope.images = eval($scope.selectedDish.dish_image);
            $scope.check = 1;
        }
        else {
            $scope.images = [];
        }
        angular.element('#PopupAddToCart').modal("show");
    }
    $scope.next = function() {
        $scope.currentIndex < eval($scope.selectedDish.dish_image).length - 1 ? $scope.currentIndex++ : $scope.currentIndex = 0;
    }

    $scope.prev = function() {
        $scope.currentIndex > 0 ? $scope.currentIndex-- : $scope.currentIndex = eval($scope.selectedDish.dish_image).length - 1;
    }

    $scope.selectOption = function (opt) {
        if ($scope.selectedDish.options.find(option => option.option_id === opt.id) !== undefined) {
            $scope.selectedDish.options = $scope.selectedDish.options.filter(option => option.option_id !== opt.id);
        } else {
            var customization = $scope.selectedCustomizations.find(cus => cus.id === opt.customization_id);
            $scope.selectedDish.options.push({
                "custom_name": customization.name,
                "custom_id": customization.id,
                "option_id": opt.id,
                "option_name": opt.name,
                "quantity": 1,
                "price": opt.price
            });
        }
    }

    $scope.customizationSelected = function (customization_id) {
        if($scope.selectedDish !== undefined){
            if ($scope.selectedDish.options.find(opt => opt.custom_id === customization_id) !== undefined) {
                return true;
            }
        }
        return false;
    }

    $scope.optionSelected = function (option_id) {
        if($scope.selectedDish !== undefined){
            if ($scope.selectedDish.options.find(opt => opt.option_id === option_id) !== undefined) {
                return true;
            }
        }
        return false;
    }

    $scope.customizationTotalCalculate = function (customization_id) {
        var selectedOptions = $scope.selectedDish.options.filter(opt => opt.custom_id === customization_id);
        var sum = 0;
        selectedOptions.forEach(function (option) {
            sum += option.price;
        });
        return sum.formatCurrency();
    }

    $scope.getCustomizations = function () {
        if($scope.selectedCategory !== undefined){
            if ($scope.selectedCategory.customization.length === 0) {
                return $scope.selectedDish.customization;
            } else {
                return $scope.selectedCategory.customization;
            }
        }

    }

    $scope.renderCustomization = function (custom_id) {
        if ($scope.beingRenderedCustomization === undefined || $scope.beingRenderedCustomization.id !== custom_id) {
            $scope.beingRenderedCustomization = $scope.customizations.find(cus => cus.id === custom_id);
        }
        return $scope.beingRenderedCustomization;
    }

    $scope.addToCart = function () {
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'item': $scope.selectedDish
        };
        return $http({
            method: "post",
            url: "/cart/addToCart",
            data: data
        }).then(function success(response) {
            $cartScope.cart = response.data.data;
            $scope.selectedDish = undefined;
            angular.element('#PopupAddToCart').modal("hide");
        });
    }

    $scope.getFreeItemPromotions = function () {
        if ($scope.cart.promotions) {
            return Object.values($scope.cart.promotions).filter(function (promotion) {
                return promotion.free_item != null;
            })
        }
    }

    $scope.addToCartItemQuantityChange = function (value = 0) {
        if (value !== 0) {
            $scope.selectedDish.quantity += value;
        }
        if ($scope.selectedDish.quantity === 0) {
            $scope.selectedDish.quantity = 1;
        }
    }

    $scope.itemTotalCalculate = function () {
        var total = 0;
        if ($scope.selectedDish !== undefined) {
            total += $scope.selectedDish.price;
            $scope.selectedDish.options.forEach(function (option) {
                total += option.price * option.quantity;
            });
            total *= $scope.selectedDish.quantity;
        }
        return total.formatCurrency();
    }

    $scope.selectRestaurant = function () {
        var restaurant = $scope.restaurant;
        $scope.selectedRestaurant = {
            id: restaurant.id,
            name: restaurant.name,
            delivery: restaurant.delivery,
            description: restaurant.description,
            vip_restaurant: restaurant.vip_restaurant,
            title_brief: restaurant.title_brief,
            cod_payment: restaurant.cod_payment,
            pickup: restaurant.pickup,
            online_payment: restaurant.online_payment,
            intro: restaurant.intro,
        }
        angular.element('#modalInfo').modal("show");
    }

    $scope.isEmpty = function (obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key)){
                return false;
            }
        }
        return true;
    }


});
