@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::open([
                    'url' => '/admin/restaurant-work-times',
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm']) !!}
                    @include ('admin.restaurant_work_times.form')
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')

@endsection