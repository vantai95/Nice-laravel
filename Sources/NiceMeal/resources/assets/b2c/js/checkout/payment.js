app.controller('PaymentCtrl', function($scope, $http, $timeout, $interval) {
    $scope.init = function() {
        $timeout(function() {
            angular.element('.md-content').removeClass('hidden');
            angular.element('.select2').select2();
            angular.element('#specific_time').timepicker({
                format: 'HH:mm',
                showMeridian: false,
                minuteStep: 1,
            });
        },100);

        //Mowr modal
        angular.element('#otpModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $scope.verifyData = [];
        //Goi makeitgo
        $scope.makeItGo();
    };
    $scope.verified = $scope.showErrorMessage = $scope.canceled= $scope.dishes_changed =$scope.dishes_disappear= $scope.ordering=0;

    $scope.resendOTP = function() {
        $scope.resending = 1;
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'order_id': $scope.order_id
        };
        $http({
            method: "post",
            url: '/resend-online-payment-otp',
            data: data
        }).then(function success(response) {
            if (!response.data.error) {
                $scope.verified = 0;
                $scope.send_left = response.data.send_left;
                $scope.verifyData.otp_created_at = new Date(response.data.otp_created_at);
                $scope.makeItGo();
                toastr.success(response.data.message);
            } else {
                $scope.verifyData.otp_error = response.data.message;
            }
            $scope.resending = 0;
        });
    }

    $scope.confirmOTP = function() {
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'order_id': $scope.order_id,
            'otp': $scope.verifyData.otp
        };
        $scope.requesting = 1;
        $http({
            method: 'post',
            url: '/confirm-online-payment-otp',
            data: data
        }).then(function success(response) {
            if (!response.data.error) {
                $scope.verified = 1;
                $scope.playPosition = $scope.playDuration;
            } else {
                $scope.otp_error = response.data.message;
            }
            $scope.requesting = 0;
        });
    }

    $scope.cancelOTP = function() {
        $scope.canceled = 1;
        $scope.playPosition = $scope.playDuration;
    }

    $scope.validateOTP = function() {
        var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
        if ($scope.verifyData.otp < 0 || isNaN($scope.verifyData.otp) || format.test($scope.verifyData.otp) || $scope.verifyData.otp.length > 6) {
            $scope.verifyData.otp = $scope.verifyData.otp.substr(0, $scope.verifyData.otp.length - 1);
        }
    }

    $scope.makeItGo = function() {
        var call_ = new Date();
        $scope.call_at = call_.getTime();
        $scope.playPosition = 0;
        $scope.playDuration = Number(angular.element('meta[name=otp-popup-time]').attr('content'));
        if ($scope.playPosition < $scope.playDuration) {
            $scope.playPosition += 50;
        } else {
            $interval.cancel(prog);
        }
        var prog = $interval(function() {
            if ($scope.playPosition < $scope.playDuration) {
                $scope.playPosition = 0;
                var now = new Date();
                var current_position = now.getTime() - $scope.call_at;
                $scope.playPosition = current_position;
            } else {
                $interval.cancel(prog);
            }
        }, 50);
    };

    $scope.openConfirmOTPBox = function() {
        // angular.element('#otpModal').modal("show");
        $scope.makeItGo();
    }

    angular.element('#otpModal').on('hidden.bs.modal', function() {
        if (!$scope.verified && $scope.playPosition < $scope.playDuration) {
            angular.element("#otpModal").modal("show");
        }

    });
});

app.filter('tel', function() {
    return function(tel) {
        if (!tel) {
            return '';
        }

        var value = tel.toString().trim().replace(/^\+/, '');

        if (value.match(/[^0-9]/)) {
            return tel;
        }

        return value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6);
    };
});

app.directive('trackProgressBar', [function() {

    return {
        restrict: 'E', // element
        scope: {
            curVal: '@', // bound to 'cur-val' attribute, playback progress
            maxVal: '@' // bound to 'max-val' attribute, track duration
        },
        template: `<div class="progress-bar-full">
        <div class="progress-bar-current">
        </div>
        </div>`,

        link: function($scope, element, attrs) {
            // grab element references outside the update handler
            var progressBarBkgdElement = angular.element(element[0].querySelector('.progress-bar-full')),
                progressBarMarkerElement = angular.element(element[0].querySelector('.progress-bar-current'));

            // set the progress-bar-marker width when called
            function updateProgress() {
                var progress = 0,
                    currentValue = $scope.curVal,
                    maxValue = $scope.maxVal,
                    // recompute overall progress bar width inside the handler to adapt to viewport changes
                    progressBarWidth = progressBarBkgdElement.prop('clientWidth');

                if ($scope.maxVal) {
                    // determine the current progress marker's width in pixels
                    progress = Math.min(currentValue, maxValue) / maxValue * progressBarWidth;
                }

                // set the marker's width
                progressBarMarkerElement.css('width', progress + 'px');
            }

            // curVal changes constantly, maxVal only when a new track is loaded
            $scope.$watch('curVal', updateProgress);
            $scope.$watch('maxVal', updateProgress);
        }
    };
}]);