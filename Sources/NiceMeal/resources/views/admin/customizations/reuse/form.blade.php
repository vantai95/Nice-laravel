<div id="customizationModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Customization</h4>
            </div>
            <div class="modal-body">
              @include('admin.customizations.formbody')

            </div>

            <div class="modal-footer">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText :
                trans('admin.customizations.buttons.create'), ['class' => 'btn btn-success', 'id' =>
                'customization_submitButton']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
