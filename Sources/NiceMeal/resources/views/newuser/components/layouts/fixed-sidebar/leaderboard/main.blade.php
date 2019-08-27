@extends('newuser.components.layouts.fixed-sidebar.sample.dropdown-and-search',['header' => $header, 'type' => $type, 'ngController' => 'LeaderBoardCrtl' ])

@section('dropdownandsearch-sample-dropdown')
  <select class="form-control" name="">
    <option value="bestsellers">BestSellers</option>
    <option value="topratingstar">Top rating star</option>
  </select>
@overwrite

@section('dropdownandsearch-sample-content')
<ul class="widget-categories fixed-sidebar-content-restaurant">
  @foreach($leaderBoard as $restaurant)
  <li>
    <sb-lb-restaurant data='@json($restaurant)'></sb-lb-restaurant>
  </li>
  @endforeach
</ul>
@overwrite

@section('dropdownandsearch-sample-search')
  <div class="search-wrapper">
    <input type="text" class="form-control header-search-input" placeholder="Contact name" name="" value="">
    <a href="#">
      <i class="fa fa-search"></i>
    </a>
  </div>
@overwrite
