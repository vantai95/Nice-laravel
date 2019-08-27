<script>
    var listTBD = [];
    $(function (){
        loadTBDList();
    })

    function loadTBDList(){
        $.ajax({
            url:"{{ url('admin/'.$res->res_Slug.'/time-base-display-rules/getList') }}",
            type:"get",
            dataType:"json",
            success:function(json){
                var data = json.data;
                var item = '';
                data.forEach(function(row){
                    item += '<div class="col-lg-6 dish-extra-item dish-tbd" data-tbdid="'+row.id+'">'
                    +'<input type="hidden" name="tbds['+row.id+']" value="'+row.id+'">'
                            +'<div class="col-sm-12">'
                                +'<div class="input-group">'
                                    +'<button type="button" onclick="openTBDDetail(' + row.id + ')" class="btn btn-warning" style="font-size: 11px;">'+row.name+ '</button>'
                                        +'<div class="input-group-append">'
                                            +'<span class="input-group-text" onclick="addTBDToDish(this)"><i class="fa fa-plus"></i></span>'
                                        +'</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    listTBD[row.id] = row;
                });
                $('#list_tbd').append(item);
            }
        });
    }

    function openTBDDetail(id) {
        // console.log(listTBD[id]);

        $('#tbdDetail .modal-title').text(listTBD[id].name);
        var specificPeriod = "<p'><b>" + "{{trans('admin.time_base_pricing_rules.detail.period')}}: " + "</b>"
            + "{{trans('admin.time_base_pricing_rules.detail.specific_period')}}" + "</p>"
            + "<p> - " + "{{trans('admin.time_base_pricing_rules.detail.from_date')}}: " + formatDate(listTBD[id].from_date) + "</p>"
            + "<p> - " + "{{trans('admin.time_base_pricing_rules.detail.to_date')}}: " + formatDate(listTBD[id].to_date) + "</p><p id='all_days'></p>";

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
            if (listTBD[id][day] == 1) {
                daysInWeek = daysInWeek + '<span>' + dayFullNames[key] + ((key !== dayNames.length-2) ? ',' : '.') + '</span>';
            }
        });

        var specificDays = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.days_in_week')}}: " + "</b>"
            + daysInWeek + "</p><p id='all_times'></p>";

        if(listTBD[id].from_time  && listTBD[id].to_time) {
            var specificTime = "<p'><b>" + "{{trans('admin.time_base_pricing_rules.detail.display_time')}}: " + "</b>"
                + "{{trans('admin.time_base_pricing_rules.detail.specific_time')}}" + "</p>"
                + "<p> - " + "{{trans('admin.time_base_pricing_rules.detail.from_time')}}: " + (listTBD[id].from_time).split(":")[0] + ":" + (listTBD[id].from_time).split(":")[1] + "</p>"
                + "<p> - " + "{{trans('admin.time_base_pricing_rules.detail.to_time')}}: " + (listTBD[id].to_time).split(":")[0] + ":" + (listTBD[id].to_time).split(":")[1] + "</p>";
        }

        var allTimes = "<p><b>" + "{{trans('admin.time_base_pricing_rules.detail.display_time')}}: " + "</b>"
            + "{{trans('admin.time_base_pricing_rules.detail.all_times')}}" + "</p>";

        if (listTBD[id].period_type) {
            $('#tbdDetail .modal-body').html(specificPeriod);
        } else {
            $('#tbdDetail .modal-body').html(foreverPeriod);
        }

        if(listTBD[id].all_days){
            $('#tbdDetail .modal-body p#all_days').html(allDays);
        } else {
            $('#tbdDetail .modal-body p#all_days').html(specificDays);
        }

        if(listTBD[id].all_times){
            $('#tbdDetail .modal-body p#all_times').html(allTimes);
        } else {
            $('#tbdDetail .modal-body p#all_times').html(specificTime);
        }

        $('#tbdDetail').modal('show');
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

    

    function addTBDToDish(element){
        
        var parent = $(element).parents('.dish-extra-item').clone();

        var value = parent.data('tbdid');
        if($('#tbds_zone').children('[data-tbdid="'+value+'"]').data('tbdid')){
            return;
        }

        parent.find('.input-group-append').remove();
        parent.find('.input-group').append(
            '<div class="input-group-append">'
                +'<span onclick="removeTBD(this)" class="input-group-text"><i class="fa fa-close"></i></span>'
            +'</div>'
        );

        $('#tbds_zone').append(parent);
    }

    function removeTBD(element){
        var item = $(element).parents('.dish-extra-item');
        item.remove();
    }

</script>