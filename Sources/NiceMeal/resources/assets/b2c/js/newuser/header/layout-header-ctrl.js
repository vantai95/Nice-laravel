app.controller('LayoutHeaderCtrl', function ($scope, $http) {
    $scope.init = function () {
        $scope.$apply();
    }

    angular.element(document).ready(function () {
        $scope.getService = function () {
            return ($cartScope !== undefined && $cartScope.cart !== '') ? 'Current service: ' + $cartScope.cart.service : 'Please choose service';
        }
    });
})