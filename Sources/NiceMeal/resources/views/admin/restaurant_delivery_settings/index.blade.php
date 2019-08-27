@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/restaurant-delivery-settings', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label ">
                                            <label class="text-nowrap">
                                                @lang('admin.restaurant_delivery_settings.search.restaurant_id')
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{ url('/admin/'.$res->res_Slug.'/restaurant-delivery-settings/create') }}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    @lang('admin.restaurant_delivery_settings.createButton')
                                </span>
                            </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark">
                        <th>@lang('admin.restaurant_delivery_settings.columns.restaurant_id')</th>
                        <th>@lang('admin.restaurant_delivery_settings.columns.district_id')</th>
                        <th>@lang('admin.restaurant_delivery_settings.columns.from')</th>
                        <th>@lang('admin.restaurant_delivery_settings.columns.to')</th>
                        <th>@lang('admin.restaurant_delivery_settings.columns.delivery_cost')</th>
                        <th>@lang('admin.restaurant_delivery_settings.columns.min_order_amount')</th>
                        <th>@lang('admin.restaurant_delivery_settings.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($restaurantDeliverySettings as $item)
                        <tr>
                            <td class="align-middle">{{ $item->restaurant_name }}</td>
                            <td class="align-middle">{{$item->district_name}}</td>
                            <td class="align-middle">{{ \App\Services\CommonService::formatPriceVND($item->from)}}</td>
                            <td class="align-middle">{{ \App\Services\CommonService::formatPriceVND($item->to)}}</td>
                            <td class="align-middle">{{ \App\Services\CommonService::formatPriceVND($item->delivery_cost )}}</td>
                            <td class="align-middle">{{ \App\Services\CommonService::formatPriceVND($item->min_order_amount )}}</td>
                            <td class="text-nowrap">
                                <a href="{{ url('/admin/'.$res->res_Slug.'/restaurant-delivery-settings/' . $item->delivery_id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.restaurant_delivery_settings.tooltip_title.edit')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'url' => ['/admin/'.$res->res_Slug.'/restaurant-delivery-settings', $item->delivery_id],
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.restaurant_delivery_settings.tooltip_title.delete')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    @if(count($restaurantDeliverySettings) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.restaurant_delivery_settings.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/restaurant-delivery-settings', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $restaurantDeliverySettings->appends(['restaurant_id' => $res->id])->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
