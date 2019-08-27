@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/dishes', 'class' => '', 'role' => 'search'])  !!}
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-9 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-5">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.dishes.search.category'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="category_id" id="category_id" onchange="this.form.submit()">
                                                    <option @if($category_id=='All') selected @endif >All</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}" @if($category->id == $category_id) selected @endif >
                                                        {{$category->title_en}}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                @lang('admin.dishes.search.status'):
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="status"
                                                    id="m_form_status" onchange="this.form.submit()">
                                                <option value="" {{ ($status == "" ? 'selected' : '') }} >
                                                    @lang('admin.dishes.statuses.all')
                                                </option>
                                                <option value="{{ \App\Models\Dish::STATUS_FILTER['active'] }}" {{ ($status == \App\Models\Dish::STATUS_FILTER['active'] ? 'selected' : '') }}>
                                                    @lang('admin.restaurants.statuses.active')
                                                </option>
                                                <option value="{{ \App\Models\Dish::STATUS_FILTER['inactive'] }}" {{ ($status == \App\Models\Dish::STATUS_FILTER['inactive'] ? 'selected' : '') }}>
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
                                               placeholder="@lang('admin.dishes.search.place_holder_text')"
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
                        <div class="col-xl-3 order-1 order-xl-2 m--align-right">
                            <a href="{{ url('/admin/'.$res->res_Slug.'/dishes/create?back_url='.$currentURL) }}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    @lang('admin.dishes.breadcrumbs.new_dish')
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
                        <th>@lang('admin.dishes.columns.sequence')</th>
                        <th>@lang('admin.dishes.columns.name_en')</th>
                        <th>@lang('admin.dishes.search.category')</th>
                        <th>@lang('admin.dishes.columns.status')</th>
                        <th>@lang('admin.dishes.columns.price')</th>
                        <th><i class="fa fa-cog"></i></th>
                    </tr>
                    </thead>
                    <tbody class="m-datatable__body" id="dishes_sort">
                        @foreach($dishes as $item)
                        <tr id="{{$item->dish_id}}" class="text-center drag-cursor" title="{{trans('admin.tooltip_title.change_sequence')}}">
                            <td class="align-middle">{{$item->dish_sequence}}</td>
                            <td class="align-middle">{{ $item->name_en }}</td>
                            <td class="align-middle">{{ $item->cat_name }}</td>
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
                               {{ number_format($item->price,'0','.',',') }}
                            </td>
                            <td class="text-nowrap align-middle">
                                <a href="{{ url('/admin/'.$res->res_Slug.'/dishes/' . $item->id . '/edit?back_url='.$currentURL) }}"
                                    class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                    title="@lang('admin.restaurants.breadcrumbs.edit_event')">
                                        <i class="la la-edit"></i>
                                </a>
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'url' => ['/admin/'.$res->res_Slug.'/dishes', $item->id],
                                    'style' => 'display:inline'
                                    ]) !!}
                                    <a href="javascript:void(0);"
                                    class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                    data-animation="false"
                                    onclick="confirmSubmit(event, this)"
                                    title="@lang('admin.restaurants.breadcrumbs.delete_event')">
                                        <i class="la la-remove"></i>
                                </a>
                                {!! Form::close() !!}

                                {!! Form::open([
                                   'method' => 'POST',
                                   'url' => ['/admin/'.$res->res_Slug.'/dishes/duplicate/'.$item->id],
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
                        @if(count($dishes) == 0)
                        <tr>
                            <td colspan="100%">
                                <i><h6>@lang('admin.dishes.not_found')</h6></i>
                            </td>
                        </tr>
                        @endif
                    </tbody>    
                </table>

                @if(!empty($dishes))
                    {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/dishes', 'class' => '', 'role' => 'search'])  !!}
                    <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                        <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                            {!! $dishes->appends(['q' => Request::get('q'), 'status' => $status,'category_id' =>$category_id ])->render() !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    var requesting = [];
    function changeStatus(item_id){
        if(requesting[item_id] === undefined){
                requesting[item_id] = false;
        }
        if(!requesting[item_id]){
            requesting[item_id] = true;
            var active = $('#active_'+item_id).prop("checked") ? 0 : 1;
            $.ajax({
                url:"{{url('admin/'.$res->res_Slug.'/dishes/changeStatusDish')}}",
                type:"post",
                data:{
                    '_token':"{{ csrf_token() }}",
                    'item_id':item_id,
                    'active':active
                },
                success:function(response){
                    if(response.error){
                        toastr.error("@lang('admin.dishes.dish_status.error')");
                    }else{
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
        $('#dishes_sort').sortable({
            cursor: "move",
            stop: function(event, ui){
                // var cateE = $(ui.item);
                // var cateId = cateE.attr('id');
                // var oldSequence = cateE.find('td').first().text();
                // var newSequence = $('tbody').find("#"+cateE.attr('id')).index()+1;

                var dishIds = [];
                $('tbody tr').each(function(){
                    dishIds.push($(this).attr('id'));
                });
                $.ajax({
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{url('admin/'.$res->res_Slug.'/dishes/update-sequence')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {dishIds: dishIds, cateId: $('#category_id').val()},
                    success: function (response) {
                        var sequence = 1;
                        $('tbody tr').each(function(){
                            var sequenceE = $(this).find('td').first();
                            sequenceE.text(sequence);
                            sequence = sequence+1;
                        });
                        toastr.success('{{trans('admin.categories.flash_messages.change_sequence')}}');
                    },
                    error: function (error) {
                        console.log(error);
                        toastr.error('{{trans('admin.categories.flash_messages.change_sequence_error')}}');
                        $( "#dishes_sort" ).sortable( "cancel" );
                    }
                })
            }
        });
    })
</script>
@endsection
