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
		<h5>My reviews</h5>
		<div class="main-content">
			<div class="mycomments">
				<ul class="mycomments__list">
					<li ng-repeat="comment in profile.comments">
						<div class="mycomments__img">
							<img src="http://www.ebizbydesign.com/data/img/popular-of-restaurant-interior-design-best-ideas-about-small-restaurant-design-on-pinterest-small.jpg" alt="Hình ở đây">
						</div>
						<div class="mycomments__body">
							<h5 class="mycomments__title"><a ui-sref="pageRestaurant.reviews({restaurant_slug: comment.slug})">{{comment.restaurant_name}}</a></h5>
							<p class="mycomments__time">11/5/2018 15:00:21</p>
							<div class="mycomments__rating">
									<div class="mycomments__star-item">

										<!-- rating -->
										<div class="rating">
											<div class="rating__rating" title="4" count="4"><span class="rating__icon" style="width: 73%;"></span></div>
										</div><!-- End / rating -->
							</div>
							<p class="mycomments__comt">{{comment.content}}</p>
						</div>
					</li>
					
			</ul>
			</div>
		</div>	
</div> 