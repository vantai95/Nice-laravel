@extends('newuser.layouts.app')
@section('content')
<div class="maincontent restaurants" ng-init="" ng-controller="RestaurantListCtrl">
    <div class="widget-title row">
        <h4>
            Restaurants
        </h4>
        <button id="btn-top" title="Go to top">
          <i class="fa fa-arrow-up" style="margin-right: 10px" aria-hidden="true"></i>
          <span>UP</span>
        </button>
    </div>
    <div class="filter row">
        @include('newuser.components.filter.filter')
    </div>
    <div class="restaurants-list row">
      @include('newuser.components.restaurant.res-list-component')
    </div>
  @include('newuser.components.restaurant.popup-info-res')
</div>

@endsection

@push('extra_scripts')
<script type="text/javascript" src="/b2c-assets/js/newuser/restaurants/list.js"></script>
<script type="text/javascript" src="/b2c-assets/js/newuser/restaurants/filter-restaurant.js"></script>
<script type="text/javascript" src="/b2c-assets/js/newuser/restaurants/component.js"></script>
<script type="text/javascript">
  angular.element(document).ready(function(){
    $restaurantListScope = angular.element('[ng-controller=RestaurantListCtrl]').scope();
    $restaurantListScope.currentLocation = @json([
      'district' => Route::getCurrentRoute()->parameters()['slug'],
      'ward' => Request::get('ward')
    ]);
    $restaurantListScope.restaurants = [];
    $restaurantListScope.cuisines = @json($cuisines);
    $restaurantListScope.categories = @json($categories);
    $restaurantListScope.selectedCuisines = [];
    $restaurantListScope.selectedCategories = [];
    $restaurantListScope.init();
  })
</script>
@endpush
