<!-- Modal -->
  <div class="modal fade modal-home" id="myModalLocation" ng-controller="LocationPopUpCtrl" role="dialog">
    <div class="modal-dialog modal-dialog-home">
      <form ng-submit="goToRestaurantList()" method="get">
      <!-- Modal content-->
        <div class="modal-content modal-content-home">
            <div class="modal_header">
	          	<img src="/b2c-assets/img/logo_new.png" class="pull-left"/></a>
	        </div>
            <div class="modal_body">
            	<label class="wrap">
            		<select class="dropdown" ng-model="selectedService">
            			<option value="" disabled selected>--Please select service--</option>
                  @foreach($restaurantServices as $key => $service)
                  <option value="{{$key}}">{{$service}}</option>
                  @endforeach
            		</select>
				</label>
				<label class="wrap">
            		<select class="dropdown" ng-model="selectedCountry">
            			<option value="" disabled>--Please select country--</option>
                  @foreach($countries as $country)
                  <option selected ng-value="{{$country->id}}">{{$country->name}}</option>
                  @endforeach
            		</select>
				</label>
				<label class="wrap">
            		<select class="dropdown" ng-model="selectedProvince" ng-change="getDistricts()" ng-disabled="!selectedCountry">
                  <option value="" disabled>--Please select provinces--</option>
                  @foreach($provinces as $province)
                  <option selected ng-value="{{$province->id}}">{{$province->name}}</option>
                  @endforeach
            		</select>
				</label>
				<label class="wrap">
            		<select class="dropdown" ng-model="selectedDistrict" ng-change="getWards()" ng-disabled="!selectedProvince">
            			<option value="" disabled selected>District</option>
                  <option ng-repeat="district in districtList" value="<% district.id %>"><% district.name %></option>
            		</select>
				</label>
				<label class="wrap">
            		<select class="dropdown" ng-model="selectedWard"  ng-disabled="!selectedDistrict">
                  <option value="" disabled selected>Ward</option>
                  <option ng-repeat="ward in wardList" value="<% ward.ward_id %>"><% ward.ward_name %></option>
            		</select>
				</label>
            	{{--<label style="text-align: center; color: red"><p style="margin-top: 15px;margin-bottom: -6px;">OR</p></label>--}}
				{{--<label class="wrap">--}}
            		{{--<select class="dropdown">--}}
            			{{--<option>Address / Zip Code</option>--}}
            		{{--</select>--}}
				{{--</label>--}}
			</div>
			<div class="modal_map">
            	<div class="row row-find" style="margin-bottom: 25px;">
            		<div class="col-btn col-sm-10">
            			<button type="submit" class="btn btn-submit" ng-disabled="!checkIfAllSelectIsChose()">Let's eat</button>
            		</div>
            		{{--<div class="col-sm-2">--}}
            			{{--<img src="/b2c-assets/img/shape.png"/>--}}
            		{{--</div>--}}
            	</div>
            </div>
            <div class="modal_footer">
                <div class="row capture">
                	<div class="col-sm-6">
                		<img src="/b2c-assets/img/appstore.png" style="margin-left: 10%;"/>
                	</div>
                	<div class="col-sm-6">
                		<img src="/b2c-assets/img/googleplay.png"/>
                	</div>
                </div>
            </div>
        </div>
        </form>
    </div>
  </div>
  @section('extra_scripts')
    <script type="text/javascript">
        $().ready(function(){
            console.log('1');
            $('.selectpicker').selectpicker({
                iconBase: 'fa',
                tickIcon: 'fa-chevron-down',
             });
        })
    </script>
@endsection
