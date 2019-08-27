@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center col-lg-12">
                        <div class="col-lg-12 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                            {!! Form::open(['method' => 'GET', 'url' => '/admin/order-reject-reason', 'class' => 'col-lg-10', 'role' => 'search'])  !!}
                        
                                <div class="col-lg-8">
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
                                {!! Form::close() !!}
                                <div class="col-lg-2 order-1 order-xl-2 m--align-right">
                                    <a href="{{ url('/admin/order-reject-reason/create') }}"
                                    class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                    <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>
                                            @lang('admin.order_reject_reason.breadcrumbs.new_order_reject_reason')
                                        </span>
                                    </span>
                                    </a>
                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>

                            </div>                            
                        </div>                      
                       
                        
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.tags.columns.name_en')</th>
                        <th>@lang('admin.tags.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($orderRejectReasons as $key => $item)
                        <tr class="text-center">
                            <td>{{ $item->name_en }}</td>
                            
                            <td class="text-nowrap">
                                <a href="{{ url('/admin/order-reject-reason/' . $item->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.tags.breadcrumbs.edit_event')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'url' => ['/admin/order-reject-reason', $item->id],
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.tags.breadcrumbs.delete_event')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}
                                {!! Form::open([
                                  'method' => 'POST',
                                  'url' => ['/admin/order-reject-reason/duplicate/'.$item->id],
                                  'style' => 'display:inline'
                               ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmDuplicateSubmit(event, this)"
                                   title="Duplicate">
                                    <i class="la la-copy"></i>
                                </a>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
               
            </div>
        </div>
    </div>
@endsection
