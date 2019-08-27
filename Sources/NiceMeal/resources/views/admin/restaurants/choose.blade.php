@extends('admin.layouts.app')

@section('content')

    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet">

            <form method="post" action="{{ url('admin/restaurants/doChooseRestaurant') }}">
                @csrf
                <select name="restaurant_id" class="select2 form-control" required>
                    <option disabled selected>--Chọn nhà hàng--</option>
                    @foreach($restaurant as $item)
                        
                        @if(Session('res') && $item->id == Session('res')->id)
                            <option selected value="{{$item->id}}">{{$item->name_en}}</option>
                        @else
                            <option value="{{$item->id}}">{{$item->name_en}}</option>
                        @endif
                        
                    @endforeach
                </select>
                <button class="btn btn-success" style="margin-top:10px;"> 
                    <i class="fa fa-check"></i> Chọn nhà hàng
                </button>
            </form>
            
        </div>
    </div>
@endsection
