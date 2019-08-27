app.controller('CheckoutCtrl', function ($scope, $window, $http) {

    $scope.init = function () {
        $scope.$apply();
        $scope.$watch('timeLeft');
        angular.element('.select2').select2();
        angular.element('#delivery_district').select2({
            language: {
                noResults: function (params) {
                    return "District not support delivery";
                }
            }
        });
        angular.element('#delivery_ward').select2({
            language: {
                noResults: function (params) {
                    return "Ward not support delivery";
                }
            }
        });

        angular.element('#payment_district').select2({
            language: {
                noResults: function (params) {
                    return "District not support delivery";
                }
            }
        });
        angular.element('#payment_ward').select2({
            language: {
                noResults: function (params) {
                    return "Ward not support delivery";
                }
            }
        });

        angular.element('#payment_section').hide();
        angular.element('#deposit_section').hide();

        // datepicker
        /*angular.element('.note-date').datepicker({
            language: 'en',
            format: 'dd-mm-yyyy',
            autoclose: true,
            clearBtn: true
        });
        angular.element('#payment-note-date').datepicker({
            language: 'en',
            format: 'dd-mm-yyyy',
            autoclose: true,
            clearBtn: true
        });*/

        // timepicker
        angular.element.fn.timepicker.defaults = $.extend(true, {}, angular.element.fn.timepicker.defaults, {
            icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down'
            }
        });
       /* angular.element('.note-time').timepicker({
            format: 'HH:mm',
            showMeridian: false,
            minuteStep: 1,
        });
        angular.element('#payment-note-time').timepicker({
            format: 'HH:mm',
            showMeridian: false,
            minuteStep: 1,
        });*/

        //mask
        angular.element('#contact_phone').mask('(000) 000-0000', {
            placeholder: "(000) 000-0000",
        });
        angular.element('#app_contact_phone').mask('(000) 000-0000', {
            placeholder: "(000) 000-0000",
        });
        angular.element('#prepare_change').mask("#.##0", {
            reverse: true
        });

        $scope.verifyData = {};

    }

    /*$scope.deliverySpecialSelection = function () {
        $scope.checkoutData.delivery_date = '';
        angular.element('.note-date').val('');
        angular.element('.note-date').removeAttr('disabled');
        angular.element('.note-date').removeClass('hide-calender');
    $scope.deliverySpecialSelection = function () {
        $scope.checkoutData.specific_date = '';
        angular.element('.modal-datepicker li#deli_asap').removeAttr('selected');
        angular.element('.modal-datepicker li#deli_special').attr('selected', true);
        angular.element('.note-date').val('');
        angular.element('.note-date').removeAttr('disabled');
        angular.element('.note-date').removeClass('hide-calender');
        angular.element('.calender .fa-calendar.deli').show();
        angular.element('.delivery-time .dash').show();
        angular.element('.delivery-time .time').show();

    }

    $scope.deliveryAsapSelection = function () {
        var textInput = angular.element('.modal-datepicker ul li#deli_asap').text();
        angular.element('.note-date').attr('disabled', 'disabled');
        angular.element('.note-date').val(textInput);
        angular.element('.note-date').addClass('hide-calender');
        $scope.checkoutData.specific_date = textInput;
        $scope.checkoutData.specific_time = '';
    }

    $scope.deliveryPaymentSpecialSelection = function () {
        $scope.checkoutData.payment_date = '';
        angular.element('#payment-note-date').val('');
        angular.element('#payment-note-date').removeAttr('disabled');
        angular.element('#payment-note-date').removeClass('hide-calender');
    }

    $scope.deliveryPaymentAsapSelection = function () {
        var textInput = angular.element('#payment-modal-datepicker li#payment_asap').text();
        angular.element('#payment-note-date').attr('disabled', 'disabled');
        angular.element('#payment-note-date').val(textInput);
        angular.element('#payment-note-date').addClass('hide-calender');
        $scope.checkoutData.payment_date = textInput;
        $scope.checkoutData.payment_time = '';
    }*/

    $scope.synchronizeCart = async function () {
        $scope.dishes_changed = 0;
        $scope.dishes_changed_list = [];

        $scope.dishes_disappear = 0;
        $scope.dishes_disappear_list = [];

        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'cart': $scope.cart
        };
        angular.element('#synchronizeModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $http({
            method: 'post',
            url: '/cart/synchonize',
            data: data
        }).then(function successCallback(response) {
            if (response.data.dishes_changed) {
                $scope.dishes_changed = 1;
                $scope.dishes_changed_list = response.data.dishes_changed_list;
            } else if (response.data.dishes_disappear) {
                $scope.dishes_disappear = 1;
                $scope.dishes_disappear_list = response.data.dishes_disappear_list;
            } else if (response.data.promotions_changed) {
                var district = window.location.search.split('district=')[1];
                window.location = `/restaurants/${$scope.cart['restaurant']}?district=${district}`;
            } else {
                angular.element('#synchronizeModal').modal('hide');
                if($cartScope.cart.payment !=='online_payment'){
                    angular.element('#otpModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                }
            }
        });
    }

    $scope.requesting = function () {
        return ($http.pendingRequests.length > 0) ? 1 : 0;
    }

    $scope.applySynchronizeData = function () {
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

        $cartScope.applySynchronizeData($cartScope.cart, list_dishes, apply_type).then(function (data) {
            $cartScope.cart = data;
            if ($cartScope.cart.items.length == 0) {
                $("#finishBtn").attr("disabled", true);
            }
            angular.element('#otpModal').modal("hide");
            angular.element('#cartModal').modal("show");
        });
    }

    $scope.orderNow = async function () {
        await $scope.synchronizeCart();

        await $scope.finishOrder();
    }

    $scope.finishOrder = function () {
        angular.element('#contact_phone').unmask('(000) 000-0000');
        angular.element('#app_contact_phone').unmask('(000) 000-0000');
        angular.element('#prepare_change').unmask('#.##0');
        $scope.checkoutData.phone = angular.element('#contact_phone').val();
        $scope.checkoutData.app_contact_info = angular.element('#app_contact_phone').val();
        $scope.checkoutData.payment_prepare = angular.element('#prepare_change').val();

        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'info': $scope.checkoutData,
            'cart': $cartScope.cart
        };

        $scope.ordering = 1;
        $http({
            method: 'post',
            url: '/finish-check-out',
            data: data
        }).then(function (response) {

            if (response.data.order_id != undefined && response.data.order_id != 0) {
                if($cartScope.cart.payment =='online_payment'){
                    data_payment =  response.data;
                    $("#p_order_id").val(response.data.order_id);
                    $("#p_payment_with").val($cartScope.cart.payment_with);
                    $('#payment_form_newuser').submit();
                }
                if (response.data.otp_verify) {
                    $scope.resending = 0;
                    $scope.verifyData = [];
                    $scope.verified = 0;
                    $scope.send_left = response.data.send_left;
                    $scope.otp_created_at = new Date(response.data.otp_created_at);
                    $scope.otp_expired_at = new Date(response.data.otp_expired_at);
                    $scope.verifyData.order_id = response.data.order_id;
                    $scope.runOtp();
                } else {
                    $scope.verified = 1;
                    $scope.playPosition = $scope.playDuration;
                }
            }
            $scope.ordering = 0;
        })
    }

    $scope.confirmOTP = function () {
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'order_id': $scope.verifyData.order_id,
            'otp': $scope.verifyData.otp
        };
        $http({
            method: 'post',
            url: '/confirm-otp',
            data: data
        }).then(function success(response) {
            if (!response.data.error) {
                $scope.verified = 1;
            } else {
                $scope.otp_error = response.data.message;
            }
        });
    }

    $scope.submitOtp = function () {
        if($scope.verifyData.otp.length === 4){
            $scope.confirmOTP();
            $scope.verifyData.otp = '';
        }
    }

    $scope.choosePayment = function (method = '') {
        $scope.checkoutData.payment_method = method;
        $cartScope.cart.payment_with = method;
        if (method === 'cash') {
            angular.element("#" + method + "_icon").toggleClass("payment-icon-border");
            if (angular.element("#" + method + "_icon").hasClass("payment-icon-border")) {
                angular.element('#payment_section').show();
                angular.element('#deposit_section').show();
            } else {
                $scope.checkoutData.payment_method = '';
                angular.element('#payment_section').hide();
                angular.element('#deposit_section').hide();
            }
            angular.element("#" + method + "_icon p").toggleClass("payment-black-text");
            angular.element("#paypal_icon").removeClass("payment-icon-border");
            angular.element("#nganluong_icon").removeClass("payment-icon-border");
            angular.element("#paypal_icon p").removeClass("payment-black-text");
            angular.element("#nganluong_icon p").removeClass("payment-black-text");
            $cartScope.cart.payment = 'cod';
        } else if (method === 'paypal') {
            angular.element("#" + method + "_icon").toggleClass("payment-icon-border");
            if (angular.element("#" + method + "_icon").hasClass("payment-icon-border")) {
                angular.element('#payment_section').hide();
                angular.element('#deposit_section').hide();
            } else {
                $scope.checkoutData.payment_method = '';
            }
            angular.element("#" + method + "_icon p").toggleClass("payment-black-text");
            angular.element("#cash_icon").removeClass("payment-icon-border");
            angular.element("#nganluong_icon").removeClass("payment-icon-border");
            angular.element("#cash_icon p").removeClass("payment-black-text");
            angular.element("#nganluong_icon p").removeClass("payment-black-text");
            $cartScope.cart.payment = 'online_payment';
        } else {
            angular.element("#nganluong_icon").toggleClass("payment-icon-border");
            if (angular.element("#nganluong_icon").hasClass("payment-icon-border")) {
                angular.element('#payment_section').hide();
                angular.element('#deposit_section').hide();
            } else {
                $scope.checkoutData.payment_method = '';
            }
            angular.element("#nganluong_icon p").toggleClass("payment-black-text");
            angular.element("#cash_icon").removeClass("payment-icon-border");
            angular.element("#paypal_icon").removeClass("payment-icon-border");
            angular.element("#cash_icon p").removeClass("payment-black-text");
            angular.element("#paypal_icon p").removeClass("payment-black-text");
            $cartScope.cart.payment = 'online_payment';
        }
    }

    $scope.CheckResidenceType = function (section = '') {
        var checkVal = angular.element('.' + section + ' .residence-type select').val();
        if (checkVal == 'hotel') {
            angular.element('.' + section + ' .hiden-residence-name').hide();
            angular.element('.' + section + ' .hotel-show').show();
            angular.element('.' + section + ' .floor-room').show();
        }
        if (checkVal == 'building') {
            angular.element('.' + section + ' .hiden-residence-name').hide();
            angular.element('.' + section + ' .building-show').show();
            angular.element('.' + section + ' .floor-room').show();
        }
        if (checkVal == 'compound') {
            angular.element('.' + section + ' .hiden-residence-name').hide();
            angular.element('.' + section + ' .compound-show').show();
            angular.element('.' + section + ' .floor-room').show();
        }
        if (checkVal == 'house') {
            angular.element('.' + section + ' .hiden-residence-name').hide();
        }
    }

    $scope.getResDeliSetting = function () {
        var res_deli_array = $scope.restaurant.restaurant_delivery_setting;

        return Array.from(new Set(res_deli_array.map(s => s.district_id))).map(
            district_id => {
                return {
                    district_id: district_id,
                    district_name: res_deli_array.find(s => s.district_id === district_id).district_name
                }
            }
        );
    }

    $scope.getDeliveryWard = function (district_type) {
        if (district_type !== "" && district_type !== undefined) {
            var deli_wards = $scope.restaurant.restaurant_delivery_setting.filter(deli => deli.district_id === Number(district_type));
            var result = [];
            angular.forEach(deli_wards, function (value, key) {
                if (value.ward_id === null || value.ward_id === "") {
                    var another_array = $locationPopupScope.districtList.find(district => district.id === Number(district_type)).wards;
                    angular.forEach(another_array, function (value, key) {
                        result.push(value);
                    });
                } else {
                    result.push(value);
                }
            });
            return result;
        } else {
            return [];
        }
    }

    $scope.runOtp = function () {
        var expireTime = Math.round(new Date($scope.otp_expired_at).getTime() / 1000);
        var interval = setInterval(function () {
            var currentTime = Math.round(new Date().getTime() / 1000);
            $scope.timeLeft = expireTime - currentTime;
            $scope.$digest();
            if ($scope.timeLeft == 0) {
                clearInterval(interval);
            }
        }, 1000);

    };

    angular.element(document).ready(function () {
        $scope.getService = function () {
            if($cartScope !== undefined) {
                return $cartScope.cart.service;
            }
        }
    });
    
    $scope.backHome = function () {
        window.location = '/'
    }

});