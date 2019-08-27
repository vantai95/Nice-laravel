@extends('newuser.components.layouts.fixed-sidebar.sample.dropdown-and-search',['header' => $header, 'type' => $type, 'ngController' => 'ChatCtrl'])

@php
$user = [
  "img" => "\b2c-assets\img\Capture.png",
  "name" => "This is name",
  "status" => "I'm bored"
];
@endphp

@section('dropdownandsearch-sample-dropdown')
  <select class="form-control" name="">
    <option value="foody">Foody</option>
    <option value="bestfriend">Best Friend</option>
  </select>
@overwrite

@section('dropdownandsearch-sample-content')
  <ul class="widget-categories fixed-sidebar-content-person">
    <li>
      <sb-chat-person data='@json($user)'></sb-chat-person>
    </li>
  </ul>
@overwrite

@section('dropdownandsearch-sample-search')
  <div class="search-wrapper">
    <input type="text" class="form-control header-search-input" placeholder="Restaurant name" name="" value="">
    <a href="#">
      <i class="fa fa-search"></i>
    </a>
  </div>
@overwrite
