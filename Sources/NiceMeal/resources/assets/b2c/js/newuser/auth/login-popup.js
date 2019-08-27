
angular.element(document).ready(function(){
    $loginPopupScope = angular.element('[ng-controller=LoginPopupCtrl]').scope();
    $loginPopupScope.requesting = false;
    $loginPopupScope.$apply();
});

app.controller('LoginPopupCtrl',function($scope,$http){

    $scope.requestLogin = function(){
        $scope.requesting = true;
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'email': $scope.email,
            'password': $scope.password,
        };

        $http({
            method: "POST",
            url: '/login',
            data: data
        }).then(function success(response){
            $scope.requesting = false;
            if(response.data.success){
                window.location.reload();
            }
            // $scope.districtList = response.data.districts;
        }).catch(function error(response) {
            $scope.requesting = false;
            // remove all error messages
            angular.element('.error-message').remove();

            // add error messages
            var errors = response.data.errors_response;
            var wrong_email_error = response.data.wrong_email_res;
            if(wrong_email_error){
                angular.element("#myModalLogin form>div.form_body-login>div.email").append(`<span class="error-message" style="font-weight: bold; color:white" role="alert"><strong>${response.data.wrong_email_res}</strong></span>`);
            }else{
                angular.forEach(errors, function(key, value) {
                    angular.element("#myModalLogin form>div.form_body-login>div" + "." + value).append(`<span class="error-message" style="font-weight: bold; color:white" role="alert"><strong>${key}</strong></span>`);
                });
            }

            $('.error-message').show();
        });
    }

});
