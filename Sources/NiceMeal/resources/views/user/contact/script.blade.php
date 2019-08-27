<script>
    //upload Contract
    document.getElementById("btnUploadContract").addEventListener("click", function() {
        document.getElementById("inputUploadContract").click();
    });

    document.getElementById("inputUploadContract").addEventListener("change", function() {
    if (document.getElementById("inputUploadContract").value) {
        document.getElementById("textUploadContract").innerHTML = document.getElementById("inputUploadContract").value.match(
        /[\/\\]([\w\d\s\.\-\(\)]+)$/
        )[1];
    } else {
        document.getElementById("textUploadContract").innerHTML = "No file chosen";
    }
    });

    //upload CV
    document.getElementById("btnUploadCV").addEventListener("click", function() {
        document.getElementById("inputUploadCV").click();
    });

    document.getElementById("inputUploadCV").addEventListener("change", function() {
    if (document.getElementById("inputUploadCV").value) {
        document.getElementById("textUploadCV").innerHTML = document.getElementById("inputUploadCV").value.match(
        /[\/\\]([\w\d\s\.\-\(\)]+)$/
        )[1];
    } else {
        document.getElementById("textUploadCV").innerHTML = "No file chosen";
    }
    });

     //upload Business License
    document.getElementById("btnUploadBL").addEventListener("click", function() {
        document.getElementById("inputUploadBL").click();
    });
    document.getElementById("inputUploadBL").addEventListener("change", function() {
    if (document.getElementById("inputUploadBL").value) {
        document.getElementById("textUploadBL").innerHTML = document.getElementById("inputUploadBL").value.match(
        /[\/\\]([\w\d\s\.\-\(\)]+)$/
        )[1];
    } else {
        document.getElementById("textUploadBL").innerHTML = "No file chosen";
    }
    });

    app.controller('submitCtrl',function($scope, $http){
        $scope.init = function() {
            $scope.error = {};
            $scope.district = '';
            $scope.minimum = '';
            $scope.from = '';
            $scope.to = '';
            $scope.fee = '';
            $scope.time_start = '';
            $scope.start_time = '';
            $scope.time_end = '';
            $scope.end_time = '';
            $scope.ri_restaurant_name = '';
            $scope.ri_address = '';
            $scope.ri_district = '';
            $scope.ri_ward = '';
            $scope.ri_phone = '';
            $scope.ri_email = '';
            $scope.ri_link = '';
            $scope.ri_food_cuisine = '';
            $scope.oi_fullname = '';
            $scope.owner_phone = '';
            $scope.owner_email = '';
            $scope.imgContract = '';
            $scope.imgCV = '';
            $scope.imgBusinessLicense = '';

            $scope.error['ri_restaurant_name'] = false;
            $scope.error['ri_address'] = false;
            $scope.error['ri_phone'] = false;
            $scope.error['ri_district'] = false;
            $scope.error['ri_ward'] = false;
            $scope.error['ri_email'] = false;
            $scope.error['ri_link'] = false;
            $scope.error['ri_food_cuisine'] = false;
            $scope.error['oi_fullname'] = false;
            $scope.error['owner_phone'] = false;
            $scope.error['owner_email'] = false;
            $scope.error['imgContract'] = false;
            $scope.error['imgCV'] = false;
            $scope.error['imgBusinessLicense'] = false;
        }
        $scope.deliveryLocation = [];
        $scope.tableDeliveryLocation = [];
        $scope.addDeliveryLocation= function(){
            $('#minimum').unmask();
            $('#from').unmask();
            $('#to').unmask();
            $('#fee').unmask();
            if ($scope.district != undefined && $scope.minimum != undefined&& $scope.from != undefined&& $scope.to != undefined&& $scope.fee != undefined) {
                var dl = {};
                dl['district_id'] = Number($scope.district);
                dl['min_order_amount']  = Number($('#minimum').val());
                dl['from']  = Number($('#from').val());
                dl['to']  = Number($('#to').val());
                dl['delivery_cost']  = Number($('#fee').val());
                dl = JSON.stringify(dl);
                $scope.deliveryLocation.push(dl);

                var tableDl = [];
                tableDl.district = $("#district option:selected").text();
                tableDl.minimum = Number($('#minimum').val());
                tableDl.from = Number($('#from').val());
                tableDl.to = Number($('#to').val());
                tableDl.fee = Number($('#fee').val());
                $scope.tableDeliveryLocation.push(tableDl);
                // CLEAR TEXTBOX.
                $scope.minimum = '';
                $scope.from = '';
                $scope.to = '';
                $scope.fee = '';
                $('#minimum').mask("#.##0", {reverse: true});
                $('#from').mask("#.##0", {reverse: true});
                $('#to').mask("#.##0", {reverse: true});
                $('#fee').mask("#.##0", {reverse: true});
            }
        }

        $scope.openingTime = [];
        $scope.tableOpeningTime = [];
        $scope.addOpeningTime = function(){
             //add to Restaurant Work Time Table
            var ot = {};
            ot.all_days = Number($scope.day);
            ot.all_times = Number($scope.time);
            ot.mon = $scope.item.mon;
            ot.tue = $scope.item.tue;
            ot.wed = $scope.item.wed;
            ot.thu = $scope.item.thu;
            ot.fri = $scope.item.fri;
            ot.sat = $scope.item.sat;
            ot.sun = $scope.item.sun;
            ot.from_time = $scope.start_time + ' ' + $scope.time_start;
            ot.to_time = $scope.end_time + ' ' + $scope.time_end;
            ot = JSON.stringify(ot);
            $scope.openingTime.push(ot);
            var day = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            var i =0;
            //all_days and all_times
            if( $scope.day == 1 && $scope.time == 1 )
            {
                for(i =0; i<= 6;i++)
                {
                    var tableOT = [];
                    tableOT.day = day[i];
                    tableOT.start_time = '12:00';
                    tableOT.time_start = 'AM';
                    tableOT.end_time = '11:59';
                    tableOT.time_end = 'PM';
                    $scope.tableOpeningTime.push(tableOT);
                }
            }
            // specific_day and all_times
            else if($scope.day != 1 && $scope.time == 1)
            {
                if($scope.item.mon == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Monday';
                    tableOT.start_time = '12:00';
                    tableOT.time_start = 'AM';
                    tableOT.end_time = '11:59';
                    tableOT.time_end = 'PM';
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.tue == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Tuesday';
                    tableOT.start_time = '12:00';
                    tableOT.time_start = 'AM';
                    tableOT.end_time = '11:59';
                    tableOT.time_end = 'PM';
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.wed == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Wednesday';
                    tableOT.start_time = '12:00';
                    tableOT.time_start = 'AM';
                    tableOT.end_time = '11:59';
                    tableOT.time_end = 'PM';
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.thu == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Thursday';
                    tableOT.start_time = '12:00';
                    tableOT.time_start = 'AM';
                    tableOT.end_time = '11:59';
                    tableOT.time_end = 'PM';
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.fri == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Friday';
                    tableOT.start_time = '12:00';
                    tableOT.time_start = 'AM';
                    tableOT.end_time = '11:59';
                    tableOT.time_end = 'PM';
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.sat == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Saturday';
                    tableOT.start_time = '12:00';
                    tableOT.time_start = 'AM';
                    tableOT.end_time = '11:59';
                    tableOT.time_end = 'PM';
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.sun == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Sunday';
                    tableOT.start_time = '12:00';
                    tableOT.time_start = 'AM';
                    tableOT.end_time = '11:59';
                    tableOT.time_end = 'PM';
                    $scope.tableOpeningTime.push(tableOT);
                }
            }
            // all_days and specific_time
            else if($scope.day == 1 && $scope.time != 1)
            {
                for(i =0; i<= 6;i++)
                {
                    var tableOT = [];
                    tableOT.day = day[i];
                    tableOT.start_time = $scope.start_time + ":" + "00";
                    tableOT.time_start = $scope.time_start;
                    tableOT.end_time = $scope.end_time + ":" + "00";
                    tableOT.time_end = $scope.time_end;
                    $scope.tableOpeningTime.push(tableOT);
                }
                $scope.start_time = '';
                $scope.end_time = '';
            }
             // specific_day and specific_time
            else if($scope.day != 1 && $scope.time != 1)
            {
                if($scope.item.mon == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Monday';
                    tableOT.start_time = $scope.start_time + ":" + "00";
                    tableOT.time_start = $scope.time_start;
                    tableOT.end_time = $scope.end_time + ":" + "00";
                    tableOT.time_end = $scope.time_end;
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.tue == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Tuesday';
                    tableOT.start_time = $scope.start_time + ":" + "00";
                    tableOT.time_start = $scope.time_start;
                    tableOT.end_time = $scope.end_time + ":" + "00";
                    tableOT.time_end = $scope.time_end;
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.wed == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Wednesday';
                    tableOT.start_time = $scope.start_time + ":" + "00";
                    tableOT.time_start = $scope.time_start;
                    tableOT.end_time = $scope.end_time + ":" + "00";
                    tableOT.time_end = $scope.time_end;
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.thu == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Thursday';
                    tableOT.start_time = $scope.start_time + ":" + "00";
                    tableOT.time_start = $scope.time_start;
                    tableOT.end_time = $scope.end_time + ":" + "00";
                    tableOT.time_end = $scope.time_end;
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.fri == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Friday';
                    tableOT.start_time = $scope.start_time + ":" + "00";
                    tableOT.time_start = $scope.time_start;
                    tableOT.end_time = $scope.end_time + ":" + "00";
                    tableOT.time_end = $scope.time_end;
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.sat == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Saturday';
                    tableOT.start_time = $scope.start_time + ":" + "00";
                    tableOT.time_start = $scope.time_start;
                    tableOT.end_time = $scope.end_time + ":" + "00";
                    tableOT.time_end = $scope.time_end;
                    $scope.tableOpeningTime.push(tableOT);
                }
                if($scope.item.sun == true)
                {
                    var tableOT = [];
                    tableOT.day = 'Sunday';
                    tableOT.start_time = $scope.start_time + ":" + "00";
                    tableOT.time_start = $scope.time_start;
                    tableOT.end_time = $scope.end_time + ":" + "00";
                    tableOT.time_end = $scope.time_end;
                    $scope.tableOpeningTime.push(tableOT);
                }
                $scope.start_time = '';
                $scope.end_time = '';
            }
        }

        $scope.validateOpeningTime = function(){
            if($scope.day == 1 && $scope.time == 1)
            {
                return true;
            }
            else if ($scope.day != 1 && $scope.time == 1)
            {
                return $scope.item.mon || $scope.item.tue || $scope.item.wed || $scope.item.thu || $scope.item.fri || $scope.item.sat || $scope.item.sun;
            }
            else if ($scope.day == 1 && $scope.time != 1)
            {
                var condition1 = $scope.time !== "" && $scope.start_time !== ""
                && $scope.time_start !== "" && $scope.end_time !== "" && $scope.time_end !== "";
                var condition2 = $scope.time !== null && $scope.start_time !== null
                && $scope.time_start !== null && $scope.end_time !== null && $scope.time_end !== null;
                var condition3 = $scope.time !== undefined && $scope.start_time !== undefined
                && $scope.time_start !== undefined && $scope.end_time !== undefined && $scope.time_end !== undefined;
                return condition1 && condition2 && condition3 && $scope.start_time <= 12 && $scope.end_time <= 12;
            }
            else if ($scope.day != 1 && $scope.time != 1)
            {
                var condition1 = $scope.time !== "" && $scope.start_time !== ""
                && $scope.time_start !== "" && $scope.end_time !== "" && $scope.time_end !== "";
                var condition2 = $scope.time !== null && $scope.start_time !== null
                && $scope.time_start !== null && $scope.end_time !== null && $scope.time_end !== null;
                var condition3 = $scope.time !== undefined && $scope.start_time !== undefined
                && $scope.time_start !== undefined && $scope.end_time !== undefined && $scope.time_end !== undefined;
                var condition4 = $scope.item.mon || $scope.item.tue || $scope.item.wed || $scope.item.thu || $scope.item.fri || $scope.item.sat || $scope.item.sun;
                return condition1 && condition2 && condition3 && condition4 && $scope.start_time <= 12 && $scope.end_time <= 12;
            }
        }

        $scope.validateDeliveryLocation = function(){
            var condition1 = $scope.district !== "" && $scope.minimum !== ""
            && $scope.from !== "" && $scope.to !== "" && $scope.fee !== "";
            var condition2 = $scope.district !== null && $scope.minimum !== null
            && $scope.from !== null && $scope.to !== null && $scope.fee !== null;
            var condition3 = $scope.district !== undefined && $scope.minimum !== undefined
            && $scope.from !== undefined && $scope.to !== undefined && $scope.fee !== undefined;
            return condition1 && condition2 && condition3;
        }

        $scope.imageUploadContract = function(event){
            var files = event.target.files;
            $scope.imgContract =files[0];
        }

        $scope.imageUploadCV = function(event){
            var files = event.target.files;
            $scope.imgCV =files[0];
        }

        $scope.imageUploadBusinessLicense = function(event){
            var files = event.target.files;
            $scope.imgBusinessLicense =files[0];
        }

        $scope.validateFoodCuisine = function(){
            return !$scope.ri_food_cuisine.length==0;
        }

        $scope.validateDLTable = function(){
            return !$scope.tableDeliveryLocation.length==0;
        }

        $scope.validateOTTable = function(){
            return !$scope.tableOpeningTime.length==0;
        }

        $scope.validateService = function(){
            if($scope.item.delivery || $scope.item.pickup){
                return true;
            }
            return false;
        }

        $scope.validatePayment = function(){
            if($scope.item.cod || $scope.item.pay_online){
                return true;
            }
            return false;
        }

        $scope.validateUploadContract = function(){
            if($scope.imgContract != undefined && $scope.imgContract.size < 5242880){
                return true;
            }
            return false;
        }

        $scope.validateUploadCV = function(){
            if($scope.imgCV != undefined && $scope.imgCV.size < 5242880){
                return true;
            }
            return false;
        }

        $scope.validateUploadBusinessLicense = function(){
            if($scope.imgBusinessLicense != undefined && $scope.imgBusinessLicense.size < 5242880){
                return true;
            }
            return false;
        }

        $scope.submitForm = function($event){
            $event.preventDefault();
             if(!$scope.validateFoodCuisine()){
                toastr.error("Please Choose at least one Food Cuisine");
                return;
            }
            if(!$scope.validateService()){
                toastr.error("Please Choose at least one Service");
                return;
            }
            if(!$scope.validatePayment()){
                toastr.error("Please Choose at least one Payment");
                return;
            }
            if(!$scope.validateDLTable()){
                toastr.error("Please insert Data in Delivery Location Table");
                return;
            }
            if(!$scope.validateOTTable()){
                toastr.error("Please insert Data in Opening Time Table");
                return;
            }

             if(!$scope.validateUploadContract()){
                toastr.error("Please choose Contract File and The size is not bigger 5mb");
                return;
            }

            if(!$scope.validateUploadCV()){
                toastr.error("Please choose CV File and The size is not bigger 5mb");
                return;
            }

            if(!$scope.validateUploadBusinessLicense()){
                toastr.error("Please choose Business License File and The size is not bigger 5mb");
                return;
            }

            var formData = new FormData();
            formData.append("ri_restaurant_name", $scope.ri_restaurant_name);
            formData.append("ri_address", $scope.ri_address);
            formData.append("ri_district", $scope.ri_district);
            formData.append("ri_ward", $("select[name='ri_ward']").val());
            formData.append("ri_phone", $scope.ri_phone);
            formData.append("ri_email", $scope.ri_email);
            formData.append("ri_link", $scope.ri_link);
            formData.append("ri_food_cuisine", JSON.stringify($scope.ri_food_cuisine));
            formData.append("delivery", $scope.item.delivery);
            formData.append("pickup", $scope.item.pickup);
            formData.append("cod_payment", $scope.item.cod);
            formData.append("online_payment", $scope.item.pay_online);
            formData.append("delivery_location", JSON.stringify($scope.deliveryLocation));
            formData.append("opening_time", JSON.stringify($scope.openingTime));
            formData.append("oi_fullname", $scope.oi_fullname);
            formData.append("owner_email", $scope.owner_email);
            formData.append("owner_phone", $scope.owner_phone);
            formData.append("imgContract", $scope.imgContract);
            formData.append("imgCV", $scope.imgCV);
            formData.append("imgBusinessLicense", $scope.imgBusinessLicense);
            $http({
                url:'{{url("/contact/submit-restaurant")}}',
                method:"post",
                headers: {
                    'Content-Type': undefined
                },
                cache: false,
                contentType: false,
                processData: false,
                data: formData
            }).then(function(response){
                var message = response.data.message;
                if(!response.data.success ){
                    angular.forEach($scope.error,function(value,key){
                        if(message[key]){
                            $scope.error[key] = true;
                        }else{
                            $scope.error[key] = false;
                        }
                    });
                }else {
                    $scope.error['ri_restaurant_name'] = false;
                    $scope.error['ri_address'] = false;
                    $scope.error['ri_district'] = false;
                    $scope.error['ri_ward'] = false;
                    $scope.error['ri_phone'] = false;
                    $scope.error['ri_email'] = false;
                    $scope.error['ri_link'] = false;
                    $scope.error['ri_food_cuisine'] = false;
                    $scope.error['oi_fullname'] = false;
                    $scope.error['owner_phone'] = false;
                    $scope.error['owner_email'] = false;
                    $scope.error['imgContract'] = false;
                    $scope.error['imgCV'] = false;
                    $scope.error['imgBusinessLicense'] = false;
                    toastr.success("Success");
                }

            });
        }

    });

    setTimeout(function(){
        $scope = angular.element('[ng-controller=submitCtrl]').scope();
        $scope.init();
    },1000);

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    $(".district-select2").select2();
    $(".ward-select2").select2();
    $(".tags-select2").select2();
    $(document).ready(function(){
        $('#specific_day').hide();
        $('.start-time').hide();
        $('.end-time').hide();
        $('#day').change(function () {
            if($('#day').val() == 1){
            $('#specific_day').hide();
            $('#mon').prop('checked',true); $scope.item.mon = true;
            $('#tue').prop('checked',true); $scope.item.tue = true;
            $('#wed').prop('checked',true); $scope.item.wed = true;
            $('#thu').prop('checked',true); $scope.item.thu = true;
            $('#fri').prop('checked',true); $scope.item.fri = true;
            $('#sat').prop('checked',true); $scope.item.sat = true;
            $('#sun').prop('checked',true); $scope.item.sun = true;
            }
            else if($('#day').val() == 0){
                $('#specific_day').show();
                $('#mon').prop('checked',false); $scope.item.mon = false;
                $('#tue').prop('checked',false); $scope.item.tue = false;
                $('#wed').prop('checked',false); $scope.item.wed = false;
                $('#thu').prop('checked',false); $scope.item.thu = false;
                $('#fri').prop('checked',false); $scope.item.fri = false;
                $('#sat').prop('checked',false); $scope.item.sat = false;
                $('#sun').prop('checked',false); $scope.item.sun = false;
            }
        });

        $('#time').change(function () {
            if($('#time').val() == 1){
                $('.start-time').hide();
                $('.end-time').hide();
                $('#start_time').val(12); $scope.start_time = 12;
                $('#time_start').val('AM'); $scope.time_start = 'AM';
                $('#end_time').val(12); $scope.end_time = 12;
                $('#time_end').val('PM'); $scope.time_end = 'PM';
            }
            else if($('#time').val() == 0){
                $('.start-time').show();
                $('.end-time').show();
                $('#start_time').val(''); $scope.start_time = '';
                $('#time_start').val(''); $scope.time_start = '';
                $('#end_time').val(''); $scope.end_time = '';
                $('#time_end').val(''); $scope.time_end = '';
            }
        });
    });
    $('#minimum').mask("#.##0", {reverse: true});
    $('#from').mask("#.##0", {reverse: true});
    $('#to').mask("#.##0", {reverse: true});
    $('#fee').mask("#.##0", {reverse: true});

    $(".tags-select2").on('select2:close', function(e) {
        var select2SearchField = $(this).parent().find('.select2-search__field'),
            setfocus = setTimeout(function() {
                select2SearchField.focus();
            }, 100);
    });

    $(".select2.tags-select2").select2({
        maximumSelectionLength: 3,
        language: {
            maximumSelected: function (e) {
                return "{{trans('admin.restaurants.maximum_selection')}}";
            }
        }
    });


    $(document).ready(function(){
        $("select[name='ri_district']").on('change', function() {
        // var district_id = $("select[name='ri_district']").val();
        var district_id = Number($scope.ri_district);
        var url = "/locations/" + district_id + "/wards";
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                success:function(res){
                    console.log(res);
                }
            });
        })
        function getWards(district_id) {
        var url = "/locations/" + district_id + "/wards";
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                success:function(res){
                    // console.log(res);
                    $("select[name='ri_ward']").html('');
                    $.each(res.wards, function(key, ward) {
                        $("select[name='ri_ward']").append("<option value=" + ward.id + " name=" + ward.id + ">" + ward.name + "</option>");
                    })
                }
            });
        }
        $("select[name='ri_district']").on('change', function() {
            getWards($(this).val());
            // console.log(getWards($(this).val()));
        })
    });

</script>
