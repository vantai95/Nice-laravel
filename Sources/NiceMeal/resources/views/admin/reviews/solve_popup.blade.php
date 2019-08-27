{!! Form::open(['method' => 'POST','id'=>"Mailconfirm-form",'url' => '/admin/'.$res->res_Slug.'/reviews/send-problem-solved/'.$review->id])
!!}
<div class="modal fade" id="modalSolve" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="MailModalLabel">Confirm send problem solve email to customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Send mail</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
