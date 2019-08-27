<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Log;
use App\Models\TimeBasePricingRule;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;

class TimeBasePricingRulesController extends Controller
{
    CONST default_index = 'time_base_pricing_rule';
    CONST required_method = [
        'edit',
        'update',
        'destroy',
        'duplicateTBP'
    ];
    CONST model = TimeBasePricingRule::class;
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $slug)
    {
        $lang = Session::get('locale');
        if($request->get('per_page') > 0){
            Session::put('perPage',$request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.time_base_pricing_rules.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/time-base-pricing-rules'),
                    'text' => __('admin.time_base_pricing_rules.breadcrumbs.time_base_pricing_rules_index')
                ]
            ]
        ];
//        session(['mainPage' => $request->fullUrl()]);

        // get search params
        $keyword = $request->get('q');
        $status = $request->get('status');

        $timeBasePricingRules = TimeBasePricingRule::join('restaurants', 'restaurants.id', '=', 'time_base_pricing_rules.restaurant_id')
            ->select("restaurants.name_en as restaurant_name",
                'time_base_pricing_rules.*',
                'time_base_pricing_rules.name as rule_name',
                'time_base_pricing_rules.id as rule_id')
            ->orderBy('time_base_pricing_rules.created_at', 'des');

        if (!empty($status)) {
            if ($status == TimeBasePricingRule::STATUS_FILTER['inactive']) {
                $timeBasePricingRules = $timeBasePricingRules->where('time_base_pricing_rules.active', '=', false);
            } elseif ($status == TimeBasePricingRule::STATUS_FILTER['active']) {
                $timeBasePricingRules = $timeBasePricingRules->where('time_base_pricing_rules.active', '=', true);
            }
        }
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $timeBasePricingRules = $timeBasePricingRules->where(function ($query) use ($keyword) {
                $query->orWhere("time_base_pricing_rules.name", 'LIKE', $keyword);
            });
        }
        $restaurantId = Session::get('res')->id;
        // if (Auth::user()->isRestaurant()) {
        //     $restaurantId = Auth::user()->restaurantId();
        //     $TimeBasePricingRules = $TimeBasePricingRules->where(function ($query) use ($restaurantId) {
        //         $query->orWhere("time_base_pricing_rules.restaurant_id", '=', $restaurantId);
        //     });
        // }
        $timeBasePricingRules = $timeBasePricingRules->where(function ($query) use ($restaurantId) {
            $query->orWhere("time_base_pricing_rules.restaurant_id", '=', $restaurantId);
        });

        if(!empty($timeBasePricingRules)){
            $timeBasePricingRules = $timeBasePricingRules->paginate($perPage);
        }
        $currentURL = urlencode($request->fullUrl());

        return view('admin.time_base_pricing_rules.index', compact('timeBasePricingRules', 'breadcrumbs', 'lang', 'status', 'currentURL'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($slug)
    {
        $lang = Session::get('locale');
        $this->restaurant = Session::get('res');

        $breadcrumbs = [
            'title' => __('admin.time_base_pricing_rules.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'.$slug.'/time-base-pricing-rules'),
                    'text' => __('admin.time_base_pricing_rules.breadcrumbs.time_base_pricing_rules_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.time_base_pricing_rules.breadcrumbs.time_base_pricing_rules_create')
                ]
            ]
        ];

        $backUrl = url('admin/'.$this->restaurant->res_Slug.'/time-base-pricing-rules');
        if(request()->has('back_url')) {
            $backUrl = request()->query('back_url');
        }

        return view('admin.time_base_pricing_rules.create', compact('breadcrumbs', 'lang', 'backUrl'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, $slug)
    {
        $this->restaurant = Session::get('res');
        $resId = $this->restaurant->id;

        $fromDate = Carbon::parse($request->get('from_date'))->toDateString();
        $fromTime = $request->get('from_time');

        $requestData = $request->all();
        $requestData['type'] = 1;

        $validateList = [
            'name' => "required|unique:time_base_pricing_rules,name,null,null,restaurant_id,$resId",
            'value' => 'required',
        ];

        if (!$requestData['all_times']) {
            $validateList['from_time'] = 'required';
            $validateList['to_time'] = 'required|after:' . $fromTime;
        } else {
            $requestData['from_time'] = null;
            $requestData['to_time'] = null;
        }

        if ($requestData['period_type']) {
            $validateList['from_date'] = 'required';
            $validateList['to_date'] = 'required|after_or_equal:' . $fromDate;
        } else {
            $requestData['from_date'] = null;
            $requestData['to_date'] = null;
        }


        // validate message
        $messageList = [
            'to_date.after' => trans('admin.time_base_pricing_rules.validation_message.to_date'),
            'to_time.after' => trans('admin.time_base_pricing_rules.validation_message.to_time'),
        ];

        $requestData['restaurant_id'] = $this->restaurant->id;

        $this->validate($request, $validateList, $messageList);

        if ($requestData['all_days']) {
            $requestData['mon'] = true;
            $requestData['tue'] = true;
            $requestData['wed'] = true;
            $requestData['thu'] = true;
            $requestData['fri'] = true;
            $requestData['sat'] = true;
            $requestData['sun'] = true;
        } else {
            $requestData['mon'] = $request->mon ? true : false;
            $requestData['tue'] = $request->tue ? true : false;
            $requestData['wed'] = $request->wed ? true : false;
            $requestData['thu'] = $request->thu ? true : false;
            $requestData['fri'] = $request->fri ? true : false;
            $requestData['sat'] = $request->sat ? true : false;
            $requestData['sun'] = $request->sun ? true : false;
        }

        $requestData['active'] = $request->active ? true : false;

        TimeBasePricingRule::create($requestData);

        Session::flash('flash_message', trans('admin.time_base_pricing_rules.flash_message.new'));
        return redirect('admin/' . $slug . '/time-base-pricing-rules');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($slug, $id)
    {
        $lang = Session::get('locale');
        $this->restaurant = Session::get('res');

        $breadcrumbs = [
            'title' => __('admin.time_base_pricing_rules.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'.$slug.'/time-base-display-rules'),
                    'text' => __('admin.time_base_pricing_rules.breadcrumbs.time_base_pricing_rules_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.time_base_pricing_rules.breadcrumbs.time_base_pricing_rules_update')
                ]
            ]
        ];

        $timeBasePricingRule = TimeBasePricingRule::findOrFail($id);
        $backUrl = url('admin/'.$this->restaurant->res_Slug.'/time-base-pricing-rules');
        if(request()->has('back_url')) {
            $backUrl = request()->query('back_url');
        }

        return view('admin.time_base_pricing_rules.edit', compact('timeBasePricingRule', 'breadcrumbs', 'lang', 'backUrl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($slug, $id, Request $request)
    {
        $this->restaurant = Session::get('res');
        $resId = $this->restaurant->id;

        $fromDate = Carbon::parse($request->get('from_date'))->toDateString();
        $fromTime = $request->get('from_time');

        $requestData = $request->all();

        $validateList = [
            'name' => "required|unique:time_base_pricing_rules,name,$id,id,restaurant_id,$resId",
            'value' => 'required',
        ];
        if (!$requestData['all_times']) {
            $validateList['from_time'] = 'required';
            $validateList['to_time'] = 'required|after:' . $fromTime;
        } else {
            $requestData['from_time'] = null;
            $requestData['to_time'] = null;
        }

        if ($requestData['period_type']) {
            $validateList['from_date'] = 'required';
            $validateList['to_date'] = 'required|after_or_equal:' . $fromDate;
        } else {
            $requestData['from_date'] = null;
            $requestData['to_date'] = null;
        }

        // validate message
        $messageList = [
            'to_date.after' => trans('admin.time_base_pricing_rules.validation_message.to_date'),
            'to_time.after' => trans('admin.time_base_pricing_rules.validation_message.to_time'),
        ];

        $requestData['restaurant_id'] = $this->restaurant->id;
        $requestData['type'] = 1;

        $this->validate($request, $validateList, $messageList);

        if ($requestData['all_days']) {
            $requestData['mon'] = true;
            $requestData['tue'] = true;
            $requestData['wed'] = true;
            $requestData['thu'] = true;
            $requestData['fri'] = true;
            $requestData['sat'] = true;
            $requestData['sun'] = true;
        } else {
            $requestData['mon'] = $request->mon ? true : false;
            $requestData['tue'] = $request->tue ? true : false;
            $requestData['wed'] = $request->wed ? true : false;
            $requestData['thu'] = $request->thu ? true : false;
            $requestData['fri'] = $request->fri ? true : false;
            $requestData['sat'] = $request->sat ? true : false;
            $requestData['sun'] = $request->sun ? true : false;
        }

        $requestData['active'] = $request->active ? true : false;

        $timeBasePricingRule = TimeBasePricingRule::findOrFail($id);

        $timeBasePricingRule->update($requestData);

        $backUrl = $requestData['back_url'];

        Session::flash('flash_message', trans('admin.time_base_pricing_rules.flash_message.update'));
        return redirect($backUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($slug, $id)
    {
        $this->restaurant = Session::get('res');

        $timeBasePricingRule = TimeBasePricingRule::findOrFail($id);

        $timeBasePricingRule->delete();

        Session::flash('flash_message', trans('admin.time_base_pricing_rules.flash_message.destroy'));

        return redirect('admin/'.$this->restaurant->res_Slug.'/time-base-pricing-rules');
    }

    public function getList($slug)
    {
        $restaurant = Restaurant::where('slug', '=', $slug)->first();
        $tbp = $restaurant->getTimeBasePricingRule();
        return response()->json(['data' => $tbp]);
    }

    /**
     *
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
//    public function batch(Request $request, $slug)
//    {
//        $requestData = $request->request->all();
//        if($requestData['action'] == 'duplicate') {
//            if(isset($requestData['all_elements'])) {
//                $categories = TimeBasePricingRule::select()->get();
//                $result = $this->batchDuplicate($categories);
//                if($result) {
//                    Session::flash('flash_message', trans('admin.time_base_pricing_rules.flash_message.duplicate_success'));
//                } else {
//                    Session::flash('flash_message', trans('admin.time_base_pricing_rules.flash_message.duplicate_error'));
//                }
//            } else {
//                if(isset($requestData['idx'])) {
//                    $list = explode(',',$requestData['idx']);
//                    $categories = TimeBasePricingRule::whereIn('id',$list)->get();
//                    $result = $this->batchDuplicate($categories);
//                    if($result) {
//                        Session::flash('flash_message', trans('admin.time_base_pricing_rules.flash_message.duplicate_success'));
//                    } else {
//                        Session::flash('flash_message', trans('admin.time_base_pricing_rules.flash_message.duplicate_error'));
//                    }
//                }
//            }
//        }
//        if($requestData['action'] == 'delete') {
//            Session::flash('flash_message', trans('admin.time_base_pricing_rules.flash_message.delete_coming_soon'));
//        }
//        return redirect('admin/'.$slug.'/time-base-pricing-rules');
//    }
//
//    protected function batchDuplicate($timebases = array()) {
//        if(empty($timebases)) return false;
//        \DB::beginTransaction();
//        try {
//            foreach ($timebases as $key => $timebase) {
//                $new_item = TimeBasePricingRule::findOrFail($timebase->id)->replicate();
//                $new_item->save();
//            }
//            \DB::commit();
//            $is_success = true;
//        } catch (\Exception $e) {
//            \DB::rollback();
//            $is_success = false;
//        }
//        return $is_success;
//    }
    public function duplicateTBP($slug,$id)
    {
        $tbp = TimeBasePricingRule::findOrFail($id);

        $newTbp = $tbp->replicate();

        $newTbp->name = $newTbp->name . " Copy " . rand(1000, 9999);

        $newTbp->save();

        Session::flash('flash_message', trans('admin.time_base_pricing_rules.flash_message.duplicate'));
        return redirect('admin/' . $slug . '/time-base-pricing-rules');
    }

    public function changeStatusTimeBasePrising($slug, Request $request){
        $item_id = $request->input('item_id');
        $timeBasePricingRules= TimeBasePricingRule::findOrFail($item_id);
        $active = $request->input('active');
        $timeBasePricingRules->active= $active;
        $timeBasePricingRules->save();
        return response()->json(['error'=>false,'message' => trans('admin.time_base_pricing_rules.time_base_pricing_rule_status.success'),'active' => $timeBasePricingRules->active]);
    }
}
