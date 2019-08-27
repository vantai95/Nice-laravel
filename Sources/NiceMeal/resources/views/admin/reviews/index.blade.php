@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/reviews', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-lg-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.reviews.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.reviews.statuses.all')
                                                </option>
                                                @foreach($statuses as $key => $value)
                                                    <option value="{{ $value }}" {{ (($status != '' && $status == $value) ? 'selected' : '') }}>
                                                        @lang('admin.reviews.statuses.'.$key)
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
                                               class="form-control m-input"
                                               placeholder="@lang('admin.reviews.search.place_holder_text')"
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
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.reviews.columns.id')</th>
                        <th>@lang('admin.reviews.columns.order_number')</th>
                        <th>@lang('admin.reviews.columns.full_name')</th>
                        <th>@lang('admin.reviews.columns.comment')</th>
                        <th>@lang('admin.reviews.columns.status')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($reviews as $key => $item)
                        <tr class="text-center">
                            <td>
                                <a href="{{ url('/admin/'.$res->res_Slug.'/reviews/' . $item->id) }}">{{ $item->id }}</a>
                            </td>
                            <td>
                                {{ App\Models\Order::where('id','=',$item->order_id)->firstOrFail()->order_number }}
                            </td>
                            <td>
                                {{ App\Models\OrderCustomerInfo::where('order_id','=',$item->order_id)->firstOrFail()->full_name }}
                            </td>
                            <td>
                                <a href="{{ url('/admin/'.$res->res_Slug.'/reviews/' . $item->id) }}">{{ $item->comment }}</a>
                            </td>
                            <td>
                                <span class="m-badge {{ $item->status_class() }} m-badge--wide">{{ $item->status() }}</span>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($reviews) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.reviews.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/reviews', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $reviews->appends(['q' => Request::get('q'), 'status' => $status])->render() !!}
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
            opens: 'center'
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
