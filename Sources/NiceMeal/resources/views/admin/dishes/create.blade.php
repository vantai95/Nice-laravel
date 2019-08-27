@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
            <div class="row">
                <div class="col-md-7">
                    {!! Form::open(['method'=>'post','url' => '/admin/'.$res->res_Slug.'/dishes', 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitForm']) !!}
                        @include ('admin.dishes.form')
                    {!! Form::close() !!}
                </div>
                <div class="col-md-5 right-side-item bg-light">
                    <div id="customizations" class="col-lg-12 col-md-12" style="position:fixed; width: 440px">
                        @include ('admin.reuse_template.dishes_tabs')
                    </div>
                    {!! Form::open(['method'=>'POST','url'=> "/admin/".$res->res_Slug."/customizations", 'class' => 'm-form m-form--fit m-form--label-align-left', 'id' => 'customizationForm','data-method'=>'']) !!}
                        @include('admin.customizations.reuse.form')
                    {!! Form::close() !!}
                    @include('admin.time_base_display_rules.reuse.detail')
                    @include('admin.time_base_pricing_rules.reuse.detail')
                </div>
            </div>
                
            <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    @include('admin.customizations.reuse.script');
    @include('admin.time_base_display_rules.reuse.script');
    @include('admin.time_base_pricing_rules.reuse.script');
    @include('admin.dishes.script');
@endsection