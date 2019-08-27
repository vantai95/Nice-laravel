@extends('layouts.app')
@section('content')

    <div class="md-content restaurant hidden" ng-controller="UserInfoCtrl">

    @include('user.social-tools')

    <!-- hero -->
        <section class="hero" style="background-image: url('https://i.imgur.com/n1shiqq.jpg')">
            <div class="info-text">My Info</div>
        </section>
        <!-- End / hero -->


        <!-- Section -->
        <div class="container">
            <div class="row user__info">
                <ui-view>
                    @include('user.info.user-info')
                </ui-view>
            </div>
        </div>

    @include('user.info.add_profile_modal')
    @include('user.info.confirm_delete_modal')


    <!-- End / Section -->
    </div>

@endsection

@section('extra_scripts')
    <script src="/b2c-assets/js/users/info.js"></script>

    <script>
        setTimeout(function () {
            $scope = angular.element('[ng-controller=UserInfoCtrl]').scope();
            $scope.user = {!! $user !!};
            $scope.userField = {!! $userField !!};
            $scope.alterProfiles = {!! $alterProfiles !!};
            $scope.alterProfileField = {!! $alterProfileField !!};
            {{--$scope.categories = {!! $categories !!};--}}
            {{--$scope.workTimes = {!! $workingTimes !!};--}}
            {{--$scope.deliverySettingsLeft = {!! $deliverySettingsLeft !!};--}}
            {{--$scope.deliverySettingsRight = {!! $deliverySettingsRight !!};--}}
            $scope.init();

            $('.widget-categories.hidden').removeClass('hidden');
            $('.category-wrapper.hidden').removeClass('hidden');
        }, 200)

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function blockSpecialChar(e) {
            var k;
            document.all ? k = e.keyCode : k = e.which;
            return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
        }

        $(".allow-number-only").on("keypress keyup blur", function (event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    </script>

    {{--<script>--}}
    {{--$('#userForm').validate({--}}
    {{--rules: {--}}
    {{--phone: {--}}
    {{--matches: "[0-9]+",--}}
    {{--minlength: 10,--}}
    {{--maxlength: 11--}}
    {{--}--}}
    {{--}--}}
    {{--});--}}
    {{--</script>--}}

@endsection
