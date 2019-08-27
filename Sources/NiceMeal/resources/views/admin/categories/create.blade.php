@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
            <div class="row">
                <div class="col-lg-7">
                {!! Form::open(['url' => '/admin/'.$res->res_Slug.'/categories', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'novalidate'=>'novalidate','class' => 'category-form m-form m-form--fit m-form--label-align-right', 'id' => 'submitForm', 'files' => true]) !!}
                    @include ('admin.categories.form')
                {!! Form::close() !!}
                </div>
                <div class="col-lg-5 right-side-item bg-light" style="font-size: 11px;">
                    <div id="categories-extra-item" class="col-md-12" style="position: fixed; width: 440px;">
                        @include ('admin.reuse_template.categories_tabs')
                    </div>
                    {!! Form::open(['method'=>'POST','url'=> "/admin/".$res->res_Slug."/customizations", 'class' => 'm-form m-form--fit m-form--label-align-left', 'id' => 'customizationForm','data-method'=>'']) !!}
                    @include('admin.customizations.reuse.form')
                    @include('admin.time_base_display_rules.reuse.detail')
                    {!! Form::close() !!}
                </div>
            </div>
        
        <!--end::Form-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    @include('admin.customizations.reuse.script');
    @include('admin.time_base_display_rules.reuse.script');
    @include('admin.categories.script')
@endsection
