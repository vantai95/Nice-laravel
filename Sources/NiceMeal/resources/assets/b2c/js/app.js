window.app = angular.module('userApp', [], function($interpolateProvider, $locationProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
    // $locationProvider.hashPrefix('');
    // $locationProvider.html5Mode(true);
});

app.filter('trustHtml', function($sce) {
    return function(html) {
        return $sce.trustAsHtml(html)
    }
});
