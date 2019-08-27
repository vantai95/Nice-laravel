<div class="main">
    <div class="vat">
        <p>(All prices & fees do not include VAT)</p>
    </div>
    <div class="title" style="margin-bottom: 15px">
        <p class="text"><%selectedCategory.title%></p>
    </div>
    <div class="product">
        <div class="row" ng-repeat="dish in selectedCategory.dishes" ng-click="selectDish(dish.id)"
             ng-class="{'unclickable' : dish.disabled == 1}">
            <div class="col-md-5 col-xs-5" id="dish-img">
                <a href="#" style="position: relative;">
                    <img ng-class="{'not-available' : dish.disabled == 1}"
                         ng-if="dish.image == null || dish.image == '' " src='/b2c-assets/img/dish.png'
                         style="width: 100%"/>
                    <img ng-class="{'not-available' : dish.disabled == 1}" ng-if="dish.image != null"
                         src="{{config('filesystems.disks.azure.url').'/'}}<% dishImage(dish.image) %>"
                         style="width: 100%"/>
                    <p ng-if="dish.disabled == 1" class="not-available-text">Dish not available</p>
                </a>
            </div>
            <div class="col-md-7 col-xs-7">
                <div class="name" style="width: 100%">
                    <p><%dish.name%></p>
                </div>
                <div class="description" style="width: 100%">
                    <p ng-bind-html="dish.description | trustHtml"></p>
                </div>
                <div class="promotion col-md-6 col-xs-6">
                    <a href="#">
                        <img src="/b2c-assets/img/img-promo.png" style="width: 13%"/>
                    </a>
                    <a href="#">
                        <img src="/b2c-assets/img/img-promo.png" style="width: 13%"/>
                    </a>
                </div>
                <div class="price col-md-6 col-xs-6">
                    <span><%dish.price.formatCurrency()%></span>
                    <button type="button" ng-class="{'btn-disable' : dish.disabled == 1}">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>
