<script>

@if(!isset($work_times))
  var specific_time_count = 0;
@else
  var specific_time_count = {{ $work_times->time_setting->time_setting_details->max('id') + 1 }};
@endif

$(document).ready(function () {



    $('.validate-message').hide();

    $('.validate-message').hide();

    allTimes($('#all_times').val());

    allDateInWeek($('#all_days').val());

    chooseSpecialDate($('#has_special_date').val());

    $('#special_date').datepicker({
       language: 'en',
       format: 'dd-mm-yyyy',
       autoclose: true,
       clearBtn: true,
       orientation: "bottom left"
   });

    //time picker
    $('#from_time').timepicker({
        format: 'HH:mm',
        showMeridian: false,
        minuteStep: 1,
    });
    $('#to_time').timepicker({
        format: 'HH:mm',
        showMeridian: false,
        minuteStep: 1,
    });

    $('.timepicker').timepicker({
        format: 'HH:mm',
        showMeridian: false,
        minuteStep: 1,
    });
});

$('#all_days').change(function () {
  allDateInWeek($(this).val());
});

$('#has_special_date').change(function(){
  chooseSpecialDate($(this).val());
});

$('#all_times').change(function () {
  allTimes($(this).val());
});

function allDateInWeek(allDateInWeek){
  if (allDateInWeek == '0') {
      $('#specific_date').show();
  } else {
      $('#specific_date').hide();
      $('#specific_date').find('input[type=checkbox]').each(function (index) {
          $(this).prop('checked', false);
      })
  }
}

function hourToSecond(hhii){
    var time = hhii.split(":");
    var hour = Number(time[0]);
    var minute = Number(time[1]);
    return hour * 3600 + minute * 60;
}
$('#submitButton').click(function(){
  validateTime();
});

function validateTime(){
    var element = $('#specific_time').find('.time-row');
    var flag= true;
    if($('#all_times').val() == 0){ 
      element.each(function(key,row){
        var currentId = $(row).data('none-special-time-id');
        var fromTime = $("input[name='specific_time["+currentId+"][from_time]']").val();
        var toTime = $("input[name='specific_time["+currentId+"][to_time]']").val();
        var fromTime1 = (hourToSecond(fromTime));
        var toTime1 = (hourToSecond(toTime));

        element.each(function(tempKey,tempRow){
          var tempCurrentId = $(tempRow).data('none-special-time-id');
          var tempFromTime = $("input[name='specific_time["+tempCurrentId+"][from_time]']").val();
          var tempToTime = $("input[name='specific_time["+tempCurrentId+"][to_time]']").val();
          var tempFromTime2 = (hourToSecond(tempFromTime));
          var tempToTime2 = (hourToSecond(tempToTime));
          if(currentId != tempCurrentId){
            if(fromTime1 >= tempFromTime2 && fromTime1 <= tempToTime2 || toTime1 >= tempFromTime2 && toTime1 <= tempFromTime2){
              flag=false;
            }
            else{
               flag=true;
            }
          }
        })
      });
      if(!flag)
      {
        toastr.error('error');
      }else{
        $('#submitForm').submit();
      }
    }
}

function allTimes(alltime){
  if (alltime == 0) {
      $('#specific_time').show();
  } else {
      $('#specific_time').hide();
  }
}

function chooseSpecialDate(show){
  if(show == 1){
    $('#special_date_section').show();
    $('#all_day_section').hide();
  }else{
    $('#special_date_section').hide();
    $('#all_day_section').show();
  }
}

function addTime(){
  var str = "";
  str += '<div class="row time-row" data-none-special-time-id="'+specific_time_count+'"  style="padding-top:10px;padding-left:40px">';
  str += '<div class="col-lg-5">'
                    +'<input class="form-control timepicker" id="from_time" name="specific_time['+specific_time_count+'][from_time]" type="text" autocomplete="off" value="{{ date('H:i') }}" required>'
                  +'</div>';
  str+= '<div class="col-lg-5">'
                    +'<input class="form-control timepicker" id="to_time" name="specific_time['+specific_time_count+'][to_time]" type="text" autocomplete="off" value="{{ date('H:i') }}" required=>'
                  +'</div>';
  str+= '<div onclick="deleteTimeOfNoneSepecialDate('+specific_time_count+')" class="col-sm-2 label label-default pull-right option-item-remove">'
                          +'<i class="fa fa-close"></i>'
                      +'</div>';
  str+= '</div>';
  $('#specific_time').append(str);
  $('.timepicker').timepicker({
      format: 'HH:mm',
      showMeridian: false,
      minuteStep: 1,
  });
  specific_time_count++;
}

// $('#submitForm').submit(function(e){
//   if($('#all_times').val() == 0){
//     if($('.time-row').length > 0){
//       $('#submitForm').submit();
//     }else{
//       e.preventDefault();
//       $('#time-error').removeClass('d-none');
//       }
//   }else{
//     $('#submitForm').submit();
//   }
// })

function deleteTimeOfNoneSepecialDate(time_id){
  $("div").find("[data-none-special-time-id='"+time_id+"']").remove();
}

</script>
