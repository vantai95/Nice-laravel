@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($printer, [ 'method' => 'PATCH', 'url' => [ (isset($slug) ? '/admin/' . $res->res_Slug : '/admin') . '/printers', $printer->id], 'class' => 'printer-form m-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
                    @include ('admin.printers.form', ['submitButtonText' => @trans('admin.printers.buttons.upgrate')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection