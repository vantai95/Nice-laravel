<script>

    var current_id = 1;

    @if(isset($subDS))
        var subDS = {!! $subDS !!};
        $(function(){
            $.each(subDS,function(key,value){
                addMoreDeliveryItem(value);
            });
        })
    @endif
    
    // functions
    function deleteDelivery(element){
        var delivery = $(element).parents('.delivery-settings').remove();
    }

    function addMoreDeliveryItem(data){
        var setting_id = 0;
        var delivery_cost = 0;
        var from = 0;
        var to = 0;
        if(data != null){
            setting_id = data.id;
            delivery_cost = data.delivery_cost;
            from = data.from;
            to = data.to;
        }
        var selectOps = '';
        var delivery_item = '<div class="delivery-settings" style="margin-bottom: 20px;">'
            +'<div class="form-group m-form__group row">'
                +'<div class="col-lg-12">'
                    +'<span onclick="deleteDelivery(this)" class="label label-default pull-right option-item-remove">'
                        +'<i class="fa fa-close"></i>'
                    +'</span>'
                +'</div>'
                + '<input type="hidden" value="'+setting_id+'" name="sub_setting['+current_id+'][setting_id]">'
                + '<div class="col-lg-4">'
                    + '<label>Delivery Cost<span class="text-danger"> *</span></label>'
                    + '<input type="text" value="'+delivery_cost+'" class="form-control number-format" id="sub_setting['+current_id+'][delivery_cost]" name="sub_setting['+current_id+'][delivery_cost]" >'
                + '</div>'
                + '<div class="col-lg-4">'
                    + '<label>Total Bill From<span class="text-danger"> *</span></label>'
                    + '<input type="text" value="'+from+'" class="form-control number-format" id="sub_setting['+current_id+'][bill_from]" name="sub_setting['+current_id+'][bill_from]" >'
                + '</div>'
                + '<div class="col-lg-4">'
                    + '<label>Total Bill To<span class="text-danger"> *</span></label>'
                    + '<input type="text" value="'+to+'" class="form-control number-format" id="sub_setting['+current_id+'][bill_to]" name="sub_setting['+current_id+'][bill_to]" >' +
                '</div>'
            + '</div>';
            // + '<div class="form-group m-form__group row">'
            //     + '<div class="col-lg-4">'
            //         + '<label>Total Bill From<span class="text-danger"> *</span></label>'
            //         + '<input type="text" value="'+from+'" class="form-control number-format" id="sub_setting['+current_id+'][bill_from]" name="sub_setting['+current_id+'][bill_from]" >'
            //     + '</div>'
            //     + '<div class="col-lg-4">'
            //     + '<label>Total Bill To<span class="text-danger"> *</span></label>'
            //     + '<input type="text" value="'+to+'" class="form-control number-format" id="sub_setting['+current_id+'][bill_to]" name="sub_setting['+current_id+'][bill_to]" >' +
            //     '</div>'
            // + '</div>';
            current_id++;
        $('.extra-delivery-setting-section').append(delivery_item);
        $('.number-format').mask("#.##0", {reverse: true});

    }
</script>