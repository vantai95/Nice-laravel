app.controller('RestaurantCtrl',function($scope,$window,$http){
  $scope.init = function(){
    $scope.$apply();
    $scope.getRestaurants();
  }

  $scope.getRestaurants = function(){

    $http({
      method: "post",
      url: '/locations/' + $scope.currentLocation.district + '/restaurants?ward=' + $scope.currentLocation.ward,
      data: {
        '_token': angular.element('meta[name=csrf-token]').attr('content'),
        'condition': {
            'cuisines': ($scope.selectedCuisines.length === 0) ? ["all"] : $scope.selectedCuisines,
            'categories': ($scope.selectedCategories.length === 0) ? ["all"] : $scope.selectedCategories,
            'statuses': "",
            "services": ["delivery","pickup"],
            "payment_methods": ["cod_payment","online_payment"]
        },
        'sort': "",
        'segIdx': 0
      }
    }).then(function success(response){
      $scope.restaurants = response.data.restaurants;
    })
  }

  $scope.chooseCuisine = function($event, cuisine_id){
    if(!$scope.selectedCuisines.includes(cuisine_id)){
      $scope.selectedCuisines.push(cuisine_id);
    }else{
      $scope.selectedCuisines = $scope.selectedCuisines.filter(cui => cui != cuisine_id);
    }
    $scope.getRestaurants();
  }

  $scope.chooseCategory = function($event, category_id){
    if(!$scope.selectedCategories.includes(category_id)){
      $scope.selectedCategories.push(category_id);
    }else {
      $scope.selectedCategories = $scope.selectedCategories.filter(cat => cat != category_id);
    }
    $scope.getRestaurants();
  }

  $scope.cuisineSelected = function(cuisine_id){
    if(!$scope.selectedCuisines.includes(cuisine_id)){
      return false;
    }
    return true;
  }

  $scope.categorySelected = function(category_id){
    if(!$scope.selectedCategories.includes(category_id)){
      return false;
    }
    return true;
  }

});
