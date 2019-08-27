@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
                {!! Form::open(['url' => '/admin/'.$res->res_Slug.'/customizations', 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitForm']) !!}
                    @include ('admin.customizations.form',['restaurants'=>$restaurants])
                {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
  @include('admin.customizations.mainscript')
@endsection
