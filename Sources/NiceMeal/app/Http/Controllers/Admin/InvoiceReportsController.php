<?php

namespace App\Http\Controllers\Admin;

use App\Models\CommissionHistory;
use App\Models\CommissionRule;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use DB;

class InvoiceReportsController extends BelongToResController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = Session::get('locale');
        $res = Session::get('res');
        $resId = $res->id;
        $selectYear = $request->get('select_year');
        $selectMonth = $request->get('select_month');

        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.reports.invoice.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin'),
                    'text' => __('admin.reports.invoice.breadcrumbs.invoice_index')
                ]
            ]
        ];
        $years = Order::orderBy('created_at', 'asc')->select(DB::raw('DISTINCT YEAR(created_at) year'))->pluck('year')->toArray();

        $orderData = Order::where('restaurant_id', $resId)
            ->select('orders.*');

        if (!empty($selectYear)) {
            $orderData = $orderData->whereYear('created_at', $selectYear);
        }

        if (!empty($selectMonth)) {
            if ($selectMonth == 'all_month') {

            } else {
                $orderData = $orderData->whereMonth('created_at', $selectMonth);
            }
        }
        $monthAndYear = $selectYear . '-' . $selectMonth;

        $orderData = $orderData->get();

        $totalSale = 0;
        $accepted = 0;
        $onlinePayment = 0;
        $shippingFeeOnline = 0;

        foreach ($orderData as $subTotal) {
            $totalSale = $totalSale + round($subTotal->sub_total_amount);
        }
        foreach ($orderData->whereNotIn('status', [4, 8]) as $acceptedSub) {
            $accepted = $accepted + round($acceptedSub->sub_total_amount);
        }
        foreach ($orderData->where('payment_method', Order::PAYMENT_METHOD['ONLINE_PAYMENT'])->whereNotIn('status', [4, 8]) as $onlineSub) {
            $shippingFeeOnline = $shippingFeeOnline + round($onlineSub->shipping_fee);
        }
        $commissionRate = CommissionRule::where('restaurant_id', $resId)
            ->where('total_from', '<=', $accepted)
            ->where('total_to', '>', $accepted)->first();
        if (empty($commissionRate)) {
            $commissionRate = 0;
        } else {
            $commissionRate = $commissionRate->rate;
        }
        $rejected = $totalSale - $accepted;

        $commissionTotal = ($accepted * $commissionRate) / 100;
        $finalCommission = $commissionTotal + (($commissionTotal * 10) / 100);

        $paidCommission = $finalCommission;
        $unPaidCommission = 0;
        if(empty($selectYear) && empty($selectMonth)){
            $monthAndYear = '';
            if(!$monthAndYear){
                $paymentHistories = '';
            }
        }elseif($selectYear && $selectMonth == 'all_month'){
            $paymentHistories = CommissionHistory::where('restaurant_id',$resId)->get();
        } else{
            $paymentHistories = CommissionHistory::where('restaurant_id',$resId)
                ->where('date_to', '>=', (new Carbon($monthAndYear))->addMonth()->startOfMonth())
                ->where('date_to', '<=', (new Carbon($monthAndYear))->addMonth()->endOfMonth())
                ->get();
        }

        if(!empty($paymentHistories)){
            foreach($paymentHistories as $paymentHistory ){
                $onlinePayment  += $paymentHistory->online_payment;
            }
        }
        $moneyReturn = ($onlinePayment - $paidCommission) + $shippingFeeOnline;
//        dd($paymentHistories);
//        dd('Total Sale: '. number_format($totalSale, 0, ',', '.') . ', ' . 'Accepted: '.number_format($accepted, 0, ',', '.').', '. 'Rate: '.$commissionRate . ', ' . 'Commission Total: '. number_format($commissionTotal, 0, ',', '.') . ', ' . 'Final Commission: '. number_format($finalCommission, 0, ',', '.'). ', ' . 'Online Payment: '. number_format($onlinePayment, 0, ',', '.'). ', ' . 'Shipping Fee Online: '. number_format($shippingFeeOnline, 0, ',', '.'));

        return view('admin.invoice_report.index', compact('breadcrumbs', 'lang', 'years',
            'selectYear', 'selectMonth', 'res', 'totalSale', 'accepted', 'rejected', 'commissionRate', 'commissionTotal',
            'shippingFeeOnline', 'onlinePayment','unPaidCommission', 'paidCommission', 'finalCommission', 'moneyReturn','paymentHistories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
