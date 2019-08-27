angular.element(document).ready(function () {
    $locationPopupScope = angular.element('[ng-controller=LocationPopUpCtrl]').scope();
    $locationPopupScope.selectedService = "";
    $locationPopupScope.selectedCountry = 1;
    $locationPopupScope.selectedProvince = 1;
    $locationPopupScope.selectedDistrict = "";
    $locationPopupScope.selectedWard = "";
    $locationPopupScope.districtList = [];
    $locationPopupScope.wardList = [];
    $locationPopupScope.getAllLocation();
    $locationPopupScope.$apply();
});

app.controller('LocationPopUpCtrl', function ($scope, $http) {

    $scope.getDistricts = function () {
        // $http({
        //   method: "get",
        //   url: '/locations/'+$scope.selectedProvince+'/districts',
        // }).then(function success(response){
        //   $scope.districtList = response.data.districts;
        // });
    }
angular.element(document).ready(function () {
    $scope.getWards = function () {
        if ($scope !== undefined && $scope.selectedDistrict !== "") {
            $scope.wardList = $scope.districtList.find(district => district.id === Number($scope.selectedDistrict)).wards;
        } else {
            $scope.wardList = [];
        }
    }
});

    $scope.goToRestaurantList = function () {
        var app_url = angular.element('meta[property="og:site_name"]').attr('content');
        var districtSlug = $scope.districtList.find(dis => dis.id === Number($scope.selectedDistrict)).slug;
        window.location.href = app_url + "/locations/" + districtSlug + "?ward=" + $scope.selectedWard + '&service=' + $locationPopupScope.selectedService;
    }

    $scope.getAllLocation = function () {
        $http({
            method: "get",
            url: '/locations/all-locations',
        }).then(function success(response) {
            $scope.districtList = response.data.allLocations;
        });
    }

    $scope.checkIfAllSelectIsChose = function () {
        return $scope.selectedService && $scope.selectedCountry && $scope.selectedProvince && $scope.selectedDistrict;
    }
});
