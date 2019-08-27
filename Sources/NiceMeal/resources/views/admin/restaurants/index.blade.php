@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/restaurants', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.restaurants.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.restaurants.statuses.all')
                                                </option>
                                                <option value="{{ \App\Models\Restaurant::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\Restaurant::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    @lang('admin.restaurants.statuses.active')
                                                </option>
                                                <option value="{{ \App\Models\Restaurant::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\Restaurant::STATUS_FILTER['inactive'] ? 'selected' : '') }}>
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
                                               class="form-control m-input"
                                               placeholder="@lang('admin.restaurants.search.place_holder_text')"
                                               id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        @if(Auth::user()->isAdmin() || Auth::user()->isManageAllRestaurant())
                            <div class="col-xl-2 order-1 order-xl-2 m--align-right">
                                <a href="{{ url('/admin/restaurants/import') }}"
                                   class="btn btn-default m-btn--sm m-btn m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-file-o"></i>
                                <span>
                                    @lang('admin.restaurants.breadcrumbs.import_restaurants')
                                </span>
                            </span>
                                </a>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div>
                            <div class="col-xl-2 order-1 order-xl-2 m--align-right">
                                <a href="{{ url('/admin/restaurants/create') }}"
                                   class="btn btn-primary m-btn--sm m-btn m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    @lang('admin.restaurants.breadcrumbs.new_restaurants')
                                </span>
                            </span>
                                </a>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div>
                        @endif
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive-md">
                    <thead>
                    <tr class="table-dark text-center">
                        <th>@lang('admin.restaurants.columns.res_id')</th>
                        <th>Logo</th>
                        <th>@lang('admin.restaurants.columns.name_en')</th>
                        <th>@lang('admin.restaurants.columns.status')</th>
                        <th>@lang('admin.restaurants.columns.action')</th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body">
                    @foreach($restaurants as $key => $item)
                        <tr class="text-center">
                            <td class="align-middle">{{ $item->id }}</td>
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
                                <td class="align-middle">
                                    <img src="{{ url('common-assets/img/restaurant_image.jpg') }}"
                                         class="img-circle img-fluid"
                                         alt="restaurant image default">
                                </td>
                            @endif
                            <td class="align-middle">
                                {!! Form::open([
                                       'method' => 'POST',
                                       'url' => ['/admin/restaurants/doChooseRestaurant', $item->id],
                                       'style' => 'display:inline'
                                    ]) !!}
                                <button type="submit" class="btn_res_name">
                                    {{ $item->name_en }}
                                </button>
                                {!! Form::close() !!}


                            </td>
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

                                @if(Auth::user()->isAdmin() ||Auth::user()->isManageAllRestaurant())
                                    {!! Form::open([
                                       'method' => 'DELETE',
                                       'url' => ['/admin/restaurants', $item->id],
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

                                    {!! Form::open([
                                        'method' => 'POST',
                                        'url' => ['/admin/restaurants/duplicate/'.$item->id],
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
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! Form::open(['method' => 'GET', 'url' => '/admin/restaurants', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        {!! $restaurants->appends(['q' => Request::get('q'), 'status' => $status])->render() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
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
                    url: "{{url('admin/restaurants/changeStatusRestaurant')}}",
                    type: "post",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'item_id': item_id,
                        'active': active
                    },
                    success: function (response) {
                        if (response.error) {
                            toastr.error("@lang('admin.restaurants.restaurant_status.error')");
                        } else {
                            requesting[item_id] = false;
                            toastr.success(response.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection
