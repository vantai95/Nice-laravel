angular.element(document).ready(function(){
    $forgotPopupScope = angular.element('[ng-controller=ForgotPopupCtrl]').scope();
    $forgotPopupScope.requesting = false;
    $forgotPopupScope.$apply();
});


app.controller('ForgotPopupCtrl',function($scope,$http){

    $scope.requestForgot = function(){
        $scope.requesting = true;
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'email': $scope.email
        };


        $http({
            method: "POST",
            url: '/password/create',
            data: data
        }).then(function success(response){
            $scope.requesting = false;

            if(response.data.success){
                window.location.reload();
            }else{
                //show error message'
                $('#error_message').text(response.data.message);
            }
        });
    }

});
