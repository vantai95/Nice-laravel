@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => (isset($slug) ? '/admin/'.$slug : '/admin') . '/printers', 'class' => ''])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-9 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-3">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.printers.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.printers.statuses.all')
                                                </option>
                                                <option value="{{ \App\Models\Printer::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\Printer::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    @lang('admin.printers.statuses.active')
                                                </option>
                                                <option value="{{ \App\Models\Printer::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\Printer::STATUS_FILTER['inactive'] ? 'selected' : '') }}>
                                                    @lang('admin.printers.statuses.inactive')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                @if(!isset($slug))
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.printers.search.restaurant'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="res_id" id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ !isset($resId) ? 'selected' : '' }}>
                                                    @lang('admin.printers.statuses.all')
                                                </option>
                                                @foreach (App\Models\Restaurant::select('id', 'name_en')->get() as $res)
                                                    <option value="{{ $res->id }}" {{ (isset($resId) && $res->id == $resId) ? 'selected' : '' }}>
                                                        {{ $res->name_en }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input" name="q"
                                               value="{{ Request::get('q') }}"
                                               placeholder="@lang('admin.printers.search.place_holder_text')"
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

                        @if(Auth::user()->isAdmin())
                        <div class="col-xl-3 order-1 order-xl-2 m--align-right">
                            <a href="{{ url((isset($slug) ? '/admin/'.$slug : '/admin') . '/printers/create') }}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    @lang('admin.printers.breadcrumbs.new_printer')
                                </span>
                            </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                        @endif
                    </div>
                </div>
                {!! Form::close() !!}

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.printers.columns.name')</th>
                        @if(!isset($slug))
                        <th>@lang('admin.printers.columns.restaurant')</th>
                        @endif
                        <th>@lang('admin.printers.columns.status')</th>
                        @if(Auth::user()->isAdmin())
                        <th>@lang('admin.printers.columns.action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($printers as $key => $item)
                        <tr class="text-center">
                            <td class="align-middle">{{ $item->name }}</td>
                            @if(!isset($slug))
                            <td class="align-middle">{{ $item->restaurant()->first()["name_$lang"] }}</td>
                            @endif
                            <td class="align-middle">
                                <span class="m-badge {{ $item->status_class($item->printer_status) }} m-badge--wide">{{ $item->status($item->printer_status) }}</span>
                            </td>
                            @if(Auth::user()->isAdmin())
                            <td class="text-nowrap align-middle">
                                <a href="{{ url((isset($slug) ? '/admin/'.$slug : '/admin') .'/printers/' . $item->id . '/edit') }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.printers.breadcrumbs.edit_printer')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'url' => url((isset($slug) ? '/admin/'.$slug : '/admin') . '/printers/' . $item->id ),
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.printers.breadcrumbs.delete_printer')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}
                                {!! Form::open([
                                   'method' => 'POST',
                                   'url' => [(isset($slug) ? '/admin/'.$slug : '/admin') . '/printers/duplicate/'.$item->id],
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmDuplicateSubmit(event, this)"
                                   title="@lang('admin.tooltip_title.duplicate')">
                                    <i class="la la-copy"></i>
                                </a>
                                {!! Form::close() !!}
                                {!! Form::open([
                                   'method' => 'get',
                                   'url' => url((isset($slug) ? '/admin/'.$slug : '/admin') . '/printers/' . $item->id . '/export'),
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="$(this).closest('form').submit();"
                                   title="@lang('admin.printers.breadcrumbs.save_printer')">
                                    <i class="la la-save"></i>
                                </a>
                                {!! Form::close() !!}
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    @if(count($printers) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.printers.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => (isset($slug) ? '/admin/'.$slug : '/admin') . '/printers', 'class' => ''])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $printers->appends(['q' => Request::get('q'), 'status' => $status])->render() !!}
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