@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::open([
            'method' => 'POST',
            'url' => '/admin/restaurants/import',
            'class' => 'm-form m-form--fit m-form--label-align-right',
            'id' => 'submitForm', 'files' => true]) !!}
            @include ('admin.restaurants.form_import')
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')

@endsection
