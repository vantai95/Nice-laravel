<div class="col-lg-3 col-md-4" style="margin-top: 30px">
        <div class="sidebar-left">
    
            <!-- widget -->
            <div class="widget widget__info">
                <h2 class="widget__title">{{profile.display_name}}</h2>
                <div class="widget__content">
    
                    <!-- widget-categories -->
                    <ul class="widget-categories">
                        <li ng-repeat="item in tabInfo" ng-class="{'active': item.url === currentStateName}">
                            <a ui-sref="{{item.url}}"><span class="fa {{item.icon}}"></span>{{item.name}}</a>
                        </li>
                    </ul><!-- End / widget-categories -->
    
                </div>
            </div><!-- End / widget -->
    
        </div>
</div>
<div class="col-lg-9 col-md-8" style="margin-top: 30px">
		<h5>Favourite restaurant</h5>
		<div class="main-content">
			<div class="mycomments">
					<ul class="mycomments__list">
						<li ng-repeat="restaurant in wishlist_full_info">
							<div class="mycomments__img">
								<img src="{{restaurant.image}}" alt="Hình ở đây">
								<a class="md-btn md-btn--primary md-btn--sm" ui-sref="pageRestaurant.detail({restaurant_slug: restaurant.slug})">View menu</a>
							</div>
							<div class="mycomments__body">
								<h5 class="mycomments__title">{{restaurant.name}}</h5>
								<p class="mycomments__time"><span class="fa fa-location"></span>{{restaurant.district_type}} {{restaurant.district_name}}</p>
								<div class="mycomments__rating">
										<div class="mycomments__star-item">
											<div class="rating">
												<div class="rating__rating" title="{{::item.review_rate}}" count="{{::item.num_reviews}}"><span class="rating__icon" ng-style="{'width': (restaurant.review_rate * 10) + '%'}"></span></div>
												<span>({{::restaurant.num_reviews}} {{::restaurant.num_reviews > 1 ? " reviews" : " review"}})</span>
											</div>
										</div>
								</div>
								<p class="favorite__cart"><span class="fa fa-cart-plus"></span>Min: {{::restaurant.min_order_amount | currencyFormat}}</p>
								<p class="favorite__open">
									<span class="active" ng-if="restaurant.available">Open Now</span>
									<span ng-if="!restaurant.available">Closed</span>
								</p>
							</div>
						</li>
				</ul>
			</div>
		</div>	
</div> 