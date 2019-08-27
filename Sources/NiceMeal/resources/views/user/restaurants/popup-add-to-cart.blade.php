<div id="detailModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="add-to-card ng-scope">
                <div class="add-to-card__header row" style="border: none">
                    <div class="col-lg-5 col-md-5">
                        <p class="cart-item-name ng-binding"> <% selectedDish.name %> </p>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <p class="cart-item-name"> <% selectedDish.price.formatCurrency() %> </p>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <input type="number" ng-model="selectedDish.quantity" ng-change="validateNumber()" ng-value="selectedDish.quantity" style="width:70%">
                    </div>
                </div>
                <div class="add-to-card__content">
                    <p class="add-to-card__text" ng-if=" selectedDish && checkCustomizationOfDish()">Select additional options and order your food below</p>
                    <form class="add-to-card__form ng-pristine ng-invalid ng-invalid-required" name="optionsForm" id="optionsForm"
                        ng-submit="addToCart()">
                        <div class="add-to-card__item ng-scope" id="popup-detail">

                            <div class="form-item form-item ng-scope" ng-repeat="custom in dish_customizations" ng-if="custom.category_id == selectedCate.id && custom.dish_id == selectedDish.id && findCustomizationRender(custom.customization_id).has_options">
                                <label class="form__label ng-binding">
                                    <div class="row">
                                        <span style="color:#939393;"><% findCustomizationRender(custom.customization_id).name  %></span>
                                        <span style="color:#939393;" ng-if="findCustomizationRender(custom.customization_id).price != 0 ">: <% findCustomizationRender(custom.customization_id).price.formatCurrency() %> </span>
                                        <span class="<% (!optionsForm['custom' + custom.customization_id].$error.required ) ? 'ng-hide' : ''; %>" >*</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <select class="select2" style="width:100%" ng-if="findCustomizationRender(custom.customization_id).selection_type == 1" name="custom<%custom.customization_id%>"
                                                    ng-required='findCustomizationRender(custom.customization_id).required == 1'
                                                    ng-model="selectedOption[custom.customization_id]"
                                                    ng-change="optionChange(custom.customization_id,$event)" >
                                                <option value="" disabled selected>--Choose your option--</option>
                                                <option ng-repeat="option in findCustomizationRender(custom.customization_id).options"
                                                ng-if="option.customization_id == custom.customization_id" value="<% option.id %>">
                                                    <% option.name %>
                                                     <% (option.price > 0) ? '+':' ' %> <% option.price.formatCurrency() %>
                                                </option>
                                            </select>
                                            <select class="select2" style="width:100%" ng-if="findCustomizationRender(custom.customization_id).selection_type == 2" name="custom<%custom.customization_id%>"
                                                ng-required='multiCheckRequired(custom.customization_id) && findCustomizationRender(custom.customization_id).required == 1'
                                                ng-model="selectedOption[custom.customization_id]"
                                                    ng-change="multioptionChange(custom.customization_id,$event)" >
                                                <option value="" disabled selected>--Choose your option--</option>
                                                <option ng-repeat="option in findCustomizationRender(custom.customization_id).options"
                                                ng-if="option.customization_id == custom.customization_id" value="<% option.id %>">
                                                    <% option.name %>
                                                     <% (option.price > 0) ? '+':' ' %> <% option.price.formatCurrency() %>
                                                </option>
                                            </select>
                                        </div>



                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <input
                                                ng-if="findCustomizationRender(custom.customization_id).quantity_changeable == 1 && findCustomizationRender(custom.customization_id).selection_type == 1 && selectedOption[custom.customization_id] "
                                                ng-value="selectedDish.options[selectedOption[custom.customization_id]].quantity"
                                                ng-change="checkValue(custom.customization_id,selectedOption[custom.customization_id])"
                                                type="number" name="option_quantity<% option.id %>"
                                                ng-model="selectedDish.options[selectedOption[custom.customization_id]].quantity"
                                                min="1"
                                                ng-required="(selectedOption[custom.customization_id] !== '') ? 1 : 0">
                                        </div>
                                    </div>
                                </label>
                                <div class="form-group row" ng-if="findCustomizationRender(custom.customization_id).selection_type == 2">
                                    <div class="col-lg-12 option-item" ng-repeat="(key,selected_option) in selectedDish.options |  filter : { option_id : '!!' }" ng-if="custom.customization_id == selected_option.custom_id">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8" style="padding-top: 12px;">
                                                <span><% selected_option.option_name %></span>
                                                <span><% (selected_option.price > 0) ? '+':' ' %> <%  selected_option.price.formatCurrency() %></span>

                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-10" style="margin-left: 10px;">
                                                        <input
                                                        ng-value="selected_option.quantity"
                                                        type="number"
                                                        ng-model="selected_option.quantity"
                                                        ng-change="checkValue(selected_option.custom_id,selected_option.option_id)"
                                                        min="1"
                                                        ng-required="true">
                                                    </div>

                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">
                                                        <span class="btn-del-product" style="color:red" ng-click="deleteOption(selected_option.option_id)">
                                                            <i class="fa fa-times-circle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>
                        <div class="add-to-card__footer">
                            <button ng-disabled="(selectedCustomization !== null && sumObject(formData.option_quantity) === 0) || (sumObject(formData.option_quantity) < formData.custom[selectedCustomization].min_quantity || sumObject(formData.option_quantity) > formData.custom[selectedCustomization].max_quantity)" type="submit" class="md-btn md-btn--primary">Add to
                                cart</button></div>
                    </form>
                </div><button title="Close (Esc)" class="mfp-close ng-isolate-scope" type="button" data-dismiss="modal">×</button>
            </div>
        </div>

    </div>
</div>
