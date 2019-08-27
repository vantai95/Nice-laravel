<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrderRejectReason;
use Illuminate\Http\Request;
use Log, Auth, Session;
use App\Services\CommonService;

class OrderRejectReasonController extends BelongToResController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.order_reject_reason.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/order-reject-reason'),
                    'text' => __('admin.order_reject_reason.breadcrumbs.order_reject_reason_index')
                ]
            ]
        ];
        session(['mainPage' => $request->fullUrl()]);

        // get search params
        $keyword = $request->get('q');
        
        $lang = Session::get('locale');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $orderRejectReasons = OrderRejectReason::select('order_reject_reasons.*' )->orderBy('order_reject_reasons.id', 'desc');

        

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $orderRejectReasons = $orderRejectReasons->where(function ($query) use ($keyword) {
                $query->orWhere('order_reject_reasons.name_en', 'LIKE', $keyword);
            });
        }
       
        $orderRejectReasons = $orderRejectReasons->paginate($perPage);
        return view ('admin.order_reject_reason.index',compact('orderRejectReasons', 'breadcrumbs', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.order_reject_reason.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/order-reject-reason'),
                    'text' => __('admin.order_reject_reason.breadcrumbs.order_reject_reason_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.order_reject_reason.breadcrumbs.add_order_reject_reason')
                ]
            ]
        ];

        return view('admin.order_reject_reason.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name_en' => "required|unique:order_reject_reasons,name_en"
        ]);

        $requestData = $request->all();
        unset($requestData['_token']);

        OrderRejectReason::insert($requestData);

        Session::flash('flash_message', trans('admin.order_reject_reason.flash_messages.new'));
        return redirect('admin/order-reject-reason');
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
        $breadcrumbs = [
            'title' => __('admin.order_reject_reason.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/order-reject-reason'),
                    'text' => __('admin.order_reject_reason.breadcrumbs.order_reject_reason_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.order_reject_reason.breadcrumbs.edit_order_reject_reason')
                ]
            ]
        ];

        $tag = OrderRejectReason::findOrFail($id);

        return view('admin.order_reject_reason.edit',compact('tag', 'breadcrumbs'));
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
        $this->validate($request,[
            'name_en' => "required|unique:order_reject_reasons,name_en,$id"
        ]);

        $tag = OrderRejectReason::findOrFail($id);

        $requestData = $request->all();

        $tag->update($requestData);

        Session::flash('flash_message', trans('admin.order_reject_reason.flash_messages.update'));
        return redirect('admin/order-reject-reason');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = OrderRejectReason::findOrFail($id);

        $tag->delete();

        Session::flash('flash_message', trans('admin.order_reject_reason.flash_messages.destroy'));
        return redirect('admin/order-reject-reason');
    }

    public function duplicateOrderRejectReason($id){
        $tag = OrderRejectReason::findOrFail($id);

        $newTag = $tag->replicate();
        $newTag->name_en = $newTag->name_en . " Copy " . rand(1000, 9999);

        $newTag->save();

        Session::flash('flash_message', trans('admin.order_reject_reason.flash_messages.duplicate'));
        return redirect('admin/order-reject-reason');
    }

}
