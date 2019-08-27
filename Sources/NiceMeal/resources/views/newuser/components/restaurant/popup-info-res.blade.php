<!-- Modal -->
<div class="modal fade modal-info" id="modalInfo" role="dialog">
	<div class="modal-dialog modal-dialog-info">
      <!-- Modal content-->
      	<div class="modal-content modal-content-info">
			<div class="modal_header">
				<button type="button" class="close" data-dismiss="modal">X</button>
			</div>
      		<div class="modal_body row">
      			<div class="col-sm-5 col-img"><img src="/b2c-assets/img/restaurant_image.jpg" style="width: 83%"/></div>
      			<div class="col-sm-7 col-text">
      				<p class="res-name"><% selectedRestaurant.name %><i class="fa fa-heart-o icon-heart" aria-hidden="true"></i></p>
					<p class="res-title"><% selectedRestaurant.title_brief %></p>
					<p class="res-btn" style=""><button  class="btn-talk" style="">Let's Talk</button></p>
      			</div>
      		</div>
      		<div class="body-main">
      			<p class="text-main"><% htmlToPlaintext(selectedRestaurant.intro) %></p>
      		</div>
      		<div class="body-star row">
      			<div class="col-md-6 col-sm-6 col-one">
      				<div class="col-md-7 col-sm-7">Tasty</div>
      				<div class="col-md-5 col-sm-5">4<i class="fa fa-star icon-star" aria-hidden="true"></i></div>
      			</div>
      			<div class="col-md-6 col-sm-6 col-two" style="padding: 0px;">
      				<div class="col-md-7 col-sm-7">Professional</div>
      				<div class="col-md-5 col-sm-5">4<i class="fa fa-star icon-star" aria-hidden="true"></i></div>
      			</div>
      			<div class="col-md-6 col-sm-6 col-one" style="padding: 0px;">
      				<div class="col-md-7 col-sm-7">Afforable</div>
      				<div class="col-md-5 col-sm-5">4<i class="fa fa-star icon-star" aria-hidden="true"></i></div>
      			</div>
      			<div class="col-md-6 col-sm-6 col-two" style="padding: 0px;">
      				<div class="col-md-7 col-sm-7">Eco-friendly</div>
      				<div class="col-md-5 col-sm-5">4<i class="fa fa-star icon-star" aria-hidden="true"></i></div>
      			</div>
      		</div>
      		<div class="body-img">
      			<div style="width: 100%;">
      			   <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2965.0824050173574!2d-93.63905729999999!3d41.998507000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sWebFilings%2C+University+Boulevard%2C+Ames%2C+IA!5e0!3m2!1sen!2sus!4v1390839289319" width="100%" height="" frameborder="0" style="border:0"></iframe>
      			</div>	
      		</div>
	      	<div class="body-icon row" style="padding: 0px 30px;">
	      		<div class="col-md-6 col-sm-6 delivery">
	      			<p ng-class="{'services-info': selectedRestaurant.vip_restaurant != null }"><i class="fa fa-trophy icon-col" aria-hidden="true"></i>V I P</p>
	      			<p class="services-info"><i class="fa fa-clock-o icon-col" aria-hidden="true"></i>30 mins</p>
	      			<p ng-class="{'services-info':selectedRestaurant.cod_payment != '' }"><i class="fa fa-circle-o icon-col" aria-hidden="true"></i>Cash</p>
	      			<p ng-class="{'services-info':selectedRestaurant.online_payment != ''}"><i class="fa fa-check-square-o icon-col" aria-hidden="true"></i>Online payment</p>
	      		</div>
	      		<div class="col-md-6 col-sm-6 service">
	      			<p ng-class="{'services-info':selectedRestaurant.discovery != '' && selectedRestaurant.discovery != undefined }"><i class="fa fa-circle-o icon-col" aria-hidden="true"></i>Discovery</p>
	      			<p ng-class="{'services-info':selectedRestaurant.delivery != '' }"><i class="fa fa-check-square-o icon-col" aria-hidden="true"></i>Delivery</p>
	      			<p ng-class="{'services-info':selectedRestaurant.pickup != '' }"><i class="fa fa-circle-o icon-col" aria-hidden="true"></i>PickUp</p>
	      			<p ng-class="{'services-info':selectedRestaurant.book-table != '' }"><i class="fa fa-check-square-o icon-col" aria-hidden="true"></i>BookTable</p>
	      		</div>
	      	</div>
	      	<div class="body-btn" style="">
	      		<button  class="btn-talk">Let's Talk</button>
	      	</div>
      	</div>
    </div>
</div>