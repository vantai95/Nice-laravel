@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($commissionRule, ['method' => 'PATCH',
                    'url' => ['/admin/commission-rules', $commissionRule->id],
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm']) !!}
                    @include ('admin.commission_rules.form', ['submitButtonText' => @trans('admin.buttons.update')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection
