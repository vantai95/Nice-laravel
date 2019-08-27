@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/restaurant-work-times', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                {{--<div class="col-md-4">--}}
                                    {{--<div class="m-form__group m-form__group--inline">--}}
                                        {{--<div class="m-form__label">--}}
                                            {{--<label class="text-nowrap">--}}
                                                {{--@lang('admin.restaurant_work_times.search.status'):--}}
                                            {{--</label>--}}
                                        {{--</div>--}}
                                        {{--<div class="m-form__control">--}}
                                            {{--<select class="form-control m-bootstrap-select" name="status"--}}
                                                    {{--id="m_form_status" onchange="this.form.submit()">--}}
                                                {{--<option value="" {{ ($status == "" ? 'selected' : '') }} >--}}
                                                    {{--@lang('admin.restaurant_work_times.statuses.all')--}}
                                                {{--</option>--}}
                                                {{--<option value="{{ \App\Models\News::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\News::STATUS_FILTER['active'] ? 'selected' : '') }}>--}}
                                                    {{--@lang('admin.restaurants.statuses.active')--}}
                                                {{--</option>--}}
                                                {{--<option value="{{ \App\Models\News::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\News::STATUS_FILTER['inactive'] ? 'selected' : '') }}>--}}
                                                    {{--@lang('admin.restaurants.statuses.inactive')--}}
                                                {{--</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="d-md-none m--margin-bottom-10"></div>--}}
                                {{--</div>--}}

                               

                                <!-- <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input" name="q"
                                               value="{{ Request::get('q') }}"
                                               class="form-control m-input"
                                               placeholder="@lang('admin.restaurant_work_times.search.place_holder_text')"
                                               id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div> -->
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{ url('/admin/commission-rules/create') }}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    @lang('admin.commission_rules.createBtn')
                                </span>
                            </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.commission_rules.columns.level')</th>
                        <th>@lang('admin.commission_rules.columns.total_from')</th>
                        <th>@lang('admin.commission_rules.columns.total_to')</th>
                        <th>@lang('admin.commission_rules.columns.rate')</th>
                        <th>@lang('admin.commission_rules.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($commissionRules as $key => &$item)
                        <tr class="text-center">
                            <td>{{$item->level}}</td>
                            <td>{{ $item->total_from > 0 ? \App\Services\CommonService::formatPriceVND($item->total_from): '0 VNĐ'}}</td>
                            <td>{{\App\Services\CommonService::formatPriceVND($item->total_to)}}</td>
                            <td>{{$item->rate}}%</td>
                            <td class="text-nowrap">
                                <a href="{{ url('/admin/commission-rules/' . $item->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.restaurants.breadcrumbs.edit_event')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'url' => ['/admin/commission-rules', $item->id],
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.tooltip_title.delete')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    @if(count($commissionRules) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.commission_rules.not_found')</h6></i>
                            </td>
                        </tr>
                    </tbody>
                    @endif
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/commission-rules', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $commissionRules->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
