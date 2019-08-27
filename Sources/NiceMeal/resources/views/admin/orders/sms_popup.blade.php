{!! Form::open(['method' => 'POST','id'=>"SMSconfirm-form",'url' => '/admin/'.$res->res_Slug.'/orders/confirmSendSMS'])  !!}
@csrf
<div class="modal fade" id="SMSconfirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="SMSModalLabel">SMS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="height: auto; overflow:auto">
            <div class="form-group">
                <label for="phone-number" class="form-control-label">Send to:</label>
                <div class="m-form__control">
                    <select class="form-control m-bootstrap-select" name="sendToSMS" id="sendToSMS" onchange="showInputSMS(this.options[this.selectedIndex].value)">
                        <option value="1" selected="selected">
                            Customer Phone Number
                        </option>
                        <option value="2" >
                            Other Phone Number
                        </option>
                    </select>
                </div>
                <div class="m-form__control" id="phone_number" style="margin-top: 1rem">
                    <input onkeypress="return isNumberKey(event)" type="text" placeholder="Example: 0123.xxx.xxx" minlength="10" maxlength="10"  class="form-control" name="optionalPhoneNumber" id="optionalPhoneNumber">
                </div>
            </div>
            <div class="form-group">
                <label for="sms-content" class="form-control-label">Content:</label>
                <textarea maxlength="160" required class="form-control" name="sms-content" id="sms-content"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Send message</button>
        </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
