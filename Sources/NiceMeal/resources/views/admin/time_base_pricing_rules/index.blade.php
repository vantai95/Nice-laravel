@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/time-base-pricing-rules', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.groups.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.groups.statuses.all')
                                                </option>
                                                <option value="{{ \App\Models\TimeBasePricingRule::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\TimeBasePricingRule::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    @lang('admin.restaurants.statuses.active')
                                                </option>
                                                <option value="{{ \App\Models\TimeBasePricingRule::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\TimeBasePricingRule::STATUS_FILTER['inactive'] ? 'selected' : '') }}>
                                                    @lang('admin.restaurants.statuses.inactive')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input" name="q"
                                               value="{{ Request::get('q') }}"
                                               placeholder="@lang('admin.time_base_pricing_rules.search.place_holder_text')"
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
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{ url('/admin/'.$res->res_Slug.'/time-base-pricing-rules/create?back_url='.$currentURL) }}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    @lang('admin.time_base_pricing_rules.createButton')
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
                    <tr class="table-dark">
                        {{--<th>--}}
                            {{--<label class="m-checkbox m-checkbox--solid m-checkbox--info">--}}
                                {{--<input id="select_all" type="checkbox">--}}
                                {{--<span></span>--}}
                            {{--</label>--}}
                        {{--</th>--}}
                        <th>@lang('admin.time_base_pricing_rules.columns.name')</th>
                        {{--<th>@lang('admin.time_base_pricing_rules.columns.inscrease')</th>--}}
                        <th>@lang('admin.time_base_pricing_rules.columns.value')</th>
                        <th>@lang('admin.time_base_pricing_rules.columns.active')</th>
                        <th>@lang('admin.time_base_pricing_rules.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($timeBasePricingRules as $item)
                        <tr>
                            {{--<td class="align-middle">--}}
                                {{--<label class="m-checkbox m-checkbox--solid m-checkbox--info">--}}
                                    {{--<input name="categories_list[]" type="checkbox" value="{{ $item->id }}">--}}
                                    {{--<span></span>--}}
                                {{--</label>--}}
                            {{--</td>--}}
                            <td class="align-middle">
                                {{ $item->rule_name }}
                                <br>
                                <small>
                                    (
                                    @if($item->period_type)
                                        @lang('admin.time_base_pricing_rules.detail.period'): @lang('admin.time_base_pricing_rules.detail.specific_period')
                                        <br>
                                        - @lang('admin.time_base_pricing_rules.detail.from_date')
                                        : {{ \App\Services\CommonService::formatSendDate($item->from_date) }}
                                        <br>
                                        - @lang('admin.time_base_pricing_rules.detail.to_date')
                                        : {{ \App\Services\CommonService::formatSendDate($item->to_date) }}
                                    @else
                                        @lang('admin.time_base_pricing_rules.detail.period'):
                                        @lang('admin.time_base_pricing_rules.detail.forever')
                                    @endif
                                    <br>
                                    @lang('admin.time_base_pricing_rules.detail.days_in_week'):
                                    @if($item->all_days)
                                        @lang('admin.time_base_pricing_rules.detail.all_days')
                                    @else
                                        @foreach(\App\Http\Controllers\Controller::WEEKNAME as $index => $dayName)
                                            @if ($item[$dayName] == 1)
                                                {{trans('admin.time_base_pricing_rules.detail.'.$dayName)}},
                                            @endif
                                        @endforeach
                                    @endif
                                    <br>
                                    @if($item->all_times)
                                        @lang('admin.time_base_pricing_rules.detail.display_time'):
                                        @lang('admin.time_base_pricing_rules.detail.all_times')
                                    @else
                                        @lang('admin.time_base_pricing_rules.detail.display_time'): @lang('admin.time_base_pricing_rules.detail.specific_time')
                                        <br>
                                        - @lang('admin.time_base_pricing_rules.detail.from_time')
                                        : {{ \App\Services\CommonService::formatShortFlightTime($item->from_time) }}
                                        <br>
                                        - @lang('admin.time_base_pricing_rules.detail.to_time')
                                        : {{ \App\Services\CommonService::formatShortFlightTime($item->to_time) }}
                                    @endif
                                    )
                                </small>
                            </td>
                            {{--<td class="align-middle">{{ $item->inscrease() }}</td>--}}
                            <td class="align-middle">{{ \App\Services\CommonService::formatPrice($item->value) }}</td>
                            <td class="align-middle">
                                {{-- <span class="m-badge {{ $item->status_class() }} m-badge--wide">{{ $item->status() }}</span> --}}
                                <span onclick="changeStatus({{$item->id}})" class="m-switch m-switch--outline m-switch--success">
                                    <label class="align-middle" style="margin:0px" >
                                        <input type="checkbox" {{( $item->active ==1 ) ? "checked" : ""}} id="active_{{$item->id}}" name="active[{{$item->id}}]">
                                        <span></span>
                                    </label>
                                </span>
                            </td>
                            <td class="text-nowrap align-middle">
                                <a href="{{ url('/admin/'.$res->res_Slug.'/time-base-pricing-rules/' . $item->rule_id . '/edit?back_url='.$currentURL) }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.time_base_pricing_rules.tooltip_title.edit')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'url' => ['/admin/'.$res->res_Slug.'/time-base-pricing-rules', $item->rule_id],
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.time_base_pricing_rules.tooltip_title.delete')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}

                                {!! Form::open([
                                  'method' => 'POST',
                                  'url' => ['/admin/'.$res->res_Slug.'/time-base-pricing-rules/duplicate/'. $item->rule_id],
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
                            </td>
                        </tr>
                    @endforeach
                    @if(count($timeBasePricingRules) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.time_base_pricing_rules.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                @if(count($timeBasePricingRules) != 0)
                    {{--{!! Form::open(['method' => 'POST', 'url' => '/admin/'.$res->res_Slug.'/time-base-pricing-rules/batch', 'class' => ''])  !!}--}}
                    {{--<div class="row ml-3">--}}
                        {{--<div class="col-xl-3 mt-2">--}}
                            {{--<label class="m-checkbox m-checkbox--solid m-checkbox--info">--}}
                                {{--<input name="all_elements" type="checkbox"> All elements ({{ \App\Models\TimeBasePricingRule::where('restaurant_id','=',$res->id)->count() }})--}}
                                {{--<span></span>--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="col-xl-2">--}}
                            {{--<select name="action" id="batchAction" class="form-control">--}}
                                {{--<option value="duplicate">Duplicate</option>--}}
                                {{--<option value="delete">Delete</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        {{--<div class="col-xl-1">--}}
                            {{--<input type="hidden" name="idx">--}}
                            {{--<input type="submit" class="btn btn-primary" value="OK" onclick="let action = $('#batchAction').val();setIDX();confirmDuplicateSubmitCustom(event, this, action);"/>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--{!! Form::close() !!}--}}
                    {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/time-base-pricing-rules', 'class' => '', 'role' => 'search'])  !!}
                    <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                        <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                            {!! $timeBasePricingRules->appends(['q' => Request::get('q')])->render() !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>
@endsection
@section('extra_scripts')
    <script>
        function setIDX() {
            let search_IDs = $('input[name="categories_list[]"]:checked').map(function(){
                return $(this).val();
            });
            $('input[name="idx"]').val(search_IDs.get());
        }
        function confirmDuplicateSubmitCustom(event, element, action = 'duplicate') {
            let m_duplicate = translator.trans('admin.confirm.duplicate.text');
            let m_delete = translator.trans('admin.confirm.delete.text');
            event.preventDefault();
            swal({
                text: (action === 'duplicate') ? m_duplicate : m_delete,
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: translator.trans('admin.confirm.delete.confirm_button'),
                cancelButtonText: translator.trans('admin.confirm.delete.cancel_button')
            }).then((result) => {
                if (result.value) {
                    $(element).parent().parent().parent('form').submit();
                }
            });
        }
        jQuery(document).ready(function () {
            function setCheckedAll(element = '',state = false) {
                const chk_arr = document.getElementsByName(element);
                const chk_length = chk_arr.length;
                for(let k = 0; k < chk_length; k++)
                {
                    chk_arr[k].checked = state;
                }
            }

            $('#select_all').change(function(){
                setCheckedAll('categories_list[]',this.checked);
            });
        });
    </script>
    <script>
        var requesting = [];
        function changeStatus(item_id){
            if(requesting[item_id] === undefined){
                requesting[item_id] = false;
            }
            if(!requesting[item_id])
            {
                requesting[item_id] = true;
                var active = $('#active_'+item_id).prop("checked") ? 0 : 1;
                $.ajax({
                    url: "{{url('admin/'.$res->res_Slug.'/time-base-pricing-rules/changeStatusTimeBasePrising')}}",
                    type: "post",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'item_id': item_id,
                        'active': active
                    },
                    success:function(response){
                        if(response.error){
                        toastr.error("@lang('admin.time_base_pricing_rules.time_base_pricing_rule_status.error')");
                        }else{
                            requesting[item_id] = false;
                            toastr.success(response.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection
