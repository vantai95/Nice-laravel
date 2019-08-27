@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($tax, ['method' => !empty($tax) ? 'PATCH' : 'POST',
            'url' => [!empty($tax) ? '/admin/'. $res->res_Slug .'/update-tax-info/'.$tax->id : '/admin/'. $res->res_Slug .'/create-tax'],
            'class' => 'm-form m-form--fit m-form--label-align-right',
            'id' => 'submitForm', 'files' => true]) !!}
        @include ('admin.restaurants.taxes.form', ['submitButtonText' => !empty($tax) ? @trans('admin.restaurants.buttons.update') : @trans('admin.buttons.create')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection