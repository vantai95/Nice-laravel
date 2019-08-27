<div class="search" id="filter-search">
    <div class="inputWithIcon inputIconBg">
        <i class="fa fa-filter icon-filter"></i>
        <ul class="sel-filter">
            <li class="sel-sel-filter">
                <div class="title-sel-filter">Delhi</div>
                <div style="position: absolute;color: #b20016;top: -1px;right: 7px;">x</div>
            </li>
            <li class="sel-sel-filter">
                <div class="title-sel-filter">Hudson</div>
                <div style="position: absolute;color: #b20016;top: -1px;right: 7px;">x</div>
            </li>
        </ul>
    </div>
</div>
<div class="random">
    <div class="">
        <select class="form-control select-sort" style="border: unset;">
            <option value="random" label="Random" >Random</option>
            <option value="ranking" label="Ranking">Ranking</option>
            <option value="name" label="Name">Name</option>
            <option value="new" label="New">New</option>
        </select>
        <i class="fa fa-chevron-down"></i>
    </div>
</div>
<div id="modal-filter" class="search" style="display: none; clear:both; border-bottom: unset; ">
    <div class="ms-options">
        <div class="ms-search">
            <!-- <input type="text" value="" placeholder="Choose tags below or type here..."> -->
            <div style="border: 1.5px solid;height: 40px; border-radius: 7px;margin: 12px; ">
                <ul class="sel-filter" style="">
                    <li class="sel-sel-filter">
                        <div class="title-sel-filter">Delhi</div>
                        <div style="position: absolute;color: #b20016;top: -1px;right: 7px;">x</div>
                    </li>
                    <li class="sel-sel-filter" style="">
                        <div class="title-sel-filter">Hudson</div>
                        <div style="position: absolute;color: #b20016;top: -1px;right: 7px;">x</div>
                    </li>
                </ul>
            </div>
        </div>
        <ul>
            <li class="optgroup" style="clear: both;">
                <span class="label" style="clear: both;">Cuisine</span>
                <ul class="cuisine" style="column-count: 2; column-gap: 0px;">
                    <li class="li_span_title <% (cuisineSelected(cuisine.id)) ? 'selected' : '' %>" ng-repeat="cuisine in cuisines" ng-click="chooseCuisine($event,cuisine.id)">
                        <label class="cuisineId" for="ms-opt-1" id="<% cuisine.name %>">
                            <% cuisine.name %>
                        </label>
                    </li>
                </ul>
                <div class="cuisine-buttom">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    <span class="page-number">
                        <span>1</span>
                        <span>/</span>
                        <span>2</span>
                    </span>
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </div>
            </li>
            <li class="optgroup" style="clear: both;">
                <span class="label" style="clear: both;">Category</span>
                <ul class="categories" style="column-count: 2; column-gap: 0px;">
                    <li class="li_span_title <% (categorySelected(category.id)) ? 'selected' : '' %>" data-search-term="philadelphia" ng-click="chooseCategory($event,category.id)" ng-repeat="category in categories">
                        <label for="ms-opt-18" value="<% category.name %>">
                            <% category.name %>
                        </label>
                    </li>
                </ul>
                <div class="categories-buttom">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    <span class="page-number">
                        <span>1</span>
                        <span>/</span>
                        <span>2</span>
                    </span>
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </div>
            </li>
        </ul>
        <div class="btn-filter">
            <input type="button" value="Apply" class="btn-apply-filter" style="border-radius: 21px !important">
            <input class="btn-cancel-filter" value="Cancel" type="button" style="border-radius: 21px !important">
        </div>
    </div>
</div>


