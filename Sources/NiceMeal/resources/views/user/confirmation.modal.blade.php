<div class="modal-header">
  <h5 class="modal-title">Confirmation</h5>
</div>
<div class="modal-body">{{message}}</div>
<div class="modal-footer">
  <button class="md-btn md-btn--primary add-new" ng-click="removeAfterConfirmation(item)">Remove</button>

  <button title="Close (Esc)"
    class="mfp-close"
    type="button"
    ng-click="close()">×</button>
</div>
