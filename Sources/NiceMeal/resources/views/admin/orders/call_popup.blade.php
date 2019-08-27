{!! Form::open(['method' => 'POST','id'=>"Callconfirm-form"])
!!} @csrf
<div class="modal fade" id="Callconfirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CallModalLabel">Call</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" style="height: auto; overflow:auto">
                <form>
                    <div class="form-group">
                        <label for="phoneNumber" class="form-control-label">Call to:</label>
                        <div class="m-form__control">
                                <select class="form-control m-bootstrap-select" name="callToPhone" id="callToPhone" onchange="showInputPhone(this.options[this.selectedIndex].value)">
                                    <option value="1" selected="selected">
                                        Customer Phone Number
                                    </option>
                                    <option value="2" >
                                        Other Phone Number
                                    </option>
                                </select>
                            </div>
                        <div class="m-form__control" id="other_Phone_Number" style="margin-top: 1rem">
                            <input onkeypress="return isNumberKey(event)" type="text" minlength="10" maxlength="10" class="form-control" name="otherPhoneNumber" id="otherPhoneNumber">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Call</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
