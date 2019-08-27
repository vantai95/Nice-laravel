@extends('admin.layouts.app')

@section('content')
@include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
      <form class="m-form m-form--fit m-form--label-align-right" action="{{ url('admin/roles',$role->id) }}" method="post">
          @csrf
          @method('PATCH')
          @include('admin.users.roles.form',['submitButtonText' => 'Update'])
      </form>
    </div>
</div>
@endsection
