angular.element(document).ready(function () {
    $registerPopupScope = angular.element('[ng-controller=RegisterPopupCtrl]').scope();
    $registerPopupScope.requesting = false;
    $registerPopupScope.$apply();
});

app.controller('RegisterPopupCtrl', function ($scope, $http) {

    $scope.requestRegister = function () {
        $scope.requesting = true;
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'full_name': $scope.full_name,
            'email': $scope.email,
            'password': $scope.password,
            'password_confirmation': $scope.password_confirmation,
            'phone': $scope.phone,
            'avartar': $scope.namesArr
        };

        $http({
            method: "POST",
            url: '/register',
            data: data
        }).then(function success(response) {
            $scope.requesting = false;
            if (response.data.success) {
                window.location.reload();
            }
            // $scope.districtList = response.data.districts;
        }).catch(function error(response) {
            $scope.requesting = false;
            // remove all error messages
            angular.element('.error-message').remove();

            // add error messages
            var errors = response.data.errors_message;

            angular.forEach(errors, function (key, value) {
                angular.element("#myModalRegister form>div" + "." + value).append(`<span class="error-message" style="font-weight: bold; color:white" role="alert"><strong>${key[0]}</strong></span>`);
            });

            $('.error-message').show();
        });
    }
    //upload avatar register
    $scope.fileNameChanged = function (ele) {
      var files = ele.files;
      var l = files.length;
      $scope.namesArr = [];

      for (var i = 0; i < l; i++) {
        $scope.namesArr.push(files[i].name);
      }
    }
});

