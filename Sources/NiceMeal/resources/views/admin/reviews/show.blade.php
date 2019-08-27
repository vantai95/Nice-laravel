@extends('admin.layouts.app')

@section('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endsection

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="card px-2">
                <div class="card-body">
                    <div class="container-fluid text-center">
                        <h3 >#{{ $review->id }}</h3>
                        <p> Created at : {{ $review->created_at }}</p>
                        <hr>
                    </div>
                    <div class="row justify-content-center status-bar mb-3">
                        @php
                            $is_new = $is_received = $is_waiting_confirm = $is_confirmed = $is_solved = $is_reported = false;
                            switch ($review->status) {
                                case 0:
                                    $is_new = true;
                                break;
                                case 1:
                                    $is_new = $is_received = $is_waiting_confirm = true;
                                break;
                                case 2:
                                    $is_new = $is_received = $is_confirmed = true;
                                break;
                                case 3:
                                    $is_new = $is_received = $is_solved = true;
                                break;
                                case 4:
                                    $is_new = $is_received = $is_reported = true;
                                break;
                                default:
                                break;
                            }
                        @endphp

                        <button
                                @if($is_new)
                                type="button"
                                class="btn btn-sm m-btn--pill m-btn--air @if($review->status === 0) btn-info @else btn-success @endif"
                                @else
                                type="button"
                                class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                @endif
                        >
                            New
                        </button>
                        <button
                                @if($is_received)
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                @else
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-metal"
                                @endif
                                style="border: 0px;"
                        >
                            <span class="fa fa-angle-double-right"></span>
                        </button>
                        <button
                                type="button"
                                @if($is_received)
                                class="btn btn-sm m-btn--pill m-btn--air @if($review->status === 1) btn-success @else btn-success @endif"
                                @else
                                class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                @endif
                        >
                            Received
                        </button>

                        @if($review->status == 1)
                        <button
                                @if($is_waiting_confirm)
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                @else
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-metal"
                                @endif
                                style="border: 0px;"
                        >
                            <span class="fa fa-angle-double-right"></span>
                        </button>
                        <button
                                type="button"
                                @if($is_waiting_confirm)
                                class="btn btn-sm m-btn--pill m-btn--air @if($review->status === 1) btn-primary @else btn-success @endif"
                                @else
                                class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                @endif
                        >
                            Waiting Confirm
                        </button>
                        @endif

                        @if($is_confirmed)
                        <button
                                @if($is_confirmed)
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                @else
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-metal"
                                @endif
                                style="border: 0px;"
                        >
                            <span class="fa fa-angle-double-right"></span>
                        </button>
                        <button
                                type="button"
                                @if($is_confirmed)
                                class="btn btn-sm m-btn--pill m-btn--air @if($review->status === 2) btn-success @else btn-success @endif"
                                @else
                                class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                @endif
                        >
                            Confirmed
                        </button>
                        @endif

                        @if($is_solved)
                        <button
                                @if($is_solved)
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                @else
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-metal"
                                @endif
                                style="border: 0px;"
                        >
                            <span class="fa fa-angle-double-right"></span>
                        </button>
                        <button
                                type="button"
                                @if($is_solved)
                                class="btn btn-sm m-btn--pill m-btn--air @if($review->status === 3) btn-success @else btn-success @endif"
                                @else
                                class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                @endif
                        >
                            Solved
                        </button>
                        @endif

                        @if($is_reported)
                        <button
                                @if($is_reported)
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-success"
                                @else
                                class="btn btn-sm m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-metal"
                                @endif
                                style="border: 0px;"
                        >
                            <span class="fa fa-angle-double-right"></span>
                        </button>
                        <button
                                type="button"
                                @if($is_reported)
                                class="btn btn-sm m-btn--pill m-btn--air @if($review->status === 1) btn-success @else btn-success @endif"
                                @else
                                class="btn btn-sm m-btn--pill m-btn--air btn-metal"
                                @endif
                        >
                            Reported
                        </button>
                        @endif

                    </div>

                    <hr />
                    <div class="row">
                        <div class="col-lg-2">
                            <h5>Food Rate:</h5>
                        </div>
                        <div class="col-lg-10">
                            <div id="food_rate"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <h5>Service Rate:</h5>
                        </div>
                        <div class="col-lg-10">
                            <div id="service_rate"></div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Comment</h5>
                            <p>{{ $review->comment }}</p>
                        </div>
                    </div>
                    <div class="container-fluid w-100">
                        @if($review->status == 1)
                        <div data-toggle="modal" data-target="#modalConfirm" class="btn btn-outline-primary m-btn m-btn--icon mt-4">
                            <span>
                                <i class="fa fa-check"></i>
                                <span>Confirm</span>
                            </span>
                        </div>
                        <div data-toggle="modal" data-target="#modalSolve" class="btn btn-outline-primary m-btn m-btn--icon mt-4">
                            <span>
                                <i class="fa fa-envelope"></i>
                                <span>Solve</span>
                            </span>
                        </div>
                        <div data-toggle="modal" data-target="#modalReport" class="btn btn-outline-primary m-btn m-btn--icon mt-4">
                            <span>
                                <i class="fa fa-comment"></i>
                                <span>Report</span>
                            </span>
                        </div>
                        @endif 
                        <a href="{{ url('/admin/'.$res->res_Slug.'/orders/'.$review->order_id.'/') }}">
                        <div class="btn btn-outline-primary m-btn m-btn--icon mt-4">                           
                                <span>
                                    <i class="fa fa-search"></i>
                                    <span>View Order Detail</span>
                                </span>
                            
                        </div></a>
                        <a href="{{ url('/admin/'.$res->res_Slug.'/reviews') }}" class="btn btn-default float-right mt-4">
                            Back to list
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.reviews.confirm_popup')
    @include('admin.reviews.solve_popup')
    @include('admin.reviews.report_popup')

@endsection

@section('extra_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        $(function () {
            $("#food_rate").rateYo({
                rating: {{ $review->food_rate }},
                ratedFill: 'red',
                starWidth: '19px',
                readOnly: true
            });
            $("#service_rate").rateYo({
                rating: {{ $review->service_rate }},
                ratedFill: 'red',
                starWidth: '19px',
                readOnly: true
            });
        });
    </script>
    @if($review->status == 1)
    <script>
        $(document).ready(function () {
             $('#btnShowModelConfirm').click(function () {
                 $('#confirmModal').modal('show');
             });

            function submitReview(status) {
                $.ajax({
                    url:"{{ url('admin/'.$res->res_Slug.'/reviews/changeStatus') }}",
                    type:"post",
                    dataType:"json",
                    data:{
                        status,
                        review_id: '{{ $review->id }}',
                        _token : "{{ csrf_token() }}"
                    },
                    success:function(response){
                        if(!response.error){
                            window.location.reload();
                        }
                    }

                });
            }

            $('#btnConfirm').click(function () {
                submitReview(2);
            });

            $('#btnReport').click(function () {
                submitReview(4);
            });

            {{--$('#Mailconfirm-form').submit(function(e){--}}
                {{--e.preventDefault();--}}
                {{--var data = $('#Mailconfirm-form').serializeArray()--}}

                {{--data.push({--}}
                    {{--name: 'review_id',--}}
                    {{--value: '{{ $review->id }}'--}}
                {{--});--}}
                {{--$.ajax({--}}
                    {{--url:"{{url('/admin/'.$res->res_Slug.'/reviews/solveSendMail')}}",--}}
                    {{--type: 'post',--}}
                    {{--data: data,--}}
                    {{--success:function(response){--}}
                        {{--if(response.error){--}}
                            {{--window.location.reload();--}}
                        {{--}else{--}}
                            {{--window.location.reload();--}}
                        {{--}--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}
        });
    </script>
    @endif

@endsection
