@extends('layouts.app')
@section('content')
<div class="md-content">

    @include('user.social-tools')

    <!-- Section -->
    <section class="md-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="sidebar-left">

                        <div class="form-item ui-select-box has-button">
                            <div class="ui-select-container select2 select2-container ng-valid ng-touched" ng-class="{'select2-container-active select2-dropdown-open open': $select.open, 'select2-container-disabled': $select.disabled, 'select2-container-active': $select.focus, 'select2-allowclear': $select.allowClear &amp;&amp; !$select.isEmpty()}"
                                ng-model="selectedLocation.value">
                                <a class="select2-choice ui-select-match">
                                    <span class="select2-chosen ng-binding ng-hide" style="">Choose your location</span>
                                    <span class="select2-chosen" style=""><span>Quận 12</span></span>
                                    <!-- ngIf: $select.allowClear && !$select.isEmpty() --> <span class="select2-arrow ui-select-toggle"><b></b></span>
                                </a>
                                <div class="ui-select-dropdown select2-drop select2-with-searchbox select2-drop-active select2-display-none"
                                    ng-class="{'select2-display-none': !$select.open}" style="opacity: 0;">
                                    <div class="search-container select2-search" ng-class="{'ui-select-search-hidden':!$select.searchEnabled, 'select2-search':$select.searchEnabled}">
                                        <input type="search" autocomplete="off" autocorrect="off" autocapitalize="off"
                                            spellcheck="false" ng-class="{'select2-active': $select.refreshing}" role="combobox"
                                            aria-expanded="true" aria-owns="ui-select-choices-0" aria-label="Select box"
                                            class="ui-select-search select2-input ng-pristine ng-valid ng-touched"
                                            ng-model="$select.search" style="width: 258px;"></div>
                                    <ul tabindex="-1" class="ui-select-choices ui-select-choices-content select2-results"
                                        repeat="item in (location | filter: $select.search | limitTo: 3) track by item.id">
                                        <li class="ui-select-choices-group" ng-class="{'select2-result-with-children': $select.choiceGrouped($group) }">
                                            <div ng-show="$select.choiceGrouped($group)" class="ui-select-choices-group-label select2-result-label ng-binding ng-hide"
                                                ng-bind="$group.name"></div>
                                            <ul id="ui-select-choices-0" ng-class="{'select2-result-sub': $select.choiceGrouped($group), 'select2-result-single': !$select.choiceGrouped($group) }"
                                                class="select2-result-single">
                                                <!-- ngRepeat: item in $select.items track by item.id -->
                                                <!-- ngIf: $select.open -->
                                                <!-- end ngRepeat: item in $select.items track by item.id -->
                                                <!-- ngIf: $select.open -->
                                                <!-- end ngRepeat: item in $select.items track by item.id -->
                                                <!-- ngIf: $select.open -->
                                                <!-- end ngRepeat: item in $select.items track by item.id -->
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="ui-select-no-choice"></div>
                                </div>
                                <ui-select-single></ui-select-single>
                                <input ng-disabled="$select.disabled" class="ui-select-focusser ui-select-offscreen ng-scope"
                                    type="text" id="focusser-0" aria-label="Select box focus" aria-haspopup="true" role="button">
                            </div>
                            <a class="md-btn md-btn--primary" ui-sref="pageSearch({district_slug: selectedLocation.value.slug})"
                                href="/nha-hang-o-quan-12">Go</a>
                        </div>
                        <!-- widget -->
                        <div class="widget">
                            <h2 class="widget__title">Filter</h2>
                            <div class="widget__content">
                                @foreach($filterList as $title => $list)
                                <div class="widget-filter">
                                    <div class="widget-filter__item">
                                        <h3 class="widget-filter__title" onclick="openItem(this)">
                                            {{ $title }}
                                            <span class="widget-filter__toggle">-</span>
                                        </h3>
                                        <ul class="widget-filter__list" style="display: block;">
                                            @foreach($list as $row)
                                            <li class="ng-scope">
                                                <div class="checkbox custom-checkbox-02">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" value="1">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">{{ $row }}</span>
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div><!-- End / widget -->

                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="main-content">

                        <!-- sortbox -->
                        <div class="sortbox">
                            <div class="sortbox__left">
                                <p class="sortbox__text">
                                    {{ sizeof($filteredResults) || 0}} {{ sizeof($filteredResults) > 1 ? " Restaurants"
                                    : " Restaurant" }}
                                    ready to serve you now
                                </p>
                            </div>
                            <div class="sortbox__right">
                                <span class="text">Sort By: </span>
                                <div class="sortbox-element">
                                    <select class="form-control select-sort ng-pristine ng-untouched ng-valid"
                                        ng-options="opt.name for opt in sortBy track by opt.value" ng-model="selectedSort.criteria">
                                        <option value="id" selected="selected" label="Sort by">Sort by</option>
                                        <option value="ranking" label="Ranking">Ranking</option>
                                        <option value="delivery_time" label="Delivery time">Delivery time</option>
                                        <option value="min_order_amount" label="Min. order amount">Min. order amount</option>
                                        <option value="delivery_cost" label="Delivery fee">Delivery fee</option>
                                        <option value="name" label="Name">Name</option>
                                    </select>
                                    <button class="md-btn btn-desc" ng-click="changeDirection($event)"></button>
                                </div>
                            </div>
                        </div><!-- End / sortbox -->

                        <div class="row restaurant-list loaded">
                            @foreach ($filteredResults as $result )
                            <div class="col-sm-6 col-md-6 col-lg-12" <!-- listing-02 -->
                                <div class="listing-02">
                                    <div class="listing-02__media">
                                        <a ui-sref="pageRestaurant.detail({restaurant_slug: item.slug})"><img src="https://i.imgur.com/nDOt4XA.jpg" /></a>
                                        <a class="md-btn md-btn--primary md-btn--sm" href="/restaurants/{{$result}}">view
                                            menu</a>
                                        <span class="listing-02__label" ng-if="item.highlight_label.length > 0"
                                            ng-class="{'success': item.highlight_label === 'popular',
                                      'warning': item.highlight_label === 'high quality',
                                      'error': item.highlight_label === 'new',
                                      'info': item.highlight_label === 'promotion'}">
                                            ytgyhujlk;
                                        </span>
                                    </div>
                                    <div class="listing-02__body">
                                        <h2 class="listing-02__name">
                                            <a ui-sref="pageRestaurant.detail({restaurant_slug: item.slug})">{{$result}}</a>
                                            <span class="btn-like" ng-click="toggleFavorite(item)">
                                                <i class="fa fa-heart"></i>
                                            </span>
                                        </h2>
                                        <p class="listing-02__text">{{$result}}</p>
                                        <ul class="listing-02__list">
                                            <li>
                                                <span ng-if="item.available == 1" class="text-success">Open Now</span>
                                                <span ng-if="item.available != 1">Closed</span>
                                            </li>
                                            <li><span><i class="fa fa-motorcycle"></i>8976543</span></li>
                                            <li><span><i class="fa fa-map-marker"></i>{{$result}}</span></li>
                                            <li><span><i class="fa fa-cart-plus"></i>Min: 654</span></li>
                                        </ul>
                                    </div>
                                    <div class="listing-02__footer">

                                        <!-- rating -->
                                        <div class="rating">
                                            <span class="rating__point">{{$result}}</span>
                                            <div class="rating__rating" title="lyuktyujtrhgerf" count="lyuktyujtrhgerf">
                                                <span class="rating__icon" ng-style="{'width': (item.review_rate * 10) + '%'}"></span>
                                            </div>
                                        </div><!-- End / rating -->

                                        <span class="listing-02__show_rating">
                                            <a ui-sref="pageRestaurant.detail({restaurant_slug: item.slug})">
                                                {{$result}}
                                            </a>
                                        </span>
                                        <a class="md-btn md-btn--primary md-btn--sm" ui-sref="pageRestaurant.detail({restaurant_slug: item.slug})">view
                                            menu</a>
                                    </div>
                                </div><!-- End / listing-02 -->

                            </div>

                            @endforeach
                        </div>
                        <div class="md-text-center">
                            <button class="md-btn md-btn--danger md-btn--sm md-btn--outline-danger" style="min-width:150px;"
                                ng-if="searchResults" ng-hide="resultLimit >= searchResults.length" ng-click="loadMore()">
                                load more
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End / Section -->

    <section class="md-section">
        <div class="container">
            <div class="row sticky-wrap">
                <ui-view class="ng-scope">
                    @
                </ui-view>
            </div>
        </div>
    </section>

</div>

@endsection
@section('extra_scripts')

<script>
    function openItem(element) {
        var list = $(element).parent('.widget-filter__item').children('.widget-filter__list');
        var toggle = $(element).children('.widget-filter__toggle');
        if ($(list).is(":visible")) {
            $(toggle).html('+');
            $(list).slideUp('slow', function () {
                $(list).hide();

            });
        } else {
            $(toggle).html('-');
            $(list).slideDown('fast', function () {
                $(list).show();
            });

        }

    }
</script>

@endsection
