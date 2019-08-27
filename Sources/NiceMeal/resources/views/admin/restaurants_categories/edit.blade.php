@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($category, [ 'method' => 'PATCH', 'url' => ['/admin/restaurants-categories', $category->restaurants_categories_id], 'class' => 'category-form m-form m-form--fit m-form--label-align-right', 'files' => true]) !!}
                    @include ('admin.restaurants_categories.form', ['submitButtonText' => @trans('admin.categories.buttons.upgrate')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection