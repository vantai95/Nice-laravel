@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::open(['url' => '/admin/'.$res->res_Slug.'/restaurants-cuisines', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'novalidate'=>'novalidate','class' => 'category-form m-form m-form--fit m-form--label-align-right', 'id' => 'submitForm']) !!}
        @include ('admin.restaurants_cuisines.form')
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')

@endsection
