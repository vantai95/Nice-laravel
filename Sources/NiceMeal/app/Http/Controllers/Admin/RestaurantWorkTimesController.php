<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RestaurantWorkTime;
use App\Services\DateTimeHandleService;
use App\Models\Restaurant;
use App\Services\CommonService;
use App\Services\WorkingTimeService;
use Log, Auth, Session;

class RestaurantWorkTimesController extends BelongToResController
{
    CONST default_index = 'restaurant_work_time';
    CONST required_method = ['edit','update','destroy'];
    CONST model = RestaurantWorkTime::class;

    protected $workingTimeServie;

    public function __construct(WorkingTimeService $workingTimeServie){
      $this->workingTimeServie = $workingTimeServie;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$slug)
    {
        // breadrums on head page
        $this->restaurant = Session::get('res');
        $breadcrumbs = [
            'title' => __('admin.restaurant_work_times.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $slug . '/restaurant-work-times'),
                    'text' => __('admin.restaurant_work_times.breadcrumbs.restaurants_index')
                ]
            ]
        ];
        session(['mainPage' => $request->fullUrl()]);

        // get search params
        $keyword = $request->get('q');
        $status = $request->get('status');
        $lang = Session::get('locale');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $work_times = RestaurantWorkTime::select('restaurant_work_times.id','restaurant_work_times.restaurant_id')
        ->with('time_setting.time_setting_details')
        ->orderBy('restaurant_work_times.id', 'desc');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $work_times = $work_times->where(function ($query) use ($keyword) {
                $query->orWhere('restaurant_work_times.working_date_en', 'LIKE', $keyword);
                $query->orWhere('restaurant_work_times.working_date_ja', 'LIKE', $keyword);
            });
        }

        $restaurantId = $this->restaurant->id;

        $work_times = $work_times->where(function ($query) use ($restaurantId) {
            $query->orWhere("restaurant_work_times.restaurant_id", '=', $restaurantId);
        });
        $work_times = $work_times->paginate($perPage);

        return view ('admin.restaurant_work_times.index',compact('work_times', 'status',  'breadcrumbs', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $breadcrumbs = [
            'title' => __('admin.restaurant_work_times.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'. $slug .'/restaurant-work-times'),
                    'text' => __('admin.restaurant_work_times.breadcrumbs.restaurants_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurant_work_times.breadcrumbs.add_restaurant')
                ]
            ]
        ];
        $restaurants = Restaurant::get();
        $dateList = RestaurantWorkTime::DAY_FILTER;
        $lang = Session::get('locale');

        return view('admin.restaurant_work_times.create', compact('breadcrumbs','restaurants','dateList', 'lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$slug)
    {
        $requestData = $request->all();
        $this->validate($request,[
            'all_days' => 'required|in:0,1',
            'all_times' => 'required|in:0,1',
        ]);
        $this->restaurant = Session::get('res');
        $requestData = $request->all();
        $url = $request->fullUrl().'/create';
        if($requestData['all_times'] == "0") {
            foreach ($request->specific_time as $spTimeKey => $spTimeValue){
                $fromTime = strtotime($spTimeValue['from_time']);
                $toTime = strtotime($spTimeValue['to_time']);
                foreach ($request->specific_time as $spTimeKeyTemp => $spTimeValueTemp) {
                    $fromTimeTemp = strtotime($spTimeValueTemp['from_time']);
                    $toTimeTemp = strtotime($spTimeValueTemp['to_time']);
                    if($spTimeKey != $spTimeKeyTemp) {
                        if(($fromTime >= $fromTimeTemp && $fromTime <= $toTimeTemp) || ($toTime >= $fromTimeTemp && $toTime <= $toTimeTemp)) {
                            Session::flash('flash_error', trans('admin.restaurant_work_times.flash_messages.error'));
                            return redirect($url);
                        }
                    }
                }
            }
            if(array_key_exists('specific_time',$requestData)) {
                $this->workingTimeServie->createWorkingTime($requestData,$this->restaurant);
            } else {
                Session::flash('flash_error', trans('admin.restaurant_work_times.flash_messages.error'));
                return redirect($url);
            }
        }else {
            $this->workingTimeServie->createWorkingTime($requestData,$this->restaurant);
        }
        // Remove Session
        Session::flash('flash_message', trans('admin.restaurant_work_times.flash_messages.new'));
        return redirect('admin/'.$slug.'/restaurant-work-times');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug,$id)
    {
        $breadcrumbs = [
            'title' => __('admin.restaurant_work_times.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'. $slug .'/restaurant-work-times'),
                    'text' => __('admin.restaurant_work_times.breadcrumbs.restaurants_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurant_work_times.breadcrumbs.edit_restaurant')
                ]
            ]
        ];

        $work_times = RestaurantWorkTime::select('restaurant_work_times.id','restaurant_work_times.restaurant_id')
        ->with('time_setting.time_setting_details')->findOrFail($id);
        $toTime = explode(':', $work_times->to_time);
        if ($toTime[0] > 24) {
            $work_times->to_time = ($toTime[0]-24) . ':' . $toTime[1] . ':' . $toTime[2];
        };
        $dateList = RestaurantWorkTime::DAY_FILTER;
        $lang = Session::get('locale');

        return view('admin.restaurant_work_times.edit',compact('work_times', 'breadcrumbs', 'dateList', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$slug ,$id)
    {
        $this->validate($request,[
            'all_days' => 'required|in:0,1',
            'all_times' => 'required|in:0,1',
        ]);

        $this->restaurant = Session::get('res');
        $resWorkTime =RestaurantWorkTime::select('restaurant_work_times.id','restaurant_work_times.restaurant_id')
        ->with('time_setting.time_setting_details')->findOrFail($id);

        $requestData = $request->all();
        $url = $request->fullUrl().'/edit';
        if($requestData['all_times'] == "0") {
            if(array_key_exists('specific_time',$requestData)) {
                $this->workingTimeServie->updateWorkingTime($resWorkTime,$requestData,$this->restaurant);
            } else {
                Session::flash('flash_error', trans('admin.restaurant_work_times.flash_messages.error'));
                return redirect($url);
            }
        }else {
            $this->workingTimeServie->updateWorkingTime($resWorkTime,$requestData,$this->restaurant);
        }

        Session::flash('flash_message', trans('admin.restaurant_work_times.flash_messages.update'));
        return redirect('admin/'.$slug.'/restaurant-work-times');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug,$id)
    {
        $restaurant = RestaurantWorkTime::findOrFail($id);

        $restaurant->delete();

        Session::flash('flash_message', trans('admin.restaurant_work_times.flash_messages.destroy'));
        return redirect('admin/'.$slug.'/restaurant-work-times');
    }

}
