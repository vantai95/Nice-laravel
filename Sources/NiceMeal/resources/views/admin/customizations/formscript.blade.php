<script>

    var current_id = 1;
    // var min_option_quantity = 0,max_option_quantity = 0;

    // init page
    $(document).ready(function () {
        /*setTimeout(function() {
            $('.option_price').mask("#.##0",{reverse:true});
            current_id++;
        }, 100);*/
        $('#quantity_changeable').show();
        $('#option_form').show();
        changeSelectedType();
    });

    function getOptions(customization_id){
      $.ajax({
          url:"{{ url('admin/'.$res->res_Slug.'/customizations/getOptions') }}/"+customization_id,
          type:"get",
          dataType:"json",
          success:function(json){
              var data = json.data;
              data.forEach(function(row){
                  addMoreOption(row);
              })
          }
      });
    }

    // // trigger events
    $('#selection_type').change(function(){
        showMinMaxSelectionQuantity();
    });
    $('#quantity_changeable_no').change(function(){
        showMinMaxSelectionQuantity();
    });

    $('#quantity_changeable_yes').change(function(){
        showMinMaxSelectionQuantity();
    });
    function showMinMaxSelectionQuantity(){
        var quantity_changeable_no = $("#quantity_changeable_no").is(":checked");
        if($('#selection_type').attr('value') == 1 && quantity_changeable_no == true){
            $('#max_div').hide();
            $('#min_div').hide();
            min_option_quantity = 1;
            max_option_quantity = 1;
        }else{
            $('#max_div').show();
            $('#min_div').show();
            min_option_quantity = 0;
            max_option_quantity = 0;
        }
    }
    $('#price,#max_quantity,#min_quantity').mask("#.##0",{reverse:true});

    

    // $('#has_options_yes').change(function(){
    //     if($(this).is(':checked')){
    //         $('#option_form').slideDown(500,function(){
    //             $('#option_form').show();
    //         });
    //     }
    // })
    //
    // $('#has_options_no').change(function(){
    //     if($(this).is(':checked')){
    //         $('#option_form').slideUp(500,function(){
    //             $('#option_form').hide();
    //         });
    //     }
    // })

    // functions
    function deleteOption(element){
        var option = $(element).parents('.option-item').remove();
    }

    function addMoreOption(data){
        var option_id = 0,name_en = '',name_ja = '',max_quantity = 1,min_quantity = 1,price = 0;
        if($('#customization_selection_type').attr('value')==1){
            max_quantity = 1;
            min_quantity = 1;
        }
        if(data != null){
            option_id = data.id;
            if(current_id < option_id){
                current_id = option_id;
            }
            name_en = data.name_en;
            if(data.name_ja == null && data.name_ja == "" && typeof data.name_ja == 'undefined'){
                name_ja = data.name_en;
            }else {
                name_ja = data.name_ja;
            }
            max_quantity = data.max_quantity;
            min_quantity = data.min_quantity;
            price = data.price;
        }
        var option_item = '<div class="option-item" data-option-id="'+current_id+'" draggable="true" ondragleave="dragLeave(event)" ondragenter="dragEnter(event)" ondragstart="dragStart(event)" ondragover="allowDrop(event)" ondrop="drop(event)">'
                +'<div class="row option-button">'
                    +'<div class="col-lg-12">'
                            +'<span onclick="deleteOption(this)" class="label label-default pull-right icon-wrapper option-item-remove">'
                                +'<i class="fa fa-close"></i>'
                            +'</span>'
                            +'<span class="label label-default pull-right icon-wrapper" onclick="changeClosest(this,false)">'
                              +'<i class="fa fa-angle-down icon"></i>'
                            +'</span>'
                            +'<span class="label label-default pull-right icon-wrapper" onclick="changeClosest(this,true)">'
                              +'<i class="fa fa-angle-up icon"></i>'
                            +'</span>'
                    +'</div>'
                +'</div>'
                +'<div class="row">'
                    +'<input type="hidden" value="'+option_id+'" class="form-control" name="option['+current_id+'][option_id]">'
                    +'<div class="col-lg-3"><label>Option English Name <span class="text-danger">*</span></label><input onchange="setValue(this)" type="text" value="'+name_en+'" class="form-control" name="option['+current_id+'][name_en]" required></div>'
                    +'<div class="col-lg-3"><label>Option Japanese Name</label><input type="text" onchange="setValue(this)" value="'+name_ja+'" class="form-control" name="option['+current_id+'][name_ja]"></div>'
                    +'<div class="col-lg-2"><label>Price <span class="text-danger">*</span></label><input type="number" onchange="setValue(this)" class="form-control option_price" value="'+price+'" id="option_price_'+current_id+'" name="option['+current_id+'][price]" required></div>'
                    +'<div class="col-lg-2"><label>Min quanity <span class="text-danger">*</span></label><input type="number" class="form-control min-field" onchange="checkMinValue(this,'+current_id+')" id="option_min_quantity_'+current_id+'" value="'+min_quantity+'" name="option['+current_id+'][min_quantity]" required></div>'
                    +'<div class="col-lg-2"><label>Max quanity <span class="text-danger">*</span></label><input type="number" class="form-control max-field" onchange="checkMaxValue(this,'+current_id+')" id="option_max_quantity_'+current_id+'" value="'+max_quantity+'" name="option['+current_id+'][max_quantity]" required></div>'

                +'</div>';
            '</div>';

        $('#option_button').after(option_item);
        /*$('.option_price').mask("#.##0",{reverse:true});*/
        changeSelectedType();
        changeDefaultSelection();
        current_id++;
    }

    $('#quantity_changeable input').change(function() {
        changeSelectedType();
        changeDefaultSelection();
    });

    function changeSelectedType() {
        if($('#quantity_changeable input:checked').attr('value')==0) {
            $('input[type=number].min-field').attr('value',1);
            $('input[type=number].max-field').attr('value',1);
            $('.min-field').attr({
                "max" : 1,
                "min" : 1,
                "value": 1,
                "readonly": true
            });
            $('.max-field').attr({
                "max" : 1,
                "min" : 1,
                "value": 1,
                "readonly": true
            });
        } else {
            $('.min-field').removeAttr('max min readonly');
            $('.max-field').removeAttr('max min readonly');
        }
    }

    function drawCustomization(customization){

      if(customization === undefined){
        $('#customization_name_en').val('');
        $('#customization_name_ja').val('');
        $('#customization_description_en').summernote('code', '');
        $('#customization_description_ja').summernote('code', '');
        $('#customization_active').prop('checked',1);
        $('#customization_required_yes').prop('checked',true);
        $('#quantity_changeable_yes').prop('checked',true)
      }else{
        $('#customization_name_en').val(customization.name_en);
        $('#customization_name_ja').val(customization.name_ja);
        $('#customization_description_en').summernote('code', customization.description_en);
        $('#customization_description_ja').summernote('code', customization.description_ja);
        $('#customization_price').val(customization.price);
        $('#customization_active').prop('checked',customization.active);
        $('#customization_max_quantity').val(customization.max_quantity);
        $('#customization_selection_type').val(customization.selection_type).trigger("change");
        customization.required ? $('#customization_required_yes').prop('checked',true) : $('#customization_required_no').prop('checked',true);
        customization.quantity_changeable ? $('#quantity_changeable_yes').prop('checked',true) : $('#quantity_changeable_no').prop('checked',true);
      }

    }

    function changeDefaultSelection() {
        if($('#quantity_changeable input:checked').attr('value')==0) {
            $('input[type=number].default-min-field').attr('value',1);
            $('input[type=number].default-max-field').attr('value',1);
            $('.default-min-field').attr({
                "max" : 1,
                "min" : 1,
                "value": 1,
                "readonly": true
            });
            $('.default-max-field').attr({
                "max" : 1,
                "min" : 1,
                "value": 1,
                "readonly": true
            });
        } else {
            $('.default-min-field').removeAttr('max min readonly');
            $('.default-max-field').removeAttr('max min readonly');
        }
    }
</script>
@include('admin.customizations.validate')
@include('admin.customizations.draganddrop')
