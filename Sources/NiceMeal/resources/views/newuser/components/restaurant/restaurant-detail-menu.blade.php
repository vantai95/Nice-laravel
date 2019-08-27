<div class="category-menu row">
    <div id="owl-demo" class="owl-carousel owl-theme">
        <div class="item">Note</div>
        <div class="item <% (category.id === selectedCategory.id) ? 'selected' : '' %>" ng-repeat="category in categories" ng-click="selectCategory(category.id)">
            <%category.title%>
        </div>
    </div>
</div>
