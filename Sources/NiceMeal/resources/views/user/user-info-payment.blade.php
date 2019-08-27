<div class="col-lg-3 col-md-4" style="margin-top: 30px">
        <div class="sidebar-left">
    
            <!-- widget -->
            <div class="widget widget__info">
                <h2 class="widget__title">Tài khoản của Duy Trần</h2>
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
        <h5>Thông tin thanh toán</h5>
        <div class="main-content">
					<div class="col-md-12 col-lg-10 form-wrap">
							<form class="form-info">
								<div class="payment__icon">
									<div><img src="/img/visa.png"></div>
									<div><img src="/img/master.png"></div>
									
								</div>
								<div class="form-group col-md-12">
									<div class="col-md-3"><span class="form-control">Card Number</span></div>
									<div class="col-md-9"><input type="text"placeholder="Input Card Number" class="form-control"></div>
								</div>
		
								<div class="form-group col-md-12">
										<div class="col-md-3"><span class="form-control">Expires</span></div>
										<div class="col-md-3 ui-select-box">
											<select class="form-control" id="sel2">
													<option selected disabled>Month</option>
													<option ng-repeat="month in range(1,12)">{{month}}</option>
											</select>
										</div>
										<div style="padding-left: 0" class="col-md-3 ui-select-box">
												<select class="form-control" id="sel3">
														<option selected disabled>Year</option>
													<option ng-repeat="year in range(1970,2017)">{{year}}</option>
												</select>
											</div>
								</div>
								<div class="form-group col-md-12">
									<div class="col-md-3"><span class="form-control">Security Code</span></div>
									<div class="col-md-9"><input type="text"placeholder="Input security code" class="form-control"></div>
								</div>
								<div class="form-group col-md-12">
									<div class="col-md-3"><span class="form-control">Cardholder Name (optional)</span></div>
									<div class="col-md-9"><input type="text" placeholder="Duy Trần" class="form-control"></div>
								</div>
		
								<div class="col-md-9 col-md-offset-3">
										<a class="md-btn md-btn--primary col-md-10" style="margin-left: 20px; margin-bottom: 20px">Update</a>
									</div>
							</form>
					</div>
        </div>	
    </div> 