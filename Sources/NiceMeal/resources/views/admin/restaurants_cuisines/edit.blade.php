@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($restaurant_cuisines, [
                    'method' => 'PATCH',
                    'url' => ['/admin/'. $res->res_Slug .'/restaurants-cuisines',
                    $restaurant_cuisines->id],
                    'class' => 'category-form m-form m-form--fit m-form--label-align-right'
                    ])
                !!}
                    @include ('admin.restaurants_cuisines.form', ['submitButtonText' => @trans('admin.restaurants_cuisines.buttons.update')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection