@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::model($work_times->time_setting, ['method' => 'PATCH',
                    'url' => ['/admin/'.$res->res_Slug.'/restaurant-work-times', $work_times->id],
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm']) !!}
                    @include ('admin.restaurant_work_times.form', ['submitButtonText' => @trans('admin.restaurants.buttons.update')])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
  @include('admin.timesetting.script')
@endsection
