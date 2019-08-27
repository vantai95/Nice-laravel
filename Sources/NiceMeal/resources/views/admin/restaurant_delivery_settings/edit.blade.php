@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::model($mainDS, ['method' => 'PATCH',
            'url' => ['/admin/'.$res->res_Slug.'/restaurant-delivery-settings', $mainDS->id],
            'class' => 'm-form m-form--fit m-form--label-align-right',
            'id' => 'submitForm']) !!}
        @include ('admin.restaurant_delivery_settings.form', ['submitButtonText' => @trans('admin.buttons.update'),'subDS' => $subDS])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection
