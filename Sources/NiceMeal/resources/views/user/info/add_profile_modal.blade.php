<div class="modal fade" id="modalAddProfile" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Profile</h4>
            </div>
            <form ng-submit="addAlterProfile()">
                <div class="modal-body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12" style="color:black">
                            <label for="all_times" class="col-form-label col-sm-12">Email
                                <span class="required-field">*</span>
                            </label>
                            <div class="col-sm-12">
                                <input type="email" name="email" class="form-control"
                                       ng-model="field.newAlterProfileValue['email']" required>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-top:10px;color:black">
                            <label for="all_times" class="col-form-label col-sm-12">Phone
                                <span class="required-field">*</span>
                            </label>
                            <div class="col-sm-12">
                                <input type="tel" name="phone" class="form-control allow-number-only" maxlength="10"
                                       ng-model="field.newAlterProfileValue['phone']" required>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-top:10px;color:black">
                            <label for="all_times" class="col-form-label col-sm-12">Address
                                <span class="required-field">*</span>
                            </label>
                            <div class="col-sm-12">
                                <input type="text" name="address" class="form-control"
                                       ng-model="field.newAlterProfileValue['address']" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>