<div class="col-md-4 col-lg-3" style="margin-top: 30px">
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
	
<div class="col-md-8 col-lg-9" style='margin-top: 30px'>
	<h5>My invoice</h5>	
		<div class="main-content">
			<div class="col-md-12 col-lg-10">
				<table class="mycart">
          <thead>
          <tr>
            <td>
              <h6 class="mycart__title">Code</h6>
            </td>
            <td>
              <h6 class="mycart__title">Restaurant name</h6>
            </td>
            <td>
              <h6 class="mycart__title">Delivery time</h6>
            </td>
            <td>
              <h6 class="mycart__title">Payment amout</h6>
            </td>
						<td>
              <h6 class="mycart__title">Status</h6>
            </td>
          </tr>
          </thead>
          <tbody>
            <tr ng-repeat="item in invoices">
              <td>{{item.code}}</td>
              <td>{{item.restaurant_name}}</td>
              <td>{{item.delivery_time}}</td>
              <td>{{item.payment_amount | currencyFormat}}</td>
              <td>{{item.status}}</td>
						</tr>
						
          </tbody>
        </table>
			</div>
		</div>
</div>

