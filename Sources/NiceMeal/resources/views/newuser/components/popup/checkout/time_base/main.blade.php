<div class="modal fade modal-modal" id="synchronizeModal" role="dialog" style="top: 25%;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="text-center" ng-if="requesting()">
                <p style="font-weight: bold; color: #000 !important;">
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                </p>
                <h4>
                    Synchronize in progress. Please wait..
                </h4>
            </div>
            <div ng-if="!requesting()">
                <div ng-if="dishes_disappear">
                    @include('newuser.components.popup.checkout.time_base.time_base_display')
                </div>
                <div ng-if="dishes_changed">
                    @include('newuser.components.popup.checkout.time_base.time_base_pricing')
                </div>
                <!-- Modal Header -->
                <div ng-if="dishes_disappear || dishes_changed" class="row text-center" style="margin-top: 40px;">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button type="button" class="btn btn-apply" ng-click="applySynchronizeData()">Apply</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button type="button" class="btn btn-cancel">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
