@extends('admin.layouts.app')
   
@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
        {!! Form::model($intro, ['method' => 'PATCH',
            'url' => ['/admin/'. $res->res_Slug .'/update-intro/'.$intro->id],
            'class' => 'm-form m-form--fit m-form--label-align-right',
            'id' => 'submitForm', 'files' => true]) !!}
        @include ('admin.restaurants.intros.form', ['submitButtonText' => @trans('admin.restaurants.buttons.update')])
        {!! Form::close() !!} 
        </div>
    </div>
@endsection
@section('extra_scripts')  <link href="/admin-assets/css/summernote/summernote-ext-faicon.css" rel="stylesheet" type="text/css"/>
  
<script src="/admin-assets/js/summernote/summernote-ext-faicon.js"></script>
@endsection