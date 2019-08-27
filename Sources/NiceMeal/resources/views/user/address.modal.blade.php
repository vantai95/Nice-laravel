<div class="modal-body">
	<div class="form-wrap">
		<h3 class="form-wrap__title">Address info</h3>
		<div class="form-wrap__inner">

			<!-- form-item -->
			<div class="form-item form-item--half ui-select-box">
			<label class="form__label">Address type<span>*</span></label>
			<ui-select ng-model="address.type"
						ng-required="true"
						name="residence_type">
				<ui-select-match placeholder="Address type">
				<span ng-bind="$select.selected.name"></span>
				</ui-select-match>
				<ui-select-choices repeat="item in (addressType | filter: $select.search) track by item.id">
				<span ng-bind="item.name"></span>
				</ui-select-choices>
			</ui-select>
			</div>
			<!-- End / form-item -->

			<!-- form-item -->
			<div class="form-item form-item--half ui-select-box">
				<label class="form__label">Residence type<span>*</span></label>
				<ui-select ng-model="address.residentype"
							ng-required="true"
							name="residence_type">
					<ui-select-match placeholder="Residence type">
					<span ng-bind="$select.selected.name"></span>
					</ui-select-match>
					<ui-select-choices repeat="item in (residentype | filter: $select.search) track by item.id">
					<span ng-bind="item.name"></span>
					</ui-select-choices>
				</ui-select>
			</div>
			<!-- End / form-item -->


			<!-- form-item -->
			<div class="form-item"
				ng-class="{'has-error': address.address.$dirty && address.address.$invalid}">
			<label class="form__label">Full address<span>*</span></label>
			<input class="form-control"
					type="text"
					name="address"
					placeholder="123 4th Avenue"
					required
					ng-model="address.address">
			</div><!-- End / form-item -->


			<!-- form-item -->
			<div class="form-item form-item--half ui-select-box"
				ng-class="{'has-error': address.district.$dirty && address.district.$invalid}">
			<label class="form__label">District<span>*</span></label>
			<ui-select ng-model="address.district"
						ng-required="true"
						name="district"
						on-select="onSelected($item)">
				<ui-select-match placeholder="District">
				<span ng-bind="$select.selected.name"></span>
				</ui-select-match>
				<ui-select-choices repeat="item in (districts | filter: $select.search | limitTo: 3) track by item.id">
				<span ng-bind="item.name"></span>
				</ui-select-choices>
			</ui-select>
			</div><!-- End / form-item -->


			<!-- form-item -->
			<div class="form-item form-item--half ui-select-box"
				ng-class="{'has-error': address.ward.$dirty && address.ward.$invalid}">
			<label class="form__label">Ward<span>*</span></label>
			<ui-select ng-model="address.ward"
						ng-required="true"
						name="ward">
				<ui-select-match placeholder="Ward">
				<span ng-bind="$select.selected.name"></span>
				</ui-select-match>
				<ui-select-choices repeat="item in (wards | filter: $select.search | limitTo: 3) track by item.id">
				<span ng-bind="item.name"></span>
				</ui-select-choices>
			</ui-select>
			</div><!-- End / form-item -->
		</div>
	</div>

</div>
<div class="modal-footer">
	<button class="md-btn md-btn--primary add-new" ng-click="addNew()" ng-if="info == null">Add new</button>
	<button class="md-btn md-btn--primary add-new" ng-click="update()" ng-if="info != null">Update</button>

	<button title="Close (Esc)"
			class="mfp-close"
			type="button"
			ng-click="close()">×</button>
</div>
