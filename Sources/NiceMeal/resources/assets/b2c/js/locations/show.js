app.controller('LocationShowCtrl', function($scope, $timeout,$window, $http, $document, $filter) {
    /*****
     *
     * init angular controller
     */
    $scope.init = function() {
        $scope.selectedKeySort = "";

        // apply for dom
        angular.element('.select-location').select2({});
        angular.element('.md-section').removeClass('hidden');
        $scope.nodata = 0;
        $scope.filterRestaurantList();
    };

    angular.element($window).bind("scroll", async function(e) {
      if($scope.restaurants !== undefined && $scope.restaurants.length > 0){
        var lastRestaurant = $scope.restaurants[$scope.restaurants.length-1];
        $element = angular.element('div').find("[data-restaurant-id='"+lastRestaurant.id+"']");
        var windowST = angular.element(this).scrollTop();
        var windowH =  angular.element(this).height()
        var lastElementT = angular.element($element).offset().top;
        // if(windowST + windowH == angular.element($document).height()){
        if(windowST + windowH == angular.element($document).height() || windowST > lastElementT){
          if(!angular.element("#data-loading").is(":visible") && !$scope.nodata){
            await $scope.getMoreResList();
          }
        }
      }
    })

    /*****
     *
     * get restaurant list from backend
     */
    $scope.getRestaurantList = async function(getMore = false) {

        var cuisines = [],
            categories = [],
            statuses = [],
            services = [],
            payment_methods = [];

        angular.forEach(angular.element('.cuisine-list label'), function(item) {
            var cuisine = angular.element(item);
            if (cuisine.find('input[type=checkbox]').val() == 1) {
                cuisines.push(cuisine.children('.custom-control-description').attr('value'));
            }
        });
        angular.forEach(angular.element('.category-list label'), function(item) {
            var category = angular.element(item);
            if (category.find('input[type=checkbox]').val() == 1) {
                categories.push(category.children('.custom-control-description').attr('value'));
            }
        });
        angular.forEach(angular.element('.status-list label'), function(item) {
            var status = angular.element(item);
            if (status.find('input[type=checkbox]').val() == 1) {
                statuses.push(status.children('.custom-control-description').attr('value'));
            }
        });
        angular.forEach(angular.element('.service-list label'), function(item) {
            var service = angular.element(item);
            if (service.find('input[type=checkbox]').val() == 1) {
                services.push(service.children('.custom-control-description').attr('value'));
            }
        });
        angular.forEach(angular.element('.payment-method-list label'), function(item) {
            var payment_method = angular.element(item);
            if (payment_method.find('input[type=checkbox]').val() == 1) {
                payment_methods.push(payment_method.children('.custom-control-description').attr('value'));
            }
        });

        var sortKeys = { 'key': $scope.selectedKeySort, 'direction': $scope.direction };

        if (getMore === true) {
            $scope.segIdx = $scope.segIdx + 1;
        }

        var data = {
            'condition': {
                'cuisines': cuisines,
                'categories': categories,
                'statuses': statuses,
                'services': services,
                'payment_methods': payment_methods
            },
            'sort': sortKeys,
            'segIdx': getMore===true ? $scope.segIdx : 0
        };
        $('#data-loading').show();
        if (getMore === true) {
            await $http.post('/locations/' + $scope.slug + '/restaurants?ward=' + $scope.wardSelected , data).then(function (res) {

                var idx = 0;
                if(res.data.restaurants.length == 0){
                  $scope.nodata = 1;
                }
                angular.forEach(res.data.restaurants, function (item) {
                    $scope.restaurants.push(item);
                });
                $scope.restaurants = $scope.sortListObj($scope.restaurants, 'idx');
                $scope.maxCount = res.data.maxCount;
                $scope.amountResWork = $scope.restaurants.filter(res => res.is_open_now == 1).length;
            }, function (res) {
                $scope.segIdx = $scope.segIdx - 1;
            })
        }
        else {
            await $http.post('/locations/' + $scope.slug + '/restaurants?ward=' + $scope.wardSelected, data).then(function(res) {
                $scope.restaurants = [];

                var idx = 0;
                if(res.data.restaurants.length == 0){
                  $scope.nodata = 1;
                }
                angular.forEach(res.data.restaurants, function(item) {
                    $scope.restaurants.push(item);
                });
                $scope.restaurants = $scope.sortListObj($scope.restaurants, 'idx');
                $scope.maxCount = res.data.maxCount;

                $scope.segIdx = 0;
                $scope.amountResWork = $scope.restaurants.filter(res => res.is_open_now == 1).length;

            }, function(res) {

            })
        }
        $('#data-loading').hide();
    };

    /*****
     *
     * append more restaurants to list
     */
    $scope.getMoreResList = async function() {
        $scope.getRestaurantList(true);
    }

    /*****
     *
     * filter restaurant list
     */
    $scope.filterRestaurantList = function() {
        $scope.getRestaurantList(false);
    }

    /*****
     *
     * sort restaurant list
     */
    $scope.sortRestaurantList = function() {
        $scope.getRestaurantList(false);
    }

    /*****
     *
     * search restaurant by keys
     */
    $scope.searchRes = function() {

        if ($scope.searchKey === '') {
            $scope.filterRestaurantList();
        }
        else {
            $http.post('/locations/' + $scope.slug + '/search-restaurants', {'value': $scope.searchKey}).then(function (res) {

                $scope.restaurants = [];
                angular.forEach(res.data.restaurants, function (item) {
                    $scope.restaurants.push(item);
                });
                $scope.restaurants = $scope.sortListObj($scope.restaurants, 'idx');
                $scope.maxCount = res.data.maxCount;

            }, function (res) {
                console.log(res.statusText);
            });
        }
    }

    /*****
     *
     * set checkbox with value all and uncheck others checkbox
     */
    $scope.checkAll = function($event) {
        var chkAllE = angular.element($event.target);

        if (chkAllE.val() == 0) {
            chkAllE.val(1);
            chkAllE.attr('checked', 'checked');

            chkAllE.parents('ul').find('input[type=checkbox]').each(function(idx) {
                var chkE = $(this);
                if (idx !== 0 && $(chkE).val() == 1) {
                    chkE.val(0);
                    chkE.prop('checked', false);
                }
            });
        } else {
            chkAllE.prop('checked', false);
            chkAllE.val(0);
        }

        $scope.getRestaurantList(false);
    };

    /*****
     *
     * set checkbox value and uncheck checkbox all
     */
    $scope.checkOne = function($event) {

        $scope.restaurants = [];
        $scope.segIdx = 0;

        var chkE = angular.element($event.target);

        if (chkE.val() == 0) {
            chkE.val(1);
            chkE.attr('checked', 'checked');

            if (chkE.parents('ul').find('.custom-control-description').first().attr('value') === 'all') {
                var chkAllE = chkE.parents('ul').find('input[type=checkbox]').first();
                chkAllE.val(0);
                chkAllE.prop('checked', false);
            }
        } else {

            chkE.val(0);
            chkE.prop('checked', false);
            var numCheckedE = 0;
            angular.forEach(chkE.parents('ul').find('input[type=checkbox]'), function(checkedE) {
                if (angular.element(checkedE).val() == 1)
                    numCheckedE = numCheckedE + 1;
            });
            if (numCheckedE == 0) {
                var chkAllE = chkE.parents('ul').find('input[type=checkbox]').first();
                chkAllE.val(1);
                chkAllE.prop('checked', 'checked');
            }
        }

        $scope.getRestaurantList(false);
    };

    /*****
     *
     * toggle widget-filter__item class
     */
    $scope.openItem = function($event) {
        var itemE = angular.element($event.target).parents('.widget-filter__item');
        var listE = itemE.find('.widget-filter__list');
        var toggleE = itemE.find('.widget-filter__toggle');

        if (listE.is(":visible")) {
            toggleE.html('+');
            listE.slideUp('slow', function() {
                listE.hide();
            });
        } else {
            toggleE.html('-');
            listE.slideDown('fast', function() {
                listE.show();
            });
        }
    }

    /*****
     *
     * sort list objects by attribute
     */
    $scope.sortListObj = function(list, key) {
        function compare(a, b) {
            a = a[key];
            b = b[key];
            var type = (typeof(a) === 'string' ||
                typeof(b) === 'string') ? 'string' : 'number';
            var result;
            if (type === 'string') result = a.localeCompare(b);
            else result = a - b;
            return result;
        }
        return list.sort(compare);
    }

});
