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
	<h5>
		Address book
		<a href="" class="address__add-new-button"><span ><i class="fa fa-plus-square"></i></span></a>
	</h5>
	<div class="main-content">
		<div class="promotions">
			<ul class="promotions__list">
				<li>
					<a>
						<h3 class="promotions__title">Default address</h3>
						<p class="promotions__text">{{profile.address}}</p>
					</a>
				</li>
				<li ng-repeat="item in profile.shipping_address">
					<a>
						<h3 class="promotions__title">
							Shipping address
							<span class="address__edit" ng-click="update(item)"><i class="fa fa-edit"></i></span>
							<span class="address__remove" ng-click="remove(item)"><i class="fa fa-trash"></i></span>
						</h3>
						<p class="promotions__text">{{item.address}}</p>
					</a>
				</li>
				<li ng-repeat="item in profile.billing_address">
					<a>
						<h3 class="promotions__title">
							Billing address
							<span class="address__edit" ng-click="update(item)"><i class="fa fa-edit"></i></span>
							<span class="address__remove" ng-click="remove(item)"><i class="fa fa-trash"></i></span>
						</h3>
						<p class="promotions__text">{{item.address}}</p>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
