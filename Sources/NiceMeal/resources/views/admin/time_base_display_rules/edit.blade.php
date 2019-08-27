@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($timeBaseDisplayRule, ['method' => 'PATCH',
                    'url' => ['/admin/'.$res->res_Slug.'/time-base-display-rules', $timeBaseDisplayRule->id],
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.time_base_display_rules.form', ['submitButtonText' => @trans('admin.buttons.update')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection
