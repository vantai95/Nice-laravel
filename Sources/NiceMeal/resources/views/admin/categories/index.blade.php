@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/categories', 'class' => ''])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.categories.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.categories.statuses.all')
                                                </option>
                                                <option value="{{ \App\Models\Category::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\Category::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    @lang('admin.categories.statuses.active')
                                                </option>
                                                <option value="{{ \App\Models\Category::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\Category::STATUS_FILTER['inactive'] ? 'selected' : '') }}>
                                                    @lang('admin.categories.statuses.inactive')
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
                                               placeholder="@lang('admin.categories.search.place_holder_text')"
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
                            <a href="{{ url('/admin/'.$res->res_Slug.'/categories/create?back_url='.$currentURL) }}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    @lang('admin.categories.breadcrumbs.new_category')
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
                        {{--<th>--}}
                        {{--<label class="m-checkbox m-checkbox--solid m-checkbox--info">--}}
                        {{--<input id="select_all" type="checkbox">--}}
                        {{--<span></span>--}}
                        {{--</label>--}}
                        {{--</th>--}}
                        <th>@lang('admin.categories.columns.sequence')</th>
                        <th>@lang('admin.categories.columns.image')</th>
                        <th>@lang('admin.categories.columns.title_en')</th>
                        <th>@lang('admin.categories.columns.title_ja')</th>
                        <th>@lang('admin.categories.columns.status')</th>
                        <th>@lang('admin.categories.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body" id="categories_sort">
                    @foreach($categories as $key => $item)
                        <tr id="{{$item->id}}" class="text-center drag-cursor"
                            title="{{trans('admin.tooltip_title.change_sequence')}}">
                            {{--<td class="align-middle">--}}
                            {{--<label class="m-checkbox m-checkbox--solid m-checkbox--info">--}}
                            {{--<input name="categories_list[]" type="checkbox" value="{{ $item->id }}">--}}
                            {{--<span></span>--}}
                            {{--</label>--}}
                            {{--</td>--}}
                            <td class="align-middle">{{$item->sequence}}</td>
                            @if($item->image && $item->image != '[]')
                                    <td class="align-middle">
                                        @if(\Illuminate\Support\Str::contains($item->image , ['[', ']']))
                                            <img src="{{CommonService::buildImageURL(json_decode($item->image,true)[0])}}"
                                                 class="img-circle img-fluid" alt="">
                                        @else
                                            <img src="{{CommonService::buildImageURL($item->image)}}"
                                                 class="img-circle img-fluid" alt="">
                                        @endif
                                    </td>
                            @else
                                <td class="align-middle"><img src="{{ url('common-assets/img/category_default.png') }}"
                                                              class="img-circle img-fluid" alt="category default"></td>
                            @endif
                            <td class="align-middle">{{ $item->title_en }}</td>
                            <td class="align-middle">{{ $item->title_ja }}</td>
                            <td class="align-middle">
                                {{-- <span class="m-badge {{ $item->status_class() }} m-badge--wide">{{ $item->status() }}</span> --}}
                                <span onclick="changeStatus({{$item->id}})"
                                      class="m-switch m-switch--outline m-switch--success">
                                    <label class="align-middle" style="margin:0px">
                                        <input type="checkbox"
                                               {{( $item->active ==1 ) ? "checked" : ""}} id="active_{{$item->id}}"
                                               name="active[{{$item->id}}]">
                                        <span></span>
                                    </label>
                                </span>
                            </td>
                            <td class="text-nowrap align-middle">
                                <a href="{{ url('/admin/'.$res->res_Slug.'/categories/' . $item->id . '/edit?back_url='.$currentURL) }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   title="@lang('admin.categories.breadcrumbs.edit_category')">
                                    <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'url' => ['/admin/'.$res->res_Slug.'/categories', $item->id],
                                   'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this)"
                                   title="@lang('admin.categories.breadcrumbs.delete_category')">
                                    <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}


                                {!! Form::open([
                                   'method' => 'POST',
                                   'url' => ['/admin/'.$res->res_Slug.'/categories/duplicate/'.$item->id],
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
                    @if(count($categories) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.categories.not_found')</h6></i>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {{--{!! Form::open(['method' => 'POST', 'url' => '/admin/'.$res->res_Slug.'/categories/batch', 'class' => ''])  !!}--}}
                {{--<div class="row ml-3">--}}
                {{--<div class="col-xl-3 mt-2">--}}
                {{--<label class="m-checkbox m-checkbox--solid m-checkbox--info">--}}
                {{--<input name="all_elements" type="checkbox"> All elements ({{ \App\Models\Category::where('restaurant_id','=',$res->id)->count() }})--}}
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
                {{--{!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/categories', 'class' => ''])  !!}--}}
                {{--<div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">--}}
                {{--<div class="m-datatable__pager m-datatable--paging-loaded clearfix">--}}
                {{--{!! $categories->appends(['q' => Request::get('q'), 'status' => $status])->render() !!}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--{!! Form::close() !!}--}}
            </div>
        </div>
    </div>
@endsection
@section('extra_scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        function setIDX() {
            let search_IDs = $('input[name="categories_list[]"]:checked').map(function () {
                return $(this).val();
            });
            $('input[name="idx"]').val(search_IDs.get());
        }

        function confirmDuplicateSubmitCustom(event, element, action = 'duplicate') {
            let m_duplicate = translator.trans('admin.confirm.duplicate.text');
            let m_delete = translator.trans('admin.confirm.delete.text');
            event.preventDefault();
            swal({
                text: (action == 'duplicate') ? m_duplicate : m_delete,
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
            function setCheckedAll(element = '', state = false) {
                const chk_arr = document.getElementsByName(element);
                const chk_length = chk_arr.length;
                for (let k = 0; k < chk_length; k++) {
                    chk_arr[k].checked = state;
                }
            }

            $('#select_all').change(function () {
                setCheckedAll('categories_list[]', this.checked);
            });
        });
    </script>
    <script>
        var requesting = [];

        function changeStatus(item_id) {
            if (requesting[item_id] === undefined) {
                requesting[item_id] = false;
            }
            if (!requesting[item_id]) {
                requesting[item_id] = true;
                var active = $('#active_' + item_id).prop("checked") ? 0 : 1;
                $.ajax({
                    url: "{{url('admin/'.$res->res_Slug.'/categories/changeStatusCategory')}}",
                    type: "post",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'item_id': item_id,
                        'active': active
                    },
                    success: function (response) {
                        if (response.error) {
                            toastr.error("@lang('admin.categories.category_status.error')");
                        } else {
                            requesting[item_id] = false;
                            toastr.success(response.message);
                        }
                    }
                });
            }
        }
    </script>
    <script>
        $(function () {
            $('#categories_sort').sortable({
                cursor: "move",
                stop: function (event, ui) {
                    // var cateE = $(ui.item);
                    // var cateId = cateE.attr('id');
                    // var oldSequence = cateE.find('td').first().text();
                    // var newSequence = $('tbody').find("#"+cateE.attr('id')).index()+1;

                    var cateIds = [];
                    $('tbody tr').each(function () {
                        cateIds.push($(this).attr('id'));
                    });
                    $.ajax({
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        url: '{{url('admin/'.$res->res_Slug.'/categories/update-sequence')}}',
                        type: 'POST',
                        dataType: 'json',
                        data: {cateIds: cateIds},
                        success: function (response) {
                            var sequence = 1;
                            $('tbody tr').each(function () {
                                var sequenceE = $(this).find('td').first();
                                sequenceE.text(sequence);
                                sequence = sequence + 1;
                            });
                            toastr.success('{{trans('admin.categories.flash_messages.change_sequence')}}');
                        },
                        error: function (error) {
                            console.log(error);
                            toastr.error('{{trans('admin.categories.flash_messages.change_sequence_error')}}');
                            $("#categories_sort").sortable("cancel");
                        }
                    })
                }
            });
        })
    </script>
@endsection
