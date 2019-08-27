@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($tagInfo, ['method' => 'PATCH',
            'url' => ['/admin/'. $res->res_Slug .'/update-tags/'.$tagInfo->id],
            'class' => 'm-form m-form--fit m-form--label-align-right',
            'id' => 'submitForm', 'files' => true]) !!}
        @include ('admin.restaurants.tags.form', ['submitButtonText' => @trans('admin.restaurants.buttons.update')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection