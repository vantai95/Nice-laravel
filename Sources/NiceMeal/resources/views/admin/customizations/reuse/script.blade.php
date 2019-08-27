
<script>
    var listCustomization = [];
    var selected_customization = 0;
    var current_id = 1;


    // init page
    $(document).ready(function () {
        setTimeout(function() {
            $('.option-price').mask("#.##0",{reverse:true});
            current_id++;
        }, 100);
        $('#hasoption_extra_prop').show();
        $('#option_form').show();

        // // trigger events
        $('#customization_selection_type').change(function(){
            showMinMaxSelectionQuantity();
        });
        $('#quantity_changeable_no').change(function(){
            showMinMaxSelectionQuantity();
        });

        $('#quantity_changeable_yes').change(function(){
            showMinMaxSelectionQuantity();
        });

    });


    $('#quantity_changeable_div input').change(function() {
        changeSelectedType();
        changeDefaultSelection();
    });

    // $('#customization_has_options_yes').change(function(){
    //     $('#hasoption_extra_prop').show();
    //     if($(this).is(':checked')){
    //         $('#option_form').slideDown(500,function(){
    //             $('#option_form').show();
    //         });
    //         $('#customization_selection').slideDown(500,function(){
    //             $(this).show();
    //         });
    //     }
    // })
    // $('#customization_has_options_no').change(function(){
    //     if($(this).is(':checked')){
    //         $('#option_form').slideUp(500,function(){
    //             $('#option_form').hide();
    //         });
    //         $('#customization_selection').slideUp(500,function(){
    //             $(this).hide();
    //         });
    //     }
    // })

    $('#price').mask("#.##0",{reverse:true});


    $('#submitForm').submit(function(){
        $('#price').unmask();
    });

    $(function(){
        loadCustomization();
    })


    //Load list customization

    function loadCustomization(){
        $('#list_customization').html('');
        $.ajax({
            url:"{{ url('admin/'.$res->res_Slug.'/customizations/customizationList')}}",
            type:"GET",
            dataType:"json",
            success:function(json){
                var data = json.data;
                var item = '';
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

                    item += '<div class="col-lg-6 dish-extra-item dish_customization"  data-customizationid="'+row.id+'">'
                    +'<input type="hidden" name="customizations['+row.id+']" value="'+row.id+'">'
                            +'<div class="col-lg-12 p-0">'
                                +'<div class="input-group">'
                                    +'<button type="button" onclick="showCustomization('+row.id+')" class="btn btn-primary" style="font-size: 11px; white-space: normal;word-wrap: break-word;">'
                                    +row.name_en
                                    +'<br/><span class="cust-des"> ['+description+']</span> </button>'
                                        +'<div class="input-group-append">' //add customization to categories
                                            +'<span onclick="addCustomizationToDish(this)" class="input-group-text"><i class="fa fa-plus"></i></span>'
                                        +'</div>'
                                        +'<div class="input-group-append">' //duplicate customization
                                            +'<span onclick="duplicateCustomization('+row.id+')" class="input-group-text"><i class="fa fa-copy"></i></span>'
                                        +'</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    listCustomization[row.id] = row;
                });
                $('#list_customization').append(item);
            },
        });
    }

    var requesting = [];
    function duplicateCustomization(item_id){
        if(requesting[item_id] === undefined){
            requesting[item_id] = false;
        }
        if(!requesting[item_id]){
            requesting[item_id] = true;
            var data = $(this).serializeArray();
            data.push({'name':'request_type','value':'ajax'});
            var urlPostDuplicateCustomization = "{{url('/admin/'.$res->res_Slug.'/customizations/duplicate')}}";
            $.ajax({
                url:urlPostDuplicateCustomization +'/'+ item_id,
                type:"post",
                data:{
                    '_token':"{{ csrf_token() }}",
                    'item_id':item_id,
                    'data':data,
                },
                success:function(response){
                    if(response.error){
                        toastr.error("@lang('admin.customizations.customization_status.error')");
                    }else{
                        loadCustomization();
                        requesting[item_id] = false;
                        toastr.success(response.message);
                    }
                }
            });
        }else{
            //
        }
    }

    function addCustomizationToDish(element){
                var parent = $(element).parents('.dish-extra-item').clone();
                var value = parent.data('customizationid');
                if($('#customizations_zone').children('[data-customizationid="'+value+'"]').data('customizationid')){
                    return;
                }

                parent.find('.input-group-append').remove();
                parent.find('.input-group').append(
                    '<div class="input-group-append">'
                            +'<span onclick="removeFromList(this)" class="input-group-text"><i class="fa fa-close"></i></span>'
                    +'</div>'
                );
                $('#customizations_zone').append(parent);
    }

    function removeFromList(element){
        var draggable = $(element).parents('.dish_customization');
        draggable.remove();
    }

    function showCustomization(id){
        $('.option-item').hide();
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        selected_customization = id;
        var data = listCustomization[id];
        $('#customizationForm').data('method','edit');

        drawCustomization(data);

        $('#customization_price').mask("#.##0",{reverse:true});

        if(data.has_options){
            // $('#customization_has_options_yes').prop('checked',true);
            $('#option_form').show();
            $('#customization_selection').show();
            $('#option_form').find('.option-item').remove();
            $.ajax({
                url:"{{ url('admin/'.$res->res_Slug.'/customizations/getOptions') }}/"+id,
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
        // else{
        //     $('#customization_has_options_no').prop('checked',true);
        //     $('#option_form').hide();
        //     $('#customization_selection').hide();
        // }
        $('#quantity_changeable_div').show();

        // if(data.selection_type == 1 ){
        // }else if (data.selection_type == 2){
        //     $('#quantity_changeable_div').hide();
        // }
        $('#customizationForm').append('<input name="_method" type="hidden" value="PATCH">');
        $('#customizationForm').prop('action',"{{ url('admin/'.$res->res_Slug.'/customizations') }}/"+id);
        $('#customization_submitButton').val("Update");


        $('#customizationModal').modal("show");
    }

    function openAddCustomizationForm(){
        $('.option-item').show();
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $('#customizationForm').data('method','add');
        $('#customization_name_en').val('');
        $('#customization_name_ja').val('');
        $('#customization_description_en').summernote('code', '');
        $('#customization_description_ja').summernote('code', '');
        $('#customization_price').val(0);
        $('#customization_active').prop('checked',1);
        $('#customization_required_no').prop('checked',true);
        $('#customization_selection_type').val(1).trigger("change");
        $('#min_quantity').val(0);
        $('#max_quantity').val(0);
        $('#customizationForm').find('input[name="_method"]').remove();
        $('#customizationForm').prop('action',"{{ url('admin/'.$res->res_Slug.'/customizations') }}");
        $('#customization_submitButton').val("Created");
        $('#option_form').show();
        $('#hasoption_extra_prop').show();
        $('#customization_required_yes').prop('checked',true);
        $('#quantity_changeable_yes').prop('checked',true);
        $('#customization_selection').show();
        $('.option_name_en').val('');
        $('.option_name_ja').val('');
        $('.option_price').val(0);
        $('.option_max_quantity').val(0);
        $('.option_min_quantity').val(0);
        $('#customizationModal').find('.option-item').remove();
        $('#customization_price').mask("#.##0",{reverse:true});

        $('#customizationModal').modal("show");
        $('.location').val(1);

    }

    // $('#customization_selection_type').change(function(){
    //     if($(this).val() == 1){
    //         $('#quantity_changeable_div').show();
    //     }else if($(this).val() == 2){
    //         $('#quantity_changeable_div').hide();
    //     }
    // })

    $('#customizationForm').submit(function(e){
        e.preventDefault();
        if($('.option-item').length == 0){
            toastr.error("Vui lòng thêm option.");
            return;
        }

        if(Number($('#customization_max_quantity').val()) < Number($('#customization_min_quantity').val())){
            toastr.error("Max quantity không thể nhỏ hơn min.");
            return;
        }
        $('#customization_price').unmask();

        var restaurant_id = '';
        var data = $(this).serializeArray();
        data.push({'name':'request_type','value':'ajax'});

        var method = $(this).data('method');
        var url = '';
        var method_type = '';
        if(method == 'edit'){
            url= "{{ url('admin/'.$res->res_Slug.'/customizations') }}/"+selected_customization;
            method_type = 'patch';
        }else if(method == 'add'){
            url= "{{ url('admin/'.$res->res_Slug.'/customizations') }}";
            method_type = 'post';
        }
        $.ajax({
            url:url,
            type:method_type,
            data:data,
            dataType:"json",
            success:function(json){
                if(json.error){
                    toastr.error(json.message);
                }else{
                    loadCustomization();

                    @if(isset($dish))
                        loadDishCustomization();
                    @endif

                    @if(isset($category))
                        loadCategoryCustomization();
                    @endif

                    $('#customizationModal').modal("hide");
                    toastr.success("@lang('admin.customizations.flash_messages.new')");
                }
            }
        });
    });
</script>
@include('admin.customizations.formscript')
