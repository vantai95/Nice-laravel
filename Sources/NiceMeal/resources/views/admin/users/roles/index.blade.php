@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark">
                        <th class="text-center">@lang('admin.roles.columns.name')</th>
                        <th style="width:10%" class="text-center">@lang('admin.users.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $key => $item)
                        <tr>
                            <td class="text-center">
                              {{ $item->name }}
                            </td>
                            <td class="text-nowrap text-center">
                                <a href="{{ url('/admin/roles/' . $item->id) }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="Edit">
                                    <i class="la la-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $roles->appends(['q' => Request::get('q')])->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
