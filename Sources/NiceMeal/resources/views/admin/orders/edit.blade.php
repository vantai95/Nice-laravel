@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($order, ['method' => 'PATCH',
                    'url' => [\Session::has('res') ? '/admin/'.$res->res_Slug.'/orders'. $order->id : 'admin/orders/'.$order->id],
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm']) !!}
                    @include ('admin.orders.form', ['submitButtonText' => @trans('admin.orders.buttons.update')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')

@endsection