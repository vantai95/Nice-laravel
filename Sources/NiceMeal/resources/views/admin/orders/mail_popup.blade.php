{!! Form::open(['method' => 'POST','id'=>"Mailconfirm-form",'url' => \Session::has('res') ? '/admin/'.$res->res_Slug.'/orders/confirmSendMail' : '/admin/orders/confirmSendMail'])
!!} @csrf
<div class="modal fade" id="Mailconfirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="MailModalLabel">Mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" style="height: auto; overflow:auto">
                    <div class="form-group">
                        <label for="mailInfo" class="form-control-label">Send to:</label>
                        <div class="m-form__control">
                            <select class="form-control m-bootstrap-select" name="sendToMail" id="sendToMail" onchange="showInputMail(this.options[this.selectedIndex].value)">
                                <option value="1" selected="selected">
                                    Customer Mail
                                </option>
                                <option value="2" >
                                    Other Mail
                                </option>
                            </select>
                        </div>
                    <div class="m-form__control" id="other_Mail" style="margin-top: 1rem">
                        <input type="email" placeholder="me@example.com" class="form-control" name="otherMail" id="otherMail">
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="mailSubject" class="form-control-label">Subject:</label>
                        <input type="text" maxlength="255" required class="form-control" name="mailSubject" id="mailSubject">
                    </div>
                    <div class="form-group">
                        <label for="mailContent" class="form-control-label">Content:</label>
                        <textarea required class="form-control" name="mailContent" id="mailContent"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Send mail</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
