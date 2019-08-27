@extends('admin.layouts.app')

@section('content')
    @include('admin.shared.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div class="m-content">
        <div class="row">
            <div class="m-portlet m-portlet--full-height col-xl-12 col-lg-12">
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    {!! Form::open(['method' => 'GET', 'url' => '/admin/'.$res->res_Slug.'/invoice-report', 'class' => '', 'role' => 'search'])  !!}
                    <div class="row align-items-center">
                        <div class="col-xl-5 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-12">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                Year:
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="select_year"
                                                    id="select_year" required>
                                                <option value="" selected="selected">
                                                    Select Year
                                                </option>
                                                @for($i = 0; $i < count($years); $i++)
                                                    <option value="{{$years[$i]}}" {{($selectYear == $years[$i]) ? 'selected' : ''}} >
                                                        {{$years[$i]}}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center" style="margin-top: 20px">
                        <div class="col-xl-5 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-12">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="text-nowrap">
                                                Month:
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <select class="form-control m-bootstrap-select" name="select_month"
                                                    id="select_month" required>
                                                <option value="" selected="selected">
                                                    Select Month
                                                </option>
                                                <option value="all_month" {{$selectMonth=='all_month' ? 'selected' : ''}}>
                                                    All month
                                                </option>
                                                @foreach(\App\Http\Controllers\Controller::MONTH_NAME as $key => $month)
                                                    <option value="{{$key}}" {{($selectMonth == $key) ? 'selected' : ''}} >
                                                        {{$month}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center" style="margin-top: 20px">
                        <div class="col-xl-2 order-2 order-xl-1">
                            <button type="submit" class="btn btn-success">OK</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <!--Report detail-->
            @if($totalSale > 0 && (!empty($selectMonth) && !empty($selectYear)))
                <div id="report-detail" class="m-portlet m-portlet--mobile col-xl-12 col-lg-12">
                    <p class="text-center sale-title">Invoice Report</p>
                    <div class="d-inline">
                        <p>Year:
                            <span class="float-right"
                                  id="ir_year">{{$selectYear ? $selectYear : 'Not selected yet!'}}</span>
                        </p>
                        <p>Month:
                            <span class="float-right" id="ir_month">
                                @if($selectMonth)
                                    @if($selectMonth == 'all_month')
                                        All month
                                    @else
                                        {{\App\Http\Controllers\Controller::MONTH_NAME[$selectMonth]}}
                                    @endif
                                @else
                                    Not selected yet!
                                @endif
                            </span>
                        </p>
                        <p>Invoice number:
                            <span class="float-right" id="ir_invoice_numb">#100</span>
                        </p>
                        <hr>
                    </div>
                    <div class="d-inline">
                        <p>Total sale:
                            <span class="float-right" id="ir_total_sale">{{App\Services\CommonService::formatPrice($totalSale)}}</span>
                        </p>
                        <p>Accepted
                            <span class="float-right" id="ir_accepted">{{$accepted > 0 ? App\Services\CommonService::formatPrice($accepted) : '0'}}</span>
                        </p>
                        <p>Rejected:
                            <span class="float-right" id="ir_rejected">{{$rejected > 0 ? App\Services\CommonService::formatPrice($rejected) : '0'}}</span>
                        </p>
                        <p>Commission rate:
                            <span class="float-right" id="ir_commission_rate">{{$commissionRate}}%</span>
                        </p>
                        <p>Commission total:
                            <span class="float-right" id="ir_commission_total">{{$commissionTotal > 0 ? App\Services\CommonService::formatPrice($commissionTotal) : '0'}}</span>
                        </p>
                        <hr>
                    </div>
                    <div class="d-inline">
                        <p>Tax:
                            <span class="float-right" id="ir_tax">10%</span>
                        </p>
                        <p>Final Commission:
                            <span class="float-right" id="ir_final_commission">{{$finalCommission > 0 ? \App\Services\CommonService::formatPrice($finalCommission) : '0' }}</span>
                        </p>
                        <hr>
                    </div>
                    <div class="d-inline">
                        <p>Online payment:
                            <span class="float-right" id="ir_online_payment">{{$onlinePayment > 0 ? \App\Services\CommonService::formatPrice($onlinePayment) : '0'}}</span>
                        </p>
                        <p>Paid commission
                            <span class="float-right" id="ir_paid_commission">{{$paidCommission > 0 ? \App\Services\CommonService::formatPrice($paidCommission) : '0' }}</span>
                        </p>
                        <p>Unpaid commission:
                            <span class="float-right" id="ir_unpaid_commission">{{$unPaidCommission > 0 ? App\Services\CommonService::formatPrice($unPaidCommission) : '0'}}</span>
                        </p>
                        <p>Shipping fee online:
                            <span class="float-right" id="ir_shipping_fee_online">{{$shippingFeeOnline > 0 ? App\Services\CommonService::formatPrice($shippingFeeOnline) : '0'}}</span>
                        </p>
                        <p>Money returned:
                            <span class="float-right" id="ir_money_return">{{$moneyReturn > 0 ? App\Services\CommonService::formatPrice($moneyReturn) : '0'}}</span>
                        </p>
                        <hr>
                    </div>
                    <p class="text-center sale-title">Payment History</p>
                    @if(!empty($paymentHistories))
                        @foreach($paymentHistories as $paymentHistory)
                            <div class="d-inline">
                                <p>Date from:
                                    <span class="float-right" id="ir_total_sale">Mon ({{\App\Services\CommonService::formatInvoiceDate($paymentHistory->date_from)}})</span>
                                </p>
                                <p>Date to:
                                    <span class="float-right" id="ir_accepted">Sun ({{\App\Services\CommonService::formatInvoiceDate($paymentHistory->date_to)}})</span>
                                </p>
                                <p>**************</p>
                                <p>Commission:
                                    <span class="float-right" id="ir_commission_rate">{{$paymentHistory->commission > 0 ? App\Services\CommonService::formatPrice($paymentHistory->commission) : '0'}}</span>
                                </p>
                                <p>Online payment:
                                    <span class="float-right" id="ir_commission_rate">{{$paymentHistory->online_payment > 0 ? App\Services\CommonService::formatPrice($paymentHistory->online_payment) : '0'}}</span>
                                </p>
                                <p>Pay for commission:
                                    <span class="float-right" id="ir_commission_rate">{{$paymentHistory->pay_for_commission > 0 ? App\Services\CommonService::formatPrice($paymentHistory->pay_for_commission) : '0'}}</span>
                                </p>
                                <p>Unpaid commission::
                                    <span class="float-right" id="ir_commission_rate">{{$paymentHistory->unpaid_commission > 0 ? App\Services\CommonService::formatPrice($paymentHistory->unpaid_commission) : '0'}}</span>
                                </p>
                                <p>Money returned:
                                    <span class="float-right" id="ir_commission_rate">{{$paymentHistory->money_returned > 0 ? App\Services\CommonService::formatPrice($paymentHistory->money_returned) : '0'}}</span>
                                </p>
                                <hr>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center sale-title">No payment history yet!</p>
                    @endif
                </div>
            @else
                <div class="m-portlet m-portlet--mobile col-xl-12 col-lg-12" id="no-data-and--wating">
                    <p class="text-center sale-title" id="no-data">No data available</p>
                </div>
            @endif

        <!--End report detail-->
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script type="text/javascript">

    </script>
@endsection