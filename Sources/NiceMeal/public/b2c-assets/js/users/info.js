app.controller('UserInfoCtrl', function($scope, $http, $timeout, $interval) {
    $scope.init = function() {
        $timeout(function() {
            angular.element('.md-content').removeClass('hidden');
            angular.element('#birth_day').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                orientation: "bottom",
            });
            $scope.field = [];
            $scope.field.disabled = [];
            $scope.field.temp = [];
            $scope.field.value = [];
            $scope.field.validate = [];
            $scope.selectedProfile = [];

            $scope.field.alterProfileTemp = [];
            $scope.field.newAlterProfileValue = [];
            $scope.field.alterProfileDisabled = [];

            $scope.menuStatus = false;

            //main info
            angular.forEach($scope.userField, function(value) {
                $scope.field.value[value] = $scope.user[value];
                $scope.field.disabled[value] = false;
            });

            //alter info
            angular.forEach($scope.alterProfiles, function(profile, index) {
                $scope.field.alterProfileTemp[index] = [];
                $scope.field.alterProfileDisabled[index] = [];
                angular.forEach($scope.alterProfileField, function(value, field_key) {
                    $scope.field.alterProfileDisabled[index][value] = false;
                });

            });

        }, 10);
    };

    $scope.editOrSave = function(field_key) {
        $scope.field.temp[field_key] = $scope.field.value[field_key];
        $scope.field.disabled[field_key] = !$scope.field.disabled[field_key];
    };

    $scope.cancelEdit = function(field_key) {
        $scope.field.value[field_key] = $scope.field.temp[field_key];
        $scope.field.disabled[field_key] = !$scope.field.disabled[field_key];
    };

    $scope.saveButton = function(field_key) {
        $scope.updateProfile();
        $scope.field.disabled[field_key] = !$scope.field.disabled[field_key];
    };

    $scope.updateProfile = function() {
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'profile': $scope.field.value
        };
        $http.post('/my-info/update/' + $scope.user.id, {
            full_name: $scope.field.value['full_name'],
            birth_day: $scope.field.value['birth_day'],
            phone: $scope.field.value['phone'],
            address: $scope.field.value['address'],
        }).then(function success(e) {
            $scope.errors = [];
            toastr.success("Profile updated!");
        }, function error() {
            // $scope.recordErrors(error);
        });
    };

    $scope.validPhone = function() {
        return !(!$scope.field.value['phone'] || $scope.field.value['phone'].length < 10 || $scope.field.value['phone'].charAt(0) != 0);
    };

    //--------------------------------------------------------------------------------------------------
    // handle button
    $scope.editOrSaveAlterProfile = function(id, field_key) {
        $scope.field.alterProfileTemp[id][field_key] = $scope.alterProfiles[id][field_key];
        $scope.field.alterProfileDisabled[id][field_key] = !$scope.field.alterProfileDisabled[id][field_key];
    };

    $scope.cancelEditAlterProfile = function(id, field_key) {
        $scope.alterProfiles[id][field_key] = $scope.field.alterProfileTemp[id][field_key];
        $scope.field.alterProfileDisabled[id][field_key] = !$scope.field.alterProfileDisabled[id][field_key];
    };

    $scope.saveAlterProfileButton = function(id, field_key) {
        $scope.updateAlterProfile(id, field_key);
        $scope.field.alterProfileDisabled[id][field_key] = !$scope.field.alterProfileDisabled[id][field_key];
    };

    //add alter profile
    $scope.addAlterProfile = function() {
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'alter_profile': $scope.field.newAlterProfileValue
        };
        $http.post('/my-info/add-profile', {
            email: $scope.field.newAlterProfileValue['email'],
            phone: $scope.field.newAlterProfileValue['phone'],
            address: $scope.field.newAlterProfileValue['address'],
        }).then(function success(response) {
            $scope.errors = [];
            toastr.success("Profile added!");
            $('#modalAddProfile').modal('toggle');
            $scope.alterProfiles.push({
                id: response.data.alter_profile.id,
                address: response.data.alter_profile.address,
                email: response.data.alter_profile.email,
                phone: response.data.alter_profile.phone
            });
        }, function error() {
            // $scope.recordErrors(error);
        });
    };

    //open confirm modal
    $scope.openConfirm = function(key) {
        $scope.selectedProfile = angular.copy($scope.alterProfiles[key]);
        $scope.selectedProfile.key = key;
        angular.element('#confirmationModal').modal("show");
    };

    // update alter profile
    $scope.updateAlterProfile = function(key, field_key) {
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'alter_profile': $scope.alterProfiles[key][field_key]
        };
        $http.post('/my-info/update-alter-profile/' + $scope.alterProfiles[key]['id'], {
            email: $scope.alterProfiles[key]['email'],
            phone: $scope.alterProfiles[key]['phone'],
            address: $scope.alterProfiles[key]['address'],
        }).then(function success(e) {
            $scope.errors = [];
            toastr.success("Profile updated!");
        }, function error() {
            // $scope.recordErrors(error);
        });
    };

    // delete alter profile
    $scope.deleteAlterProfile = function() {
        var data = {
            '_token': angular.element('meta[name=csrf-token]').attr('content'),
            'alter_profile': $scope.selectedProfile
        };
        console.log($scope.selectedProfile);
        $http.post('/my-info/delete-profile/' + $scope.selectedProfile.id, {
            data: data
        }).then(function success(e) {
            $scope.selectedProfile = [];
            $('#confirmationModal').modal('hide');
            $scope.alterProfiles.splice($scope.selectedProfile.key, 1);
            toastr.success("Profile delete!");
        }, function error() {
            // $scope.recordErrors(error);
        });
    };

    // validate phone
    $scope.validAlterPhone = function(id, field_key) {
        return !(!$scope.field.newAlterProfileValue[id][field_key] || $scope.field.newAlterProfileValue[id][field_key].length < 10 || $scope.field.newAlterProfileValue[id][field_key].charAt(0) != 0);
    };

    // validate email
    $scope.validEmail = function(id, field_key) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var validEmail = re.test(String($scope.field.newAlterProfileValue[id][field_key]).toLowerCase());
        if (!validEmail) {
            return false;
        } else if (!$scope.field.newAlterProfileValue[id][field_key]) {
            return false;
        } else {
            return true;
        }
    };


});