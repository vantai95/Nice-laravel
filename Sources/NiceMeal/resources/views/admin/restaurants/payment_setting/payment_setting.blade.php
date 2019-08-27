@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content payment-setting">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($detailInfo, ['method' => 'PATCH',
            'url' => ['/admin/'. $res->res_Slug .'/update-payment-setting/'.$detailInfo->id],
            'class' => 'm-form m-form--fit m-form--label-align-right',
            'id' => 'submitForm', 'files' => true]) !!}
        @include ('admin.restaurants.payment_setting.form', ['submitButtonText' => @trans('admin.restaurants.buttons.update')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection