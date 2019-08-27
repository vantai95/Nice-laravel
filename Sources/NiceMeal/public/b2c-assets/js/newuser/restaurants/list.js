app.controller('RestaurantListCtrl', function ($scope, $window, $http) {
    $scope.init = function () {
        $scope.$apply();
        $scope.getRestaurants();
    }

    $scope.htmlToPlaintext = function (text) {
        return text ? String(text).replace(/<[^>]+>/gm, '') : '';
    }

    $scope.getRestaurants = function () {
        console.log('12');
        $http({
            method: "post",
            url: '/locations/' + $scope.currentLocation.district + '/restaurants?ward=' + $scope.currentLocation.ward,
            data: {
                '_token': angular.element('meta[name=csrf-token]').attr('content'),
                'condition': {
                    'cuisines': ($scope.selectedCuisines.length === 0) ? ["all"] : $scope.selectedCuisines,
                    'categories': ($scope.selectedCategories.length === 0) ? ["all"] : $scope.selectedCategories,
                    'statuses': "",
                    "services": ["delivery", "pickup"],
                    "payment_methods": ["cod_payment", "online_payment"]
                },
                'sort': "",
                'segIdx': 0
            }
        }).then(function success(response) {
            $scope.restaurants = response.data.restaurants;
            console.log($scope.restaurants);
        })
    }

    $scope.chooseCuisine = function ($event, cuisine_id) {
        if (!$scope.selectedCuisines.includes(cuisine_id)) {
            $scope.selectedCuisines.push(cuisine_id);
        } else {
            $scope.selectedCuisines = $scope.selectedCuisines.filter(cui => cui != cuisine_id);
        }
        if($scope.selectedCuisines.length > 5) {
            $scope.selectedCuisines.splice(-1,1);
        }
        $scope.getRestaurants();
    }

    $scope.chooseCategory = function ($event, category_id) {
        if (!$scope.selectedCategories.includes(category_id)) {
            $scope.selectedCategories.push(category_id);
        } else {
            $scope.selectedCategories = $scope.selectedCategories.filter(cat => cat != category_id);
        }
        if($scope.selectedCategories.length > 5) {
            $scope.selectedCategories.splice(-1,1);
        }
        $scope.getRestaurants();
    }

    $scope.cuisineSelected = function (cuisine_id) {
        if (!$scope.selectedCuisines.includes(cuisine_id)) {
            return false;
        }
        return true;
    }

    $scope.categorySelected = function (category_id) {
        if (!$scope.selectedCategories.includes(category_id)) {
            return false;
        }
        return true;
    }

    $scope.getRestaurantLink = function (restaurant) {
        var restaurant_slug = restaurant.slug;
        var district = restaurant.restaurant_delivery_setting[0].district_slug;
        var ward = restaurant.restaurant_delivery_setting[0].ward_id;
        return `/restaurants/${restaurant_slug}?district=${district}&ward=${ward}`;
    }

    $scope.selectRestaurant = function (restaurant_id) {
        var restaurant = $scope.restaurants.find(restaurant => restaurant.id === restaurant_id);
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
        }
        angular.element('#modalInfo').modal("show");
    }
});
