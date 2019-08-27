app.controller('CheckoutCtrl', function($scope, $http, $timeout, $interval, cart) {
    $scope.init = function() {
        $timeout(function() {
            angular.element('.md-content').removeClass('hidden');
            angular.element('.select2').select2();
            angular.element('#specific_time').timepicker({
                format: 'HH:mm',
                showMeridian: false,
                minuteStep: 1,
            });
            $scope.cart.total_item = cart.calAmountItem();
        });
    };

    $scope.changePaymentAmount = function(){
        $scope.checkoutData.payment_amount_value = '';
        if($scope.checkoutData.payment_amount == 0){
            $scope.checkoutData.payment_amount_value = $scope.cart.order_total;
        }
    };

    $scope.synchronizeCart = function(){
      $scope.dishes_changed = 0;
      $scope.dishes_changed_list = [];

      $scope.dishes_disappear = 0;
      $scope.dishes_disappear_list = [];

      var data = {
          '_token': angular.element('meta[name=csrf-token]').attr('content'),
          'cart': $scope.cart
      };
      angular.element('#otpModal').modal({
          backdrop: 'static',
          keyboard: false
      });
      $http({
        method : 'post',
        url: '/cart/synchonize',
        data: data
      }).then(function successCallback(response){
        if (response.data.dishes_changed) {
            $scope.dishes_changed = 1;
            $scope.dishes_changed_list = response.data.dishes_changed_list;
        } else if (response.data.dishes_disappear) {
            $scope.dishes_disappear = 1;
            $scope.dishes_disappear_list = response.data.dishes_disappear_list;
        } else if (response.data.promotions_changed) {
            var district = window.location.search.split('district=')[1];
            window.location = `/restaurants/${$scope.cart['restaurant']}?district=${district}`;
        }else{
          $scope.finishOrder();
        }
      });
    }

    $scope.finishOrder = function() {
        /**
        * 1/ Check if any dishes deleted, synchonize cart
        * 2/ Check if payment_online --> payment --> fishnish order --> send OTP
        */
        if($scope.cart.payment =='online_payment'){
            var ourVoucher = $scope.cart.voucher;
            if (!ourVoucher) {
                $scope.finishCheckout();
                return;
            }
            var data = {
                '_token': angular.element('meta[name=csrf-token]').attr('content'),
                'voucher_code' : $scope.voucher_code
            };
            $http({
                method: 'post',
                url: '/check-voucher',
                data: data
            }).then(function successCallback(res)  {
                if (res.data.status == 200) {
                    $scope.cart = res.data.cart;
                    $scope.finishCheckout();
                }
                else if (res.data.status == 404) {
                    $scope.cart = res.data.cart;
                    angular.element('#voucherModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }

            });

        }else{
            angular.element('#otpModal').modal({
                backdrop: 'static',
                keyboard: false
            });

            var ourVoucher = $scope.cart.voucher;
            if (!ourVoucher) {
                $scope.finishCheckout();
                return;
            }

            var data = {
                '_token': angular.element('meta[name=csrf-token]').attr('content'),
                'voucher_code': $scope.voucher_code
            };
            $http({
                method: 'post',
                url: '/check-voucher',
                data: data
            }).then(function successCallback(res) {
                if (res.data.status == 200) {
                    $scope.cart = res.data.cart;
                    $scope.finishCheckout();
                } else if (res.data.status == 404) {
                    $scope.cart = res.data.cart;
                    angular.element('#otpModal').modal('toggle');
                    angular.element('#voucherModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }

            });
        }

    }

    $scope.finishCheckout = function() {

        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'info': $scope.checkoutData,
            'cart': $scope.cart
        };
        $scope.ordering = 1;
        $http({
            method: 'post',
            url: '/finish-check-out',
            data: data
        }).then(function(response) {

            if (response.data.order_id != undefined && response.data.order_id != 0) {
                if($scope.cart.payment =='online_payment'){
                    data_payment =  response.data;
                    $("#p_order_id").val(response.data.order_id);
                    $('#payment_form').submit();
                }

                if (response.data.otp_verify) {
                    $scope.resending = 0;
                    $scope.verifyData = [];
                    $scope.verified = 0;
                    $scope.send_left = response.data.send_left;
                    $scope.otp_created_at = new Date(response.data.otp_created_at);
                    $scope.verifyData.order_id = response.data.order_id;
                    $scope.makeItGo();
                } else {
                    $scope.verified = 1;
                    $scope.playPosition = $scope.playDuration;
                }
            }
            $scope.ordering = 0;
        })
    }

    $scope.resendOTP = function() {
        $scope.resending = 1;
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'order_id': $scope.verifyData.order_id
        };
        $http({
            method: "post",
            url: '/resend-otp',
            data: data
        }).then(function success(response) {
            if (!response.data.error) {
                $scope.verified = 0;
                $scope.send_left = response.data.send_left;
                $scope.otp_created_at = new Date(response.data.otp_created_at);
                $scope.makeItGo();
                toastr.success(response.data.message);
            } else {
                $scope.otp_error = response.data.message;
            }
            $scope.resending = 0;
        });
    }

    $scope.confirmOTP = function() {
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'order_id': $scope.verifyData.order_id,
            'otp': $scope.verifyData.otp
        };
        $scope.requesting = 1;
        $http({
            method: 'post',
            url: '/confirm-otp',
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
        // Setting values here in example, normally would come from some other component
        $scope.playPosition = 0;
        $scope.playDuration = angular.element('meta[name=otp-popup-time]').attr('content');
        if ($scope.playPosition < $scope.playDuration) {
            $scope.playPosition += 50;
        } else {
            $interval.cancel(prog);
        }
        var prog = $interval(function() {
            if ($scope.playPosition < $scope.playDuration) {
                $scope.playPosition = 0;
                var now = new Date();
                var current_position = now.getTime() - $scope.otp_created_at;
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

    /**
     * cart function must implement if user UI have cart
     */
    $scope.saveCart = function() {
        cart.saveCart($scope.cart).then(function(returndata) {
            $scope.cart = returndata;
        })
    }

    $scope.applyCurrentPriceToCart = function() {
        var list_dishes = [];
        var apply_type = "";
        if ($scope.dishes_changed) {
            $scope.dishes_changed = null;
            list_dishes = $scope.dishes_changed_list;
            apply_type = "change";
        } else if ($scope.dishes_disappear) {
            $scope.dishes_disappear = null;
            list_dishes = $scope.dishes_disappear_list;
            apply_type = "disappear";
        }

        cart.applyCurrentPriceToDish($scope.cart, list_dishes, apply_type).then(function(data) {
            $scope.cart = data;
            if($scope.cart.items.length == 0) {
                $("#finishBtn").attr("disabled", true);
            }
            angular.element('#otpModal').modal("hide");
            angular.element('#cartModal').modal("show");
        });

    }

    $scope.calculateDish = function(index) {
        return cart.calculateDish($scope.cart.items[index]);
    }

    $scope.selectPayment = function(paymentKey) {
        $scope.cart.payment = paymentKey;
        $scope.saveCart();
    }

    $scope.checkPayment = function(paymentKey) {
        if ($scope.cart.payment == paymentKey) {

            return 1;
        }
        return 0;

    }

    $scope.isOnlinePayment = function(){
        if($scope.cart == undefined){
            return 0;
        }
        if($scope.cart.payment =='online_payment'){
            return 1;
        }
        return 0;
    }

    $scope.selectService = function(serviceKey, fee) {
        $scope.selectedOrderService = serviceKey;
        $scope.cart.service = serviceKey;
        if (serviceKey == 'delivery' && ($scope.cart.items).length == 0) {
            $scope.cart.delivery_fee = $scope.restaurant.deliveryCost;
        } else {
            $scope.cart.delivery_fee = 0;
        }
        $scope.saveCart();

    }

    $scope.checkService = function(serviceKey) {

        if ($scope.cart.service == serviceKey) {
            return 1;
        }
        return 0;

    }

    $scope.checkBill = function($event) {
            var checkBillOrNot = event.target.checked;
            cart.checkBill($scope.cart, $scope.restaurant.rate, $scope.restaurant.type, checkBillOrNot).then(function(response) {
                $scope.cart = response;
            });
        }
        /**
         * end cart function
         */

    $scope.validateTime = function(selection, time) {
        var cd = new Date();
        var ct = parseInt(cd.getHours() * 3600000) + parseInt(cd.getMinutes() * 60000);
        if (selection == 'other') {
            var requestTime = parseInt(time.split(":")[0]) * 3600000 + parseInt(time.split(":")[1]) * 60000;
            return requestTime >= ct + 1800000;
        }
    };

    $scope.validatePaymentAmount  = function(paymentAmount, total) {
        if(paymentAmount>=total)
            return true;
        return false;
    };
    $scope.checkVoucher = function() {
        $http({
            method: "post",
            url: '/check-voucher',
            data: {
                '_token': angular.element('meta[name=csrf-token]').attr('content'),
                'voucher_code': $scope.voucher_code
            }
        }).then(function successCallback(response) {
            $scope.checked_voucher = true;
            if (response.data.status == 200) {
                $scope.cart = response.data.cart;
            } else if (response.data.status == 404) {
                $scope.cart = response.data.cart;
            }
        });
    }
    $scope.backToOrderPage = function() {
        var ward_delivery = $scope.restaurant.ward_delivery  ? '&ward=' + $scope.restaurant.ward_delivery : '';
        window.location = `/restaurants/${$scope.restaurant.slug}?district=${$scope.districts[0].slug}${ward_delivery}`;
    }

    $scope.choosePaypal = function(){
        $("#payment-paypal").addClass('active');
        $("#payment-aleypay").removeClass('active');
        $scope.cart.payment_with ="paypal";
        $scope.saveCart();
    }

    $scope.chooseAlepay = function(){
        $("#payment-aleypay").addClass('active');
        $("#payment-paypal").removeClass('active');
        $scope.cart.payment_with ="nganluong";
        $scope.saveCart();
    }

});
app.filter('trustHtml', function($sce) {
    return function(html) {
        return $sce.trustAsHtml(html)
    }
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
 // Directive
 app.directive('inputCurrency', ['$locale', '$filter', function($locale, $filter) {

    // For input validation
    var isValid = function(val) {
      return angular.isNumber(val) && !isNaN(val);
    };

    // Helper for creating RegExp's
    var toRegExp = function(val) {
      var escaped = val.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\&');
      return new RegExp(escaped, 'g');
    };

    // Saved to your $scope/model
    var toModel = function(val) {

      // Locale currency support
      var decimal = toRegExp($locale.NUMBER_FORMATS.DECIMAL_SEP);
      var group = toRegExp($locale.NUMBER_FORMATS.GROUP_SEP);
      var currency = toRegExp($locale.NUMBER_FORMATS.CURRENCY_SYM);
      console.log("decimal");
      console.log($locale.NUMBER_FORMATS.DECIMAL_SEP);
      console.log("group");
      console.log($locale.NUMBER_FORMATS.GROUP_SEP);
      console.log("currency");
      console.log($locale.NUMBER_FORMATS.CURRENCY_SYM);
      // Strip currency related characters from string
      val = val.replace(decimal, '').replace(group, '').replace(currency, '').trim();

      return parseInt(val, 10);
    };

    // Displayed in the input to users
    var toView = function(val) {
      return $filter('currency')(val, '', 0);
    };

    // Link to DOM
    var link = function($scope, $element, $attrs, $ngModel) {
      $ngModel.$formatters.push(toView);
      $ngModel.$parsers.push(toModel);
      $ngModel.$validators.currency = isValid;

      $element.on('keyup', function() {
        $ngModel.$viewValue = toView($ngModel.$modelValue);
        $ngModel.$render();
      });
    };

    return {
      restrict: 'A',
      require: 'ngModel',
      link: link
    };
  }]);
