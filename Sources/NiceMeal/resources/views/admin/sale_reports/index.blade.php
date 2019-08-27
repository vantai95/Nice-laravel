@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="row">
            <div class="m-portlet m-portlet--full-height col-xl-12 col-lg-12">
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <form id="specific_day">
                        <div class="row align-items-center">
                            <div class="col-xl-5 order-2 order-xl-1">
                                <div class="form-group m-form__group row align-items-center">
                                    <div class="col-md-12">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__label">
                                                <label class="text-nowrap">
                                                    From Date
                                                </label>
                                            </div>
                                            <div class="m-form__control">
                                                <input type="text" class="form-control m-input" name="from_date"
                                                    placeholder="From Date"
                                                    id="m_datepicker_1" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 order-2 order-xl-1">
                                <div class="col-md-12">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                To Date
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <input type="text" class="form-control m-input" name="to_date"
                                                placeholder="To Date" autocomplete="off"
                                                id="m_datepicker_2">
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                            </div>
                            <div class="col-xl-2 order-2 order-xl-1">
                                <button type="submit" class="btn btn-success btn-sale-report-1" disabled>OK</button>
                            </div>
                        </div>
                    </form>
                    <form id="specific_week">
                        <div class="row align-items-center" style="margin-top: 20px">
                            <div class="col-xl-10 order-2 order-xl-1">
                                <div class="form-group m-form__group row align-items-center">
                                    <div class="col-md-12">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__label">
                                                <label class="text-nowrap">
                                                    Week
                                                </label>
                                            </div>
                                            <div class="m-form__control" style="padding-left: 32px;padding-right: 12px">
                                                <div class="m-input-icon m-input-icon--left">
                                                    <input type="text" class="form-control m-input" id="weeklyDatePicker" name="weeklyDatePicker"
                                                        placeholder="Mon(18-Feb-19)---Sun(24-Feb-19)" autocomplete="false">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                                <span>
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 order-2 order-xl-1">
                                <button type="submit" class="btn btn-success btn-sale-report-2" disabled>OK</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>

            <!--Report detail-->
            <div id="report-detail" class="m-portlet m-portlet--mobile col-xl-12 col-lg-12" style="display:none;">
                <p class="text-center sale-title">Sale Report</p>
                <div class="d-inline">
                    <p>Date From:
                        <span class="float-right" id="detail_date_from"></span>
                    </p>
                    <p>Date To:
                        <span class="float-right" id="detail_date_to"></span>
                    </p>
                    <hr>
                </div>
                    <div class="d-inline">
                        <p>Total sale:
                            <span class="float-right" id="total_sale">0</span>
                        </p>
                        <p>Order quantity:
                            <span class="float-right" id="order_quantity">0</span>
                        </p>
                        <p>Average value:
                            <span class="float-right" id="average_value">0</span>
                        </p>
                        <hr>
                    </div>
                
                <div class="d-inline">
                    <p>Working day total:
                        <span class="float-right" id="working_day_total">0</span>
                    </p>
                    <p>Order per day:
                        <span class="float-right" id="order_per_day">0</span>
                    </p>
                    <p>Working hour total:
                        <span class="float-right" id="working_hour_total">0</span>
                    </p>
                    <p>Order per hour:
                        <span class="float-right" id="order_per_hour">0</span>
                    </p>
                    <hr>
                </div>
                <div class="d-inline">
                    <p>Accepted quantity:
                        <span class="float-right" id="accepted_quantity">0</span>
                    </p>
                    <p>Accepted total:
                        <span class="float-right" id="accepted_total">0</span>
                    </p>
                    <p>Rejected quantity:
                        <span class="float-right" id="rejected_quantity">0</span>
                    </p>
                    <p>Rejected total:
                        <span class="float-right" id="rejected_total">0</span>
                    </p>
                    <hr>
                </div>
                <!-- <div class="d-inline">
                    <p>Shipping fee online:
                        <span class="float-right">500.000</span>
                    </p>
                </div> -->
            </div>
            <div class="m-portlet m-portlet--mobile col-xl-12 col-lg-12" id="no-data-and--wating">
                <p class="text-center sale-title" id="no-data">No data available</p>
                <p class="text-center" style="margin-top:10px;" id="spinner"><i style="font-size:2em;" class="fa fa-spinner fa-spin"></i></p>
            </div>
            <!--End report detail-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript">
        
        $('#m_datepicker_1').datepicker({
            language: '{{$lang}}',
            format: 'dd-mm-yyyy',
            autoclose:true,
        });
        $('#m_datepicker_2').datepicker({
            language: '{{$lang}}',
            format: 'dd-mm-yyyy',
            autoclose:true,
        });
        $("#weeklyDatePicker").datetimepicker({
            format: 'DD-MM-YYYY',
            icons: {
                previous: 'fa fa-arrow-left',
                next: 'fa fa-arrow-right',
            },
        });

        //Get the value of Start and End of Week
        $('#weeklyDatePicker').on('dp.change', function (e) {
            var value = $("#weeklyDatePicker").val();
            var firstDate = moment(value, 'DD-MM-YYYY').day(0).format("DD-MM-YYYY");
            var lastDate =  moment(value, 'DD-MM-YYYY').day(6).format("DD-MM-YYYY");
            $("#weeklyDatePicker").val(firstDate + " to " + lastDate);
        });

        $(function(){
            $('#spinner').hide();
        });

        $('#specific_week').submit(function(e){
            e.preventDefault();
            var data_input = $('#weeklyDatePicker').val();
            var data_input = data_input.split(" to ");
            var data = [];
            data.push({'name':'from_date','value':data_input[0]});
            data.push({'name':'to_date','value':data_input[1]});
            getData(data);
        })

        $('#specific_day').submit(function(e){
            e.preventDefault();
            var data = $(this).serializeArray();
            getData(data);
        });

        function getData(data){
            loading();
            $.ajax({
                url:"{{ url('admin/'.$res->res_Slug.'/get-report') }}",
                type:"get",
                data:data,
                success:function(response){
                    $('#detail_date_from').html(data[0].value);
                    $('#detail_date_to').html(data[1].value);
                    $.each(response,function(key,value){
                        $('#'+key).html(value);
                    });
                    endload();
                }
            });
        }

        function loading(){
            $('#no-data-and--wating').show();
            $('#no-data').hide();
            $('#report-detail').hide();
            $('#spinner').show();
        }

        function endload(){
            $('#no-data-and--wating').hide();
            $('#report-detail').show();
            $('#spinner').hide();
        }

        //check form specific_day
        $("#m_datepicker_1").change(function(){
            checkFormSpecificDay();
        });

        $("#m_datepicker_2").change(function(){
            checkFormSpecificDay();
        });

        function checkFormSpecificDay() {
            var fromDate = new Date($("#m_datepicker_1").val().split("-")[2], $("#m_datepicker_1").val().split("-")[1]-1, $("#m_datepicker_1").val().split("-")[0]);
            var toDate = new Date($("#m_datepicker_2").val().split("-")[2], $("#m_datepicker_2").val().split("-")[1]-1, $("#m_datepicker_2").val().split("-")[0]);
            var earlyDate = $("#m_datepicker_1").val();
            var finalDate = $("#m_datepicker_2").val();
            var btnReportSpecificDay = $('#specific_day > div > div.col-xl-2.order-2.order-xl-1 > button');

            if(fromDate <= toDate){
                checkDatePattern(earlyDate, finalDate, btnReportSpecificDay);
            }else {
                $(btnReportSpecificDay).prop('disabled', true);
            }
        }

        //check form specific_week
        $('#weeklyDatePicker').on("focus", function(){
            checkFormsSpecificWeek();
        });

        $('#weeklyDatePicker').on('blur', function() {
            checkFormsSpecificWeek();
        });

        function checkFormsSpecificWeek() {
            var fromDate = $("#weeklyDatePicker").val().split(' ')[0];
            var toDate = $("#weeklyDatePicker").val().split(' ')[2];
            var btnReportSpecificWeek = $('#specific_week > div > div.col-xl-2.order-2.order-xl-1 > button');

            if(($('#weeklyDatePicker').val()).indexOf('to') != -1){
                checkDatePattern(fromDate, toDate, btnReportSpecificWeek);
            }else {
                $(btnReportSpecificWeek).prop('disabled', true);
            }
        }

        //check Date Pattern
        function checkDatePattern(fromDate, toDate, btnReportSpecific) {
            var rxDatePattern = /((0[1-9]|[12]\d|3[01])-(0[1-9]|1[0-2])-[12]\d{3})/;

            if(rxDatePattern.test(fromDate) && rxDatePattern.test(toDate)) {
                $(btnReportSpecific).prop('disabled', false);
            } else {
                $(btnReportSpecific).prop('disabled', true);
            }
        }
    </script>
@endsection