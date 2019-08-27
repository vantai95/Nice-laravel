<div class="widget">
    <h2 class="widget__title">Choose Category</h2>
    <div class="widget__content">
        <!-- widget-categories -->
        <ul class="widget-categories">
            <li ng-repeat="category in categories" ng-click="goToCate(category)">
                <a href="#category-<% category.id %>"
                ng-class="{'text-active': category.id == currCate.id}"><% category.title %></a>
            </li>
        </ul><!-- End / widget-categories -->
    </div>
</div>