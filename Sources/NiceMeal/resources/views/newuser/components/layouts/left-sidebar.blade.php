
@extends('newuser.components.layouts.fixed-sidebar.main',['type' => 'left'])

@section('sidebar-layout')
  @component('newuser.components.layouts.fixed-sidebar.leaderboard.main',['type' => 'left','header' => 'LeaderBoard 1', 'leaderBoard' => $leaderBoard])
  @endcomponent
@overwrite
