@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
        {!! Form::open(['url' => '/admin/'.$res->res_Slug. '/printers', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'novalidate'=>'novalidate','class' => 'printer-form m-form m-form--fit m-form--label-align-right', 'id' => 'submitForm', 'files' => true]) !!}
        @include ('admin.printers.form')
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
    </script>
@endsection
