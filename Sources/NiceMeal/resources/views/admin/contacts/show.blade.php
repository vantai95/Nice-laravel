@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="card px-2">
                <div class="card-body">
                    <div class="container-fluid">
                        <h5 class="my-5">{{ $contact->title }}</h5>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3">
                            <p>Name : {{ $contact->name }}</p>
                        </div>
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-3">
                            Email : {{ $contact->email }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <p>Phone : {{ $contact->phone }}</p>
                        </div>
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-3">
                            File attachment :
                            @if(isset($contact->file_attach))
                            <a class="btn btn-sm btn-link" href="{{ url('admin/contacts/download/'.$contact->id) }}" target="_blank">{{ explode('-',$contact->file_attach)[1] }}</a>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <p>{{ $contact->message }}</p>
                        </div>
                    </div>
                    <div class="container-fluid w-100">
                        <a href="{{ url('/admin/contacts') }}" class="btn btn-default float-right mt-4">
                            Back to list
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_scripts')

@endsection
