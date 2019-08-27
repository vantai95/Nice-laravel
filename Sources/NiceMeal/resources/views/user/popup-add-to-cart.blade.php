<div class="add-to-card">
  <div class="add-to-card__header">
    <h3 class="add-to-card__title">{{dish.name}}</h3>
  </div>
  <div class="add-to-card__content">
    <p class="add-to-card__text">Select additional options and order your food below</p>
    <form class="add-to-card__form"
          name="optionsForm"
          ng-submit="addToCart(optionsForm)">
      <div class="add-to-card__item"
           ng-if="comboAmount.length > 0">
        <div class="form-item form-item--half"
             ng-class="{'has-error': optionsForm.$submitted && optionsForm.combo_{{name}}.$invalid}"
             ng-repeat="(name, combos) in dish.combo_dish">
          <label class="form__label">
            {{name}} <span ng-show="combos.required">*</span>
          </label>
          <select class="form-control form-select"
                  name="combo_{{name}}"
                  ng-model="combo[name]"
                  ng-required="combos.required"
                  ng-options="cb.id as cb.name + ' + ' + (cb.price | currencyFormat) for cb in combos.combo_list">
            <option value="" selected ng-if="!combos.required">Select an option</option>
          </select>
        </div>
      </div>
      <div class="add-to-card__item"
           ng-if="dish.extra_dish.length > 0">
        <div class="checkbox custom-checkbox-02"
             ng-repeat="ex in dish.extra_dish">
          <label class="custom-control custom-checkbox">
            <input class="custom-control-input"
                   type="checkbox"
                   ng-model="extra[ex.id]"
                   ng-value="{{ex.id}}">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">{{ex.name}} + {{ex.price | currencyFormat}}</span>
          </label>
        </div>
      </div>
      <div class="add-to-card__item"
           ng-if="free_food_list.length > 0">
        <label class="form__label">
          Free food
        </label>
        <select class="form-control form-select"
                name="free_food"
                ng-model="free_food"
                ng-options="ff.id as ff.name for ff in free_food_list">
          <option value="" selected ng-if="!combos.required">Select an option</option>
        </select>
      </div>
      <div class="add-to-card__footer">
        <button type="submit" class="md-btn md-btn--primary">Add to cart</button>
      </div>
    </form>
  </div>
  <button title="Close (Esc)"
          class="mfp-close"
          type="button"
          ng-click="closeDish()">×</button>
</div>
