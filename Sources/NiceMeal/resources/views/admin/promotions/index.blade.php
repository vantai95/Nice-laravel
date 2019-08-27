@extends('admin.layouts.app') 
@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            {!! Form::open(['method' => 'GET', 'url' => isset($slug) ? "/admin/$slug/promotions" : '/admin/vouchers', 'class' => ''])
            !!}
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-9 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-3">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label class="text-nowrap">
                                            {{ trans_choice('admin.promotions.search.status', isset($slug) ?? 0) }}:
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" name="status" id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    {{ trans_choice('admin.promotions.statuses.all', isset($slug) ?? 0) }}
                                                </option>
                                                <option value="{{ \App\Models\promotion::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\promotion::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    {{ trans_choice('admin.promotions.statuses.active', isset($slug) ?? 0) }}
                                                </option>
                                                <option value="{{ \App\Models\promotion::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\promotion::STATUS_FILTER['inactive'] ? 'selected' : '') }}>
                                                    {{ trans_choice('admin.promotions.statuses.inactive', isset($slug) ?? 0) }}
                                                </option>
                                            </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input" name="q" value="{{ Request::get('q') }}" placeholder="{{ trans_choice('admin.promotions.search.place_holder_text', isset($slug) ?? 0) }}"
                                        id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 order-1 order-xl-2 m--align-right">
                        <a href="{{ url( (isset($slug) ? "/admin/$slug/promotions" : '/admin/vouchers') . '/create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    {{ trans_choice('admin.promotions.breadcrumbs.new_promotion', isset($slug) ?? 0) }}
                                </span>
                            </span>
                            </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

            <table class="table table-striped table-bordered table-responsive-md">
                <thead>
                    <tr class="table-dark text-center">
                        <th>{{ trans('admin.promotions.columns.name_en') }}</th>
                        <th>{{ trans('admin.promotions.columns.name_ja') }}</th>
                        @if(!isset($slug))
                        <th>{{ trans('admin.promotions.columns.code') }}</th>
                        @endif
                        <th>{{ trans('admin.promotions.columns.status') }}</th>
                        <th>{{ trans('admin.promotions.columns.action') }}</th>
                    </tr>
                </thead>
                <tbody class="m-datatable__body">
                    @foreach($promotions as $key => $item)
                    <tr class="text-center">
                        <td class="align-middle">{{ $item->name_en }}</td>
                        <td class="align-middle">{{ $item->name_ja }}</td>
                        @if(!isset($slug))
                        <td class="align-middle">{{ $item->promotion_code }}</td>
                        @endif
                        <td class="align-middle">
                            <span class="m-badge {{ $item->status_class($item->promotion_status) }} m-badge--wide">{{ $item->status($item->promotion_status) }}</span>
                        </td>
                        <td class="text-nowrap align-middle">
                            <a href="{{ url( (isset($slug) ? "/admin/$slug/promotions/" : '/admin/vouchers/') . $item->id . '/edit') }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                title="{{ trans_choice('admin.promotions.breadcrumbs.edit_promotion', isset($slug) ?? 0) }}">
                                <i class="la la-edit"></i>
                            </a>
                            {!! Form::open([ 'method' => 'DELETE', 'url' => url( (isset($slug) ? "/admin/$slug/promotions/" : '/admin/vouchers/') . $item->id), 'style' => 'display:inline' ])
                            !!}
                            <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                data-animation="false" onclick="confirmSubmit(event, this)" title="{{ trans_choice('admin.promotions.breadcrumbs.delete_promotion', isset($slug) ?? 0) }}">
                                    <i class="la la-remove"></i>
                            </a> 
                            {!! Form::close() !!}
                            {{-- {!! Form::open([ 'method' => 'POST',
                                'url' => [(isset($slug) ? '/admin/'.$slug.'/promotions' : '/admin/vouchers') . '/duplicate/'.$item->id],
                                'style' => 'display:inline' ]) 
                            !!}
                            <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                data-animation="false" onclick="$(this).closest('form').submit();" title="{{ trans_choice('admin.promotions.breadcrumbs.dupplicate_promotion', isset($slug) ? 1 : 0) }}">
                                <i class="la la-copy"></i>
                            </a>
                            {!! Form::close() !!} --}}
                        </td>
                    </tr>
                    @endforeach @if(count($promotions) == 0)
                    <tr>
                        <td colspan="100%">
                            <i><h6>{{ trans_choice('admin.promotions.not_found', isset($slug) ?? 0) }}</h6></i>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {!! Form::open(['method' => 'GET', 'url' => ( (isset($slug) ? "/admin/$slug/promotions" : '/admin/vouchers') ) , 'class' => ''])
            !!}
            <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                    {!! $promotions->appends(['q' => Request::get('q'), 'status' => $status])->render() !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
 
@section('extra_scripts')
<script>

</script>
@endsection