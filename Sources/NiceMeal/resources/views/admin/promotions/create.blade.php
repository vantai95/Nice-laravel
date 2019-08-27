@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content hidden">
        <div class="m-portlet">
        <!--begin::Form-->
        {!! Form::open([
            'id' => 'submitForm',
            'method' => 'POST', 
            'url' => '/admin/'. (isset($slug) ? $res->res_Slug. '/promotions' : 'vouchers'), 
            'class' => 'promotion-form m-form m-form--fit m-form--label-align-right', 
            'files' => true]) 
        !!}
        @include ('admin.promotions.form')
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection
