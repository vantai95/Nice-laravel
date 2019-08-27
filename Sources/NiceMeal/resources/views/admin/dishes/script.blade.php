<script>

    var listTBP = [];
    var listTBD = [];

    @if(Auth::user()->isAdmin())
        $('#restaurant_id').change(function(){
            
            var restaurant_id = $(this).val();
            $('#category_id').html("<option disabled selected>--@lang('admin.dishes.forms.restaurant_first')--</option>");
            $.ajax({
                url:"{{ url('admin/restaurants/categories') }}/"+restaurant_id,
                type:"get",
                dataType:"json",
                success:function(json){
                    var data = json.data;
                    data.forEach(function(row){
                        var option = new Option(row.title_en,row.id,true,true);
                        $('#category_id').append(option).trigger('change');
                    });
                }
            });

            $('#list_customization').html('');
            $.ajax({
                url:"{{ url('admin/customizations/customizationList/') }}/"+restaurant_id,
                type:"get",
                dataType:"json",
                success:function(json){
                    var data = json.data;
                    var item = '';
                    data.forEach(function(row){
                        item += '<div class="col-lg-6 draggable" data-customizationid="'+row.id+'">'
                        +'<input type="hidden" name="customizations['+row.id+']" value="'+row.id+'">'
                                +'<div class="col-sm-12">'
                                    +'<div class="input-group">'
                                        +'<button type="button" class="btn btn-primary">'+row.name_en+'(djksajd)</button>'
                                            +'<div class="input-group-append">'
                                                +'<span onclick="showCustomization('+row.id+')" class="input-group-text"><i class="fa fa-edit"></i></span>'
                                            +'</div>'
                                    +'</div>'
                                +'</div>'
                            +'</div>';
                        listCustomization[row.id] = row;
                    });
                    $('#list_customization').append(item);
                },
                complete:function(){
                    $( ".draggable" ).draggable({
                        helper: 'clone'
                    });
                }
            });
        });
    @endif

    @if(isset($dish))

    $(function(){
        loadDishCustomization();
        loadDishTBD();
        loadDishTBP();
    })
    
    function loadDishCustomization(){
        $('#customizations_zone').html('');
        var url = "{{ url('admin/'.$res->res_Slug.'/dishes/dishCustomizations',$dish->id) }}";
        $.ajax({
            url:url,
            type:"get",
            dataType:"json",
            success:function(json){
                var data = json.data;
                var append_str = '';
                data.forEach(function(row){
                                        
                    var description = '';
                    if(row.required){
                        description+='required';
                    }else{
                        description+='optional';
                    }
                    if(row.selection_type==1){
                        description+=', single choice ';
                    }
                    if(row.selection_type==2){
                        description+=', multiple choice';
                    }

                    append_str+='<div class="col-lg-6 ui-draggable ui-draggable-handle dish-extra-item dish_customization" data-customizationid="'+row.id+'">'
                        +'<input type="hidden" name="customizations['+row.id+']" value="'+row.id+'">'
                        +'<div class="col-sm-12">'
                            +'<div class="input-group"><button type="button" class="btn btn-primary" style="font-size:11px;white-space: normal;word-wrap: break-word;">'
                            +row.name_en
                            +'<br/><span class="cust-des"> ['+description+']</span> </button>'
                                +'<div class="input-group-append"><span onclick="removeFromList(this)" class="input-group-text"><i class="fa fa-close"></i></span></div>'
                            +'</div>'
                        +'</div>'
                    +'</div>';
                });
                $('#customizations_zone').append(append_str);
            }

        });
    }

    function loadDishTBD(){
        $('#tbds_zone').html('');
        var url = "{{ url('admin/'.$res->res_Slug.'/dishes/dishTBDs',$dish->id) }}";
        $.ajax({
            url:url,
            type:"get",
            dataType:"json",
            success:function(json){
                var data = json.data;
                var append_str = '';
                data.forEach(function(row){
                    append_str+='<div class="col-lg-6 dish-extra-item dish-tbd" data-tbdid='+row.id+'>'
                        +'<input type="hidden" name="tbds['+row.id+']" value="'+row.id+'">'
                        +'<div class="col-sm-12">'
                            +'<div class="input-group"><button type="button" onclick="openTBDDetail(' + row.id + ')" class="btn btn-warning">'+row.name+'</button>'
                                +'<div class="input-group-append"><span onclick="removeTBD(this)" class="input-group-text"><i class="fa fa-close"></i></span></div>'
                            +'</div>'
                        +'</div>'
                    +'</div>';
                    listTBD[row.id] = row;
                });
                $('#tbds_zone').append(append_str);
            }

        });
    }

    function loadDishTBP(){
        $('#tbps_zone').html('');
        var url = "{{ url('admin/'.$res->res_Slug.'/dishes/dishTBPs',$dish->id) }}";
        $.ajax({
            url:url,
            type:"get",
            dataType:"json",
            success:function(json){
                var data = json.data;
                var append_str = '';
                data.forEach(function(row){
                    var smallTitle = (row.type == 0) ? '<br><small>(' + row.value + ' %)</small>' : '<br><small>(' + row.value + 'VNĐ)</small>';
                    append_str+='<div class="col-lg-6 dish-extra-item dish-tbp" data-tbpid='+row.id+'>'
                        +'<input type="hidden" name="tbps['+row.id+']" value="'+row.id+'">'
                        +'<div class="col-sm-12">'
                        +'<div class="input-group"><button type="button" onclick="openTBPDetail(' + row.id + ')" class="btn btn-primary">'+row.name+ smallTitle + '</button>'
                        +'<div class="input-group-append"><span onclick="removeTBP(this)" class="input-group-text"><i class="fa fa-close"></i></span></div>'
                        +'</div>'
                        +'</div>'
                        +'</div>';
                    listTBP[row.id] = row;
                });
                $('#tbps_zone').append(append_str);
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

        if(listTBD[id].from_time  && listTBD[id].to_time){
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
    @endif

    $(window).scroll(function(){
        var elementPosition = $('#customizations').offset();
        if($(window).scrollTop() > elementPosition.top){
              $('#customizations').css('position','fixed').css('top','10').css('width','440');
        }    
    });

    $('#submitForm').on('submit', function(e) {
      
      if($('#description-en-id').summernote('isEmpty')) {
        // cancel submit
        $('.required-des-en').text('The English Description field is required.');
        $("html, body").animate({ scrollTop: 0 }, "slow");
        e.preventDefault();
      }
      else {
        // do action
      }
    });
</script>