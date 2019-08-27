<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\RestaurantWorkTime;
use App\Models\Order;
use App\Services\CommonService;
use App\Services\SaleReportService;
use App\Services\DateTimeService;

class SaleReportController extends BelongToResController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = Session::get('locale');
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.reports.sale.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin'),
                    'text' => __('admin.reports.sale.breadcrumbs.sale_index')
                ]
            ]
        ];
        return view('admin.sale_reports.index',compact('breadcrumbs','lang'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getReport(Request $request,$slug){

        $from_date = explode('-',$request->input("from_date"));
        $from_date = $from_date[2].'-'.$from_date[1].'-'.$from_date[0];
        $to_date = explode('-',$request->input("to_date"));
        $to_date = $to_date[2].'-'.$to_date[1].'-'.$to_date[0];
        $this->restaurant = Session::get('res');

        $report = SaleReportService::getReport($from_date,$to_date,$this->restaurant);
        
        return response()->json($report);
    }

    
}
