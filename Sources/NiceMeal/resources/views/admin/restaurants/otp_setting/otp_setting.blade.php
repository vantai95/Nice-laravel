@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($otpSetting, ['method' => 'PATCH',
            'url' => ['/admin/'. $res->res_Slug .'/update-otp-setting/'.$otpSetting->id],
            'class' => 'm-form m-form--fit m-form--label-align-right',
            'id' => 'submitForm', 'files' => true]) !!}
        @include ('admin.restaurants.otp_setting.form', ['submitButtonText' => @trans('admin.restaurants.buttons.update')])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection