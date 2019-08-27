<script type="text/javascript">

function setValue(element , value = undefined){
  if(value === undefined){
    value = $(element).prop('value');
  }
  $(element).attr('value',value);
  $(element).prop('value',value);
}

function checkMinValue(element,id){
    var value = Number($(element).prop('value'));
    value = checkIntegerNumber(value);
    if( value <= 0){
        value = '';
    }else{
        var max_val = Number($('#option_max_quantity_'+id).prop('value'));
        if(max_val <= value){
          setValue($('#option_max_quantity_'+id),value);
        }
    }
    setValue(element,value);
}

function checkMaxValue(element,id){
  var value = Number($(element).prop('value'));
    value = checkIntegerNumber(value);
    if( value < 0){
        value = '';
    }else if(value > 0){
        var min_val = Number($('#option_min_quantity_'+id).prop('value'));
        if(value <= min_val){
          value = min_val;
        }
    }
    setValue(element,value);
}

function checkIntegerNumber(inputValue){
    var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    if(isNaN(inputValue) || format.test(inputValue)){
        inputValue = 1;
    }
    return inputValue;
}

</script>
