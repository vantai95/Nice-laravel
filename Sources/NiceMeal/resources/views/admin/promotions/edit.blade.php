@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content hidden">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($promotion, [ 
                    'id' => 'submitForm',
                    'method' => 'PATCH', 
                    'url' => [ (isset($slug) ? '/admin/'.$res->res_Slug.'/promotions' : '/admin/vouchers') , $promotion->id], 
                    'class' => 'promotion-form m-form m-form--fit m-form--label-align-right', 
                    'files' => true]) 
                !!}
                    @include ('admin.promotions.form', ['submitButtonText' => @trans('admin.promotions.buttons.upgrate')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection
