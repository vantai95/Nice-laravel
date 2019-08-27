<script>

    $('.timepicker').timepicker({
        format: 'HH:mm',
        showMeridian: false,
        minuteStep: 1,

    });
    
    function saveAdminNote(){
        var note = $('#admin-order-note').val();
        $.ajax({
                url:"{{ \Session::has('res') ? url('admin/'.$res->res_Slug.'/orders/updateAdminNote') : url('admin/orders/updateAdminNote')}}",
                type:"post",
                dataType:"json",
                data:{
                    'order_id':{{$order->id}},
                    'admin_order_note':$('#admin-order-note').val(),
                    '_token':"{{ csrf_token() }}"
                },
                success:function(response){
                    if(!response.error){
                        toastr.success(response.message);
                    }
                }
                
        });
    }

    $('#reason').change(function(){
        var val = $(this).val();
        if(val == "other"){
            $('#other_reason_div').show();
            $('#other_reason').prop("required",true);
        }else{
            $('#other_reason_div').hide();
            $('#other_reason').prop("required",false);
        }
    })

    function changeThis(element){
        var status = $(element).val();

        if(status == "confirmed"){
            $('#confirmModal').modal("show");
        }else if(status == 'reject'){
            $('#rejectModal').modal("show");
        }else{
            var data = {
                'order_id':{{$order->id}},
                'status':status
            };
            saveOrderInfo(data);
        }
    }

    $('#acceptForm').submit(function(e){
        e.preventDefault();
        var data = {
            'order_id':{{$order->id}},
            'status':2,
            'confirm_time':$('#confirm_time').val(),
            'note':$('#note').val()
        }
        saveOrderInfo(data);
    })

    $('#rejectForm').submit(function(e){
        e.preventDefault();
        var reject_reason = "";
        if($('#reason').val() == "other"){
            reject_reason = $('#other_reason').val();
            
        }else{
            reject_reason = $('#reason option:selected').text();
        }
        
        var data = {
            'order_id':{{$order->id}},
            'status':4,
            'reject_reason':reject_reason
        };
        saveOrderInfo(data);
    })

    $('#cancelForm').submit(function(e){
        e.preventDefault();

        var data = {
            'order_id':{{$order->id}},
            'status':8
        };
        saveOrderInfo(data);
    })

    function saveOrderInfo(data){
        data['_token'] = "{{ csrf_token() }}";
        
            $.ajax({
                url:"{{ \Session::has('res') ? url('admin/'.$res->res_Slug.'/orders/changeStatus') : url('admin/orders/changeStatus')}}",
                type:"post",
                dataType:"json",
                data:data,
                success:function(response){
                    if(!response.error){
                        toastr.success(response.message);
                        $('#acceptModal').modal("hide");
                        $('#rejectModal').modal("hide");
                        window.location.reload();
                    }
                }

            });
    }

    function isNumberKey(e)
        {
            var charCode = (e.which) ? e.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

    $('#SMSconfirm-form').submit(function(e){
        e.preventDefault();
        var data = $('#SMSconfirm-form').serializeArray();
        data.push({
            'name':'customer_phone',
            'value':"{{ $order_customer_info->phone }}"
        });
        $.ajax({
            url:"{{ \Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders/confirmSendSMS') : url('/admin/orders/confirmSendSMS')}}",
            type:"post",
            data:data,
            success:function(response){
                if(response.error){
                    toastr.error("@lang('admin.orders.statuses.error')");
                }else{
                    toastr.success(response.message);
                    $('#sms-content').val('');
                    $('#optionalPhoneNumber').val('');
                    $('#SMSconfirm').modal("hide");
                }
            }
        });
    });

    $('#Mailconfirm-form').submit(function(e){
        e.preventDefault();
        var data = $('#Mailconfirm-form').serializeArray();
        data.push({
            'name':'customer_mail',
            'value':"{{ $order_customer_info->email }}"
        });
        $.ajax({
            url:"{{ \Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders/confirmSendMail') : url('admin/orders/confirmSendMail')}}",
            type: 'post',
            data: data,
            success:function(response){
                if(response.error){
                    toastr.error("@lang('admin.orders.statuses.error')");
                }else{
                    toastr.success(response.message);
                    $('#otherMail').val('');
                    $('#mailSubject').val('');
                    $('#mailContent').val('');
                    $('#Mailconfirm').modal("hide");
                }
            }
        });
    });

    $('#Callconfirm-form').submit(function(e){
        e.preventDefault();
        if($('#callToPhone').val()==1)
        {
            location.href = "tel: {{ $order_customer_info->phone }}";
        }
        else if($('#callToPhone').val()==2)
        {
            $phone = $('#otherPhoneNumber').val();
            location.href = "tel: "+$phone;
        }
    });

    $('#ResendOrderconfirm-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"{{ \Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders/confirmResendOrder') : url('/admin/orders/confirmResendOrder')}}",
            type: 'post',
            data: {
                '_token': "{{ csrf_token() }}",
                'order_id': {{$order->id}}
            },
            success:function(response){
                if(response.error){
                    toastr.error("@lang('admin.orders.statuses.error')");
                }else{
                    toastr.success(response.message);
                    $('#ResendOrderconfirm').modal("hide");
                    window.location.reload();
                }
            }
        });
    });

    $(document).ready(function () {
        $('#phone_number').hide();
        $('#other_Mail').hide();
        $('#other_Phone_Number').hide();
        @if($order->status < 3)
        $('#btnConfirm').click(function () {
           $('#confirmModal').modal('show');
        });
        @endif
        $('#btnAccept').click(function () {
            $('#confirmModal').modal('hide');
            $('#acceptModal').modal('show');
        });
        $('#btnReject').click(function () {
            $('#confirmModal').modal('hide');
            $('#rejectModal').modal('show');
        });
        @if($order->status < 4)
        $('.btnCancel').click(function () {
            $('#cancelModal').modal('show');
        });
        @endif
    });

    function showInputSMS(value){
        if(value== 1)
        {
            $('#phone_number').hide();
            $('#optionalPhoneNumber').prop('required',false);
            $('#optionalPhoneNumber').val('');
            $('#sms-content').focus();
        }
        else if(value== 2)
        {
            $('#phone_number').show();
            $('#optionalPhoneNumber').prop('required',true);
            $('#optionalPhoneNumber').focus();
        }
    }

    function showInputMail(value){
        if(value== 1)
        {
            $('#other_Mail').hide();
            $('#otherMail').prop('required',false);
            $('#otherMail').val('');
            $('#mailSubject').focus();
        }
        else if(value== 2)
        {
            $('#other_Mail').show();
            $('#otherMail').prop('required',true);
            $('#otherMail').focus();
        }
    }

    function showInputPhone(value){
        if(value== 1)
        {
            $('#other_Phone_Number').hide();
            $('#otherPhoneNumber').prop('required',false);
            $('#otherPhoneNumber').val('');
        }
        else if(value== 2)
        {
            $('#other_Phone_Number').show();
            $('#otherPhoneNumber').prop('required',true);
            $('#otherPhoneNumber').focus();
        }
    }

</script>
