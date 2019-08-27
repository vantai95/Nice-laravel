@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => \Session::has('res') ? '/admin/'.$res->res_Slug.'/orders' : 'admin/orders', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-lg-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.orders.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.orders.statuses.all')
                                                </option>
                                                @foreach($statuses as $key => $value)
                                                <option value="{{ $value }}" {{ (($status != '' && $status == $value) ? 'selected' : '') }}>
                                                    @lang('admin.orders.statuses.'.$key)
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input" name="q"
                                               value="{{ Request::get('q') }}"
                                               placeholder="@lang('admin.orders.search.place_holder_text')"
                                               id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="">
                                        <input type="text" class="form-control m-input" name="date_from_to" id="date_from_to" >
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        {{--<div class="col-xl-4 order-1 order-xl-2 m--align-right">--}}
                            {{--<a href="{{ url('/admin/'.$res->res_Slug.'/orders/create') }}"--}}
                               {{--class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">--}}
                            {{--<span>--}}
                                {{--<i class="la la-plus-circle"></i>--}}
                                {{--<span>--}}
                                    {{--@lang('admin.orders.breadcrumbs.new_order')--}}
                                {{--</span>--}}
                            {{--</span>--}}
                            {{--</a>--}}
                            {{--<div class="m-separator m-separator--dashed d-xl-none"></div>--}}
                        {{--</div>--}}
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.orders.columns.order_number')</th>
                        <th>@lang('admin.orders.columns.full_name')</th>
                        <th>@lang('admin.orders.columns.phone')</th>
                        <th>@lang('admin.orders.columns.total_amount')</th>
                        <th>@lang('admin.orders.columns.payment_method')</th>
                        <th>@lang('admin.orders.columns.status')</th>
                        <th>@lang('admin.orders.columns.otp_verified')</th>
                        {{-- <th>@lang('admin.orders.columns.action')</th> --}}
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($orders as $key => $item)
                        <tr class="text-center">
                            <td>
                                <a href="{{ \Session::has('res') ? url('/admin/'.$res->res_Slug.'/orders/' . $item->id) : url('/admin/orders/' . $item->id)}}">{{ $item->order_number }}</a>
                            </td>
                            <td>
                                {{ App\Models\OrderCustomerInfo::where('order_id','=',$item->id)->firstOrFail()->full_name }}
                            </td>
                            <td>
                                {{ App\Models\OrderCustomerInfo::where('order_id','=',$item->id)->firstOrFail()->phone }}
                            </td>
                            <td>{{ $item->totalAmountVND() }}</td>
                            <td>
                                <span class="m-badge {{ $item->paymentMethodClass() }} m-badge--wide">{{ $item->payment_method }}</span>
                            </td>
                            <td>
                                <span class="m-badge {{ $item->status_class() }} m-badge--wide">{{ $item->status() }}</span>
                            </td>
                            <td>
                                <span class="m-badge @if(is_null($item->otp_verified)) m-badge--danger @else m-badge--success @endif m-badge--wide">@if(is_null($item->otp_verified)) Not Verified @else Verified @endif</span>
                            </td>
                            {{-- <td class="text-nowrap">
                                <a href="{{ url('/admin/'.$res->res_Slug.'/orders/' . $item->id ) }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.orders.breadcrumbs.edit_order')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'url' => ['/admin/'.$res->res_Slug.'/orders', $item->id],
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.orders.breadcrumbs.delete_order')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}
                            </td> --}}
                        </tr>
                    @endforeach
                    @if(count($orders) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.orders.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET','url' => \Session::has('res') ? '/admin/'.$res->res_Slug.'/orders' : '/admin/orders', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $orders->appends(['q' => Request::get('q'), 'status' => $status])->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        $('#date_from_to').daterangepicker({
            language: '{{$lang}}',
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: '{{ $from }}',
            endDate: '{{ $to }}',
            autoclose: true,
            clearBtn: true,
            opens: "center"
        });
        $(document).ready(function () {
            $('#date_from_to').change(function () {
                this.form.submit();
            });
            $('#generalSearch').keyup(function (event) {
                if(event.keyCode === 13) {
                    this.form.submit();
                }
            });
        })
    </script>
@endsection
