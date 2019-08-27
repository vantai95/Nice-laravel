@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        {!! Form::open(['method' => 'GET', 'url' => '/admin/contacts', 'class' => 'col-lg-10', 'role' => 'search'])  !!}
                        <div class="col-lg-10 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-lg-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input" name="q"
                                               value="{{ Request::get('q') }}"
                                               class="form-control m-input"
                                               placeholder="@lang('admin.cuisines.search.place_holder_text')"
                                               id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="col-lg-2 order-1 order-xl-2 m--align-right">
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.contacts.columns.name')</th>
                        <th>@lang('admin.contacts.columns.email')</th>
                        <th>@lang('admin.contacts.columns.phone')</th>
                        <th>@lang('admin.contacts.columns.title')</th>
                        <th>@lang('admin.contacts.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($contacts as $key => $item)
                        <tr class="text-center">
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->title }}</td>
                            <td class="text-nowrap">
                                <a href="{{ url('/admin/contacts/' . $item->id ) }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.contacts.breadcrumbs.show_event')">
                                    <i class="la la-commenting"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/contacts', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $contacts->appends(['q' => Request::get('q')])->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
