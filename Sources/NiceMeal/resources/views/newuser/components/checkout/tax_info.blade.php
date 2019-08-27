<div class="tax-info-section">
    <div class="row">
        <div class="tax-information col-md-12 col-xs-12">
            <h6>Tax info</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <label for="">Tax ID</label>
            <input ng-model="checkoutData.tax_id" type="text" name="tax_id" id="tax_id">
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
            <label for="">Company name</label>
            <input ng-model="checkoutData.tax_name" type="text" name="company_name" id="company_name">
        </div>
    </div>
    <div class="row tax-info-mt-20">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <label for="">Receiver contact</label>
            <input ng-model="checkoutData.tax_contact" type="text" name="receiver_contact" id="receiver_contact">
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
            <label for="">Receiver address</label>
            <input ng-model="checkoutData.tax_address" type="text" name="receiver_address" id="receiver_address">
        </div>
    </div>
</div>
