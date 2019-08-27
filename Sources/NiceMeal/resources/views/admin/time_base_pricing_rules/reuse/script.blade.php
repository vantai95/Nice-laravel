<script>
    var listTBP = [];
    $(function () {
        loadTBPList();
    })

    function loadTBPList() {
        $.ajax({
            url: "{{ url('admin/'.$res->res_Slug.'/time-base-pricing-rules/getList') }}",
            type: "get",
            dataType: "json",
            success: function (json) {
                var data = json.data;
                var item = '';
                data.forEach(function (row) {
                    var smallTitle = (row.type == 0) ? '<br><small>(' + row.value + ' %)</small>' : '<br><small>(' + row.value + 'VNĐ)</small>';
                    item += '<div class="col-lg-6 dish-extra-item dish-tbp" data-tbpid="' + row.id + '">'
                        + '<input type="hidden" name="tbps[' + row.id + ']" value="' + row.id + '">'
                        + '<div class="col-sm-12">'
                        + '<div class="input-group">'
                        + '<button type="button" onclick="openTBPDetail(' + row.id + ')" class="btn btn-primary" style="font-size: 11px;">' + row.name + smallTitle + '</button>'
                        + '<div class="input-group-append">'
                        + '<span class="input-group-text" onclick="addTBPToDish(this)"><i class="fa fa-plus"></i></span>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>';
                    listTBP[row.id] = row;
                });
                $('#list_tbp').append(item);
            }
        });
    }

    function openTBPDetail(id) {
        // console.log(listTBP[id]);

        $('#tbpDetail .modal-title').text(listTBP[id].name);
        var specificPeriod = "<p'><b>" + "{{trans('admin.time_base_pricing_rules.detail.period')}}: " + "</b>"
            + "{{trans('admin.time_base_pricing_rules.detail.specific_period')}}" + "</p>"
            + "<p> - " + "{{trans('admin.time_base_pricing_rules.detail.from_date')}}: " + formatDate(listTBP[id].from_date) + "</p>"
            + "<p> - " + "{{trans('admin.time_base_pricing_rules.detail.to_date')}}: " + formatDate(listTBP[id].to_date) + "</p><p id='all_days'></p>";

        var foreverPeriod = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.period')}}: " + "</b>"
            + "{{trans('admin.time_base_pricing_rules.detail.forever')}}" + "</p><p id='all_days'></p>";

        var allDays = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.days_in_week')}}: " + "</b>"
            + "{{trans('admin.time_base_pricing_rules.detail.all_days')}}" + "</p><p id='all_times'></p>";

        // create an day array from const
        @php
            $dayFullNames = [];
            foreach(\App\Http\Controllers\Controller::WEEKNAME as $index => $dayName)
                array_push($dayFullNames, trans('admin.time_base_pricing_rules.detail.'.$dayName));
        @endphp

        var dayNames = {!! json_encode(\App\Http\Controllers\Controller::WEEKNAME) !!};
        var dayFullNames = {!! json_encode($dayFullNames) !!};

        var daysInWeek = '';
        $.each(dayNames, function(key, day) {
            //get all specific day if day has value = true
            if (listTBP[id][day] == 1) {
                daysInWeek = daysInWeek + '<span>' + dayFullNames[key] + ((key !== dayNames.length-2) ? ',' : '.') + '</span>';
            }
        });

        var specificDays = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.days_in_week')}}: " + "</b>"
            + daysInWeek + "</p><p id='all_times'></p>";

        if(listTBP[id].from_time  && listTBP[id].to_time) {
            var specificTime = "<p'><b>" + "{{trans('admin.time_base_pricing_rules.detail.display_time')}}: " + "</b>"
                + "{{trans('admin.time_base_pricing_rules.detail.specific_time')}}" + "</p>"
                + "<p> - " + "{{trans('admin.time_base_pricing_rules.detail.from_time')}}: " + (listTBP[id].from_time).split(":")[0] + ":" + (listTBP[id].from_time).split(":")[1] + "</p>"
                + "<p> - " + "{{trans('admin.time_base_pricing_rules.detail.to_time')}}: " + (listTBP[id].to_time).split(":")[0] + ":" + (listTBP[id].to_time).split(":")[1] + "</p><p id='type'></p>";
        }

        var allTimes = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.display_time')}}: " + "</b>"
            + "{{trans('admin.time_base_pricing_rules.detail.all_times')}}" + "</p><p id='type'></p>";

        var percentType = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.type')}}: " + "</b>"
            + "{{trans('admin.time_base_pricing_rules.detail.percent')}}" + "</p><p id='value'></p>";

        var priceType = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.type')}}: " + "</b>"
            + "{{trans('admin.time_base_pricing_rules.detail.price')}}" + "</p><p id='value'></p>";

        var priceValue = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.value')}}: " + "</b>"
            + listTBP[id].value + " VNĐ</p>";

        var percentValue = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.value')}}: " + "</b>"
            + listTBP[id].value + "%</p>";

        if (listTBP[id].period_type) {
            $('#tbpDetail .modal-body').html(specificPeriod);
        } else {
            $('#tbpDetail .modal-body').html(foreverPeriod);
        }

        if(listTBP[id].all_days){
            $('#tbpDetail .modal-body p#all_days').html(allDays);
        } else {
            $('#tbpDetail .modal-body p#all_days').html(specificDays);
        }

        if(listTBP[id].all_times){
            $('#tbpDetail .modal-body p#all_times').html(allTimes);
        } else {
            $('#tbpDetail .modal-body p#all_times').html(specificTime);
        }

        if(listTBP[id].type){
            $('#tbpDetail .modal-body p#type').html(priceType);
            $('#tbpDetail .modal-body p#value').html(priceValue);
        } else {
            $('#tbpDetail .modal-body p#type').html(percentType);
            $('#tbpDetail .modal-body p#value').html(percentValue);
        }

        $('#tbpDetail').modal('show');
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('-');
    }

    function addTBPToDish(element) {

        var parent = $(element).parents('.dish-extra-item').clone();

        var value = parent.data('tbpid');
        if ($('#tbps_zone').children('[data-tbpid="' + value + '"]').data('tbpid')) {
            return;
        }

        parent.find('.input-group-append').remove();
        parent.find('.input-group').append(
            '<div class="input-group-append">'
            + '<span onclick="removeTBP(this)" class="input-group-text"><i class="fa fa-close"></i></span>'
            + '</div>'
        );

        $('#tbps_zone').append(parent);
    }

    function removeTBP(element) {
        var item = $(element).parents('.dish-extra-item');
        item.remove();
    }

</script>