@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::open([
                    'url' => '/admin/'.$res->res_Slug.'/restaurant-work-times',
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm']) !!}
                    @include ('admin.restaurant_work_times.form')
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
<!-- <script type="text/javascript">
  $('#submitForm').submitForm(function(e){
    e.preventDefault();
    alert('hi');
  });
</script> -->
@include('admin.timesetting.script')
@endsection
