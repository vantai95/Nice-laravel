@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">
            <!--begin::Form-->
            {!! Form::open(['method' => 'POST',
                    'url' => ['/admin/update-top'],
                    'class' => 'm-form m-form--fit m-form--label-align-right',
                    'id' => 'submitForm', 'files' => true]) !!}
            <div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">

                <div class="form-group m-form__group row m-content">
                    <div class="col-lg-12">
                        <div class="m-portlet">
                            <div class="col-lg-12">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon m--hide">
                                            <i class="la la-gear"></i>
                                            </span>
                                            <h5 class="m-portlet__head-text">
                                                Vip Restaurant
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(Auth::user()->isAdmin())
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 {{ $errors->has('restaurant_id') ? 'has-error' : ''}}">
                                        {!! Form::label('restaurant_id', trans('admin.dishes.forms.choose_restaurant'), ['class' => 'col-form-label col-sm-12']) !!}
                                        <div class="col-sm-12">
                                            {!! Form::select('restaurant_id[]',\App\Models\Restaurant::pluck('name_en','id'), null, ['class' => 'form-control restaurant-select2','multiple' => 'multiple']) !!}
                                       <!--     <select name="restaurant_id[]" id="" class="form-control restaurant-select2">
                                               <option></option>
                                           </select> -->
                                            {!! $errors->first('restaurant_id', '<p class="help-block field-error">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 {{ $errors->has('vip_res') ? 'has-error' : ''}}">
                                        {!! Form::label('vip_res', trans('admin.restaurants.forms.vip_restaurant'), ['class' => 'col-form-label col-sm-12']) !!}
                                        <div class="col-sm-12">
                                            {!! Form::select('vip_res', \App\Models\Restaurant::getRestaurantVipList(), null, ['class' => 'form-control vip-select2']) !!}
                                            {!! $errors->first('vip_res', '<p class="help-block field-error">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-2" style="padding-top: 34px;">
                                        <div class="col-xl-2 order-2 order-xl-1">
                                            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.save'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row m-content">
                    <div class="col-lg-12">
                        <div class="m-portlet">
                            <div class="col-lg-12">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h5 class="m-portlet__head-text">
                                                Restaurants
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(Auth::user()->isAdmin())
                                <table class="table table-striped table-bordered table-responsive-md">
                                    <thead>
                                    <tr class="table-dark text-center">
                                        <th>Sequence</th>
                                        <th>@lang('admin.restaurants.columns.name_en')</th>
                                        <th>@lang('admin.restaurants.columns.name_ja')</th>
                                        <th>@lang('admin.restaurants.columns.vip')</th>
                                    </tr>
                                    </thead>
                                    <tbody class="m-datatable__body" id="restaurant_sort">
                                    @foreach($restaurants as $key => $item)
                                        <tr id="{{$item->id}}" class="text-center drag-cursor"
                                            title="{{trans('admin.tooltip_title.change_sequence')}}">
                                            <td class="align-middle">{{ $item->vip_restaurant }}</td>
                                            <td class="align-middle">{{ $item->name_en }}</td>
                                            <td class="align-middle">{{ $item->name_ja }}</td>
                                            <td class="align-middle">
                                            <span onclick="changeStatus({{$item->id}})" class="m-switch m-switch--outline m-switch--success">
                                                <label class="align-middle" style="margin:0px" >
                                                <input type="checkbox" {{( !is_null($item->vip_restaurant)) ? "checked" : ""}} id="vip_restaurant_{{$item->id}}" name="vip_restaurant[{{$item->id}}]">
                                                <span></span>
                                                </label>
                                            </span>
                                             </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

           <!--  <div class="m-portlet__foot m-portlet__foot--fit">
               <div class="m-form__actions m-form__actions">
                   <div class="row">
                       <div class="offset-5">
                           {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.restaurants.buttons.update'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                           <a href="{{url('admin/restaurants')}}" class="btn btn-secondary">
                               @lang('admin.restaurants.buttons.cancel')
                           </a>
                       </div>
                   </div>
               </div>
           </div> -->
            <!--end::Form-->
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('extra_scripts')
     <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>   
        $(document).ready(function () {
            // $('.restaurant-select2').select2({
            

            // });  
            $('.vip-select2').select2();
           $('.restaurant-select2').val(null);
           // $('.restaurant-select2').html('');
           $('.restaurant-select2').select2();
        });
    </script>
    <script>
        var requesting = [];
        function changeStatus(item_id){
            if(requesting[item_id] === undefined){
                requesting[item_id] = false;
            }
            if(!requesting[item_id]){
                requesting[item_id] = true;
                var vip_restaurant = $('#vip_restaurant_'+item_id).prop("checked") ? null : 1;
                $.ajax({
                    url:"{{url('admin/'.$res->res_Slug.'/restaurants/changeStatusRestaurant')}}",
                    type:"post",
                    data:{
                        '_token':"{{ csrf_token() }}",
                        'item_id':item_id,
                        'vip_restaurant':vip_restaurant
                    },
                    success:function(response){

                        if(response.error){
                            toastr.error("@lang('admin.customizations.customization_status.error')");
                        }else{
                            requesting[item_id] = false;
                            toastr.success("Success");
                        }
                    }
                });
            }else{

            }

    }
    </script>
    <script>
        $(function () {
            $('#restaurant_sort').sortable({
                cursor: "move",
                stop: function (event, ui) {
                    var resIds = [];
                    $('tbody tr').each(function () {
                        resIds.push($(this).attr('id'));
                    });
                    $.ajax({
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{url('admin/'.$res->res_Slug.'/restaurants/update-sequence')}}",
                        type: 'POST',
                        dataType: 'json',
                        data: {resIds: resIds},
                        success: function (response) {
                            var vip_restaurant = 1;
                            $('tbody tr').each(function () {
                                var vip_restaurantE = $(this).find('td').first();
                                vip_restaurantE.text(vip_restaurant);
                                vip_restaurant = vip_restaurant + 1;
                            });
                            toastr.success('{{trans('admin.categories.flash_messages.change_sequence')}}');
                        },
                        error: function (error) {
                            console.log(error);
                            toastr.error('{{trans('admin.categories.flash_messages.change_sequence_error')}}');
                            $("#restaurant_sort").sortable("cancel");
                        }
                    })
                }
            });
        })
    </script>

@endsection
