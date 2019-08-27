{!! Form::open(['method' => 'POST','id'=>"ResendOrderconfirm-form"])
!!} @csrf
<div id="ResendOrderconfirm" class="modal fade" role="dialog">
    <form id="confirmForm">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Do you want to Resend this Order to Printer?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Resend</button>
                </div>
            </div>

        </div>
    </form>
</div>
