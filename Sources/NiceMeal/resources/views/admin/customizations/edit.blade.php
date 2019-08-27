@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::open(['method'=>'PATCH','url' => ['/admin/'.$res->res_Slug.'/customizations',$customization->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitForm']) !!}
                    {{ csrf_field() }}
                    @include ('admin.customizations.form',['customization'=>$customization,'option'=>$option])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    @include('admin.customizations.mainscript')
@endsection
