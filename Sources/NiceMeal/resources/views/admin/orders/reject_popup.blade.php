<div id="rejectModal" class="modal fade" role="dialog">
    <form id="rejectForm">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Please enter your reject reason</h4>
                </div>
                <div class="modal-body" style="height:150px;">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Reject reason</label>
                            <select name="reason" class="form-control" id="reason">
                                @foreach($reject_reasons as $reason)
                                    <option value="{{ $reason->id }}">{{ $reason->name_en }}</option>
                                @endforeach
                                <option value="other">Other reason</option>
                            </select>
                        </div>
                        <div id="other_reason_div" class="col-lg-6" style="display:none;">
                            <label>Reason</label>
                            <textarea class="form-control" name="other_reason" id="other_reason" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Reject</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </form>
</div>