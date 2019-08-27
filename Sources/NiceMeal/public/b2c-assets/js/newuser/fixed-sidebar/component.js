app.directive('sbLbRestaurant', function () {
    return {
        restrict: 'E',
        scope: {
            data: '@'
        },
        template: `
    <div class="row">
      <div class="col-lg-5 col-md-5 col-sm-6 fixed-header-content-restaurant-img">
        <img class="img-fluid rounded-circle" src='<% restaurant.image %>' alt="">
      </div>
      <div class="col-lg-7 col-md-7 col-sm-6 fixed-header-content-detail-restaurant">
        <div class="fixed-header-content-detail-restaurant-name">
          <% restaurant.name %>
        </div>
        <div class="fixed-header-content-detail-restaurant-description">
          <% restaurant.title_brief %>
        </div>
        <div class="row">
          <div class="col-md-7">
            <div class="fixed-header-content-detail-restaurant-delivery">
              <label><i class="fa fa-trophy"></i> V I P</label>
            </div>
            <div class="fixed-header-content-detail-restaurant-delivery">
              <label><i class="fa fa-motorcycle"></i> 30 mins</label>
            </div>
          </div>
          <div class="col-md-5 rank-one-restaurant">1st</div>
        </div>
      </div>
    </div>`,
        controller: function ($scope) {
            $scope.restaurant = JSON.parse($scope.data);
        }
    }
});

app.directive('sbChatPerson', function () {
    return {
        restrict: 'E',
        scope: {
            data: '@'
        },
        template: `<div class="row">
      <div class="col-lg-3 col-md-5 col-sm-6 fixed-header-content-person-img">
        <img class="img-fluid rounded-circle" src="<% person.img %>" alt="">
      </div>
      <div class="col-lg-9 col-md-7 col-sm-6 fixed-header-content-detail-person">
        <div class="fixed-header-content-detail-person-name">
          <% person.name %>
        </div>
        <div class="fixed-header-content-detail-person-status">
          <% person.status %>
        </div>
      </div>
    </div>`,
        controller: function ($scope) {
            $scope.person = JSON.parse($scope.data);
        }
    };
});
