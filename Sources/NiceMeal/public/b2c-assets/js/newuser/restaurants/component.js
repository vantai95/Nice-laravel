app.directive('restaurant',function(){
  return {
    restrict: 'E',
    scope :{
      restaurant: '=restaurant'
    },
    template: `<div class="col-md-6 product">
        <div class="image">
            <a href="<% getRestaurantLink(restaurant) %>"><img src="/b2c-assets/img/restaurant_image.jpg"/></a>
        </div>
        <div class="res-right">
            <div class="res-right-header">
                <h6 class="res-name"><a href="<% getRestaurantLink(restaurant) %>"><% restaurant.name %></a></h6>
                <nav class="navbar navbar-inverse">
                  <div class="container-fluid">
                    <ul class="nav navbar-nav">
                      <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="fa-ellipsis-h" style="font-family: FontAwesome;"></span>
                        </a>
                        <span class="glyphicon glyphicon-option-horizontal"></span>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="fa fa-question-circle" aria-hidden="true"></i><span>FAQs</span></a></li>
                          <li><a href="#"><i class="fa fa-share" aria-hidden="true"></i><span>Share</span></a></li>
                          <li><a href="#" data-toggle="modal" data-target="#modalInfo"><i class="fa fa-info" aria-hidden="true"></i><span>Info</span></a></li>
                          <li><a href="#"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><span>Report</span></a></li>
                          <li><a href="#"><i class="fa fa-ban" aria-hidden="true"></i><span>CUT</span></a></li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </nav>
            </div>
            <p class="text" title="<% restaurant.title_brief %>"><% restaurant.title_brief %></p>
            <ul class="favorite">
                <li>
                    <ul class="ratting">
                        <li>Tasty</li>
                        <span style="color: red">4</span><i class="fa fa-star" style="color: #fec328" aria-hidden="true"></i>
                    </ul>
                </li>
                <li>
                    <ul class="ratting">
                        <li>Professional</li>
                        <span style="color: red">4</span><i class="fa fa-star" style="color: #fec328" aria-hidden="true"></i>
                    </ul>
                </li>
                <li>
                    <ul class="ratting">
                        <li>Afforable</li>
                        <span style="color: red">4</span><i class="fa fa-star" style="color: #fec328" aria-hidden="true"></i>
                    </ul>
                </li>
                <li>
                    <ul class="ratting">
                        <li>Eco-friendly</li>
                        <span style="color: red">4</span><i class="fa fa-star" style="color: #fec328" aria-hidden="true"></i>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="line">
          <hr style="width: 100%">
        </div>
    </div>`,
    controller: ['$scope', function restaurantComponentCtrl($scope){

      $scope.getRestaurantLink = function(restaurant){
        var restaurant_slug = restaurant.slug;
        var district = restaurant.restaurant_delivery_setting[0].district_slug;
        var ward = restaurant.restaurant_delivery_setting[0].ward_id;
        return `/restaurants/${restaurant_slug}?district=${district}&ward=${ward}`;
      }

    }]
  };
});
