@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($tag, ['method' => 'PATCH',
                    'url' => ['/admin/tags', $tag->id],
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.tags.form', ['submitButtonText' => @trans('admin.tags.buttons.update')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection
