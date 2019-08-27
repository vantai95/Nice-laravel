
@extends('newuser.components.layouts.fixed-sidebar.main',['type' => 'right'])

@section('sidebar-layout')
  {{--@component('newuser.components.layouts.fixed-sidebar.chat.main',['type' => 'right', 'header' => "Let's talk"])
  @endcomponent--}}
  @component('newuser.components.layouts.fixed-sidebar.cart.main',['type' => 'right', 'header' => "Let's eat", 'isCheckoutPage' => isset($isCheckoutPage) ? true : false, 'isRestaurantPage' => isset($isRestaurantPage) ? true : false])
  @endcomponent
@overwrite
