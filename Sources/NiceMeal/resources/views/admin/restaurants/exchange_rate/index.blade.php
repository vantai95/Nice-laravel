@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
            {!! Form::model($settings, ['method' => 'PATCH',
                'url' => ['/admin/'. $res->res_Slug .'/update-exchange-rate/'.$settings->id],
                'class' => 'm-form m-form--fit m-form--label-align-right',
                'id' => 'submitForm', 'files' => true])
            !!}
            @include('admin.restaurants.exchange_rate.form',['submitButtonText' => @trans('admin.restaurants.buttons.update')])
            {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection