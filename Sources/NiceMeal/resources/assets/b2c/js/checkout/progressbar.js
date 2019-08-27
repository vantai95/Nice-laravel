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
