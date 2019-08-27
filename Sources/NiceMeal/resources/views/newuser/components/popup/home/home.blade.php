@extends('newuser.layouts.app')
@section('content')
<div>
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalLocation">Open</button>
<!-- 	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalLogin">OpenLogin</button>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalRegister">OpenRegister</button> -->
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalCart">OpenCart</button>
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalLikeRes">addMylist</button>
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalMymenu">addMymenu</button>
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalAddToCart">addTocart</button>
</div>
<!-- @include('newuser.components.login.login')
@include('newuser.components.login.Register')-->
@include('newuser.components.popup.popup-cart')
@include('newuser.components.popup.popup-list-like-res')
@include('newuser.components.popup.popup-add-my-menu')
@include('newuser.components.popup.popup-add-to-cart')
@endsection
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
