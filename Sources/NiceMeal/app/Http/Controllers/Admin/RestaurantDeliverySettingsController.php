<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use App\Models\Ward;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RestaurantDeliverySetting;
use Illuminate\Support\Facades\Session;
use Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RestaurantDeliverySettingsController extends BelongToResController
{
    CONST default_index = 'restaurant_delivery_setting';
    CONST required_method = ['edit','update','destroy'];
    CONST model = RestaurantDeliverySetting::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$slug)
    {
        $this->restaurant = Session::get('res');
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.restaurant_delivery_settings.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $this->restaurant['slug'] . '/restaurant-delivery-settings'),
                    'text' => __('admin.restaurant_delivery_settings.breadcrumbs.restaurant_delivery_settings_index')
                ]
            ]
        ];
        session(['mainPage' => $request->fullUrl()]);

        $lang = Session::get('locale');

        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $restaurantDeliverySettings = RestaurantDeliverySetting::join('districts', 'districts.id', 'restaurant_delivery_settings.district_id')
            ->join('restaurants', 'restaurants.id', 'restaurant_delivery_settings.restaurant_id')
            ->select("restaurants.name_en as restaurant_name",
                "districts.type_en as district_type",
                "districts.name_en as district_name",
                "restaurant_delivery_settings.*",
                "restaurant_delivery_settings.id as delivery_id")
            ->where('restaurant_delivery_settings.restaurant_id', $this->restaurant->id)
            ->where('parent_id','=',0)
            ->orderBy('districts.sequence', 'asc');

        $restaurantDeliverySettings = $restaurantDeliverySettings->paginate($perPage);

        return view('admin.restaurant_delivery_settings.index', compact('restaurantDeliverySettings', 'breadcrumbs', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $this->restaurant = Session::get('res');
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.restaurant_delivery_settings.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $this->restaurant['slug'] . '/restaurant-delivery-settings'),
                    'text' => __('admin.restaurant_delivery_settings.breadcrumbs.restaurant_delivery_settings_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurant_delivery_settings.breadcrumbs.restaurant_delivery_settings_create')
                ]
            ]
        ];
        
        $delivery_settings = RestaurantDeliverySetting::where('restaurant_id','=',$this->restaurant->id)->get();
    
        return view('admin.restaurant_delivery_settings.create', compact('breadcrumbs', 'lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$slug)
    {
        $currentTime = Carbon::now()->toTimeString();
        $this->restaurant = Session::get('res');
        $requestData = $request->all();
        $resId = $this->restaurant->id;
        Log::error($requestData);
        
        $validateList = [
//            'district_id' => "required|unique:restaurant_delivery_settings,district_id,null,null,restaurant_id,$resId",
            'delivery_cost' => 'required|numeric|max:100000000',
            'min_order_amount' => 'required|numeric|max:100000000',
            'from' => "required",
            'to' => "required",
            'time' => "required|numeric",
        ];
        if($request->input('sub_setting') != null){
            foreach ($requestData['sub_setting'] as $key => $sub_setting){
                $validateList['sub_setting.'.$key.'.delivery_cost'] = 'numeric|min:1';
                $validateList['sub_setting.'.$key.'.bill_from'] = 'numeric|min:1';
                $validateList['sub_setting.'.$key.'.bill_to'] = 'numeric|min:1';
                $sub_delivery_cost = $sub_setting['delivery_cost'];
                $sub_bill_from = $sub_setting['bill_from'];
                $sub_bill_to = $sub_setting['bill_to'];
            }
            if($sub_delivery_cost < 1 || $sub_bill_from < 1|| $sub_bill_to < 1) {
                Session::flash('flash_error', trans('admin.restaurant_delivery_settings.flash_message.error_delivery_cost'));
            }
        }
        $requestData['restaurant_id'] = $this->restaurant->id;       
        $messageList = [
            'delivery_time.after' => trans('admin.restaurant_delivery_settings.validation_message.delivery_time'),
        ];

        $this->validate($request, $validateList, $messageList);
        $url = $request->fullUrl().'/create';
        if($requestData['from'] > $requestData['to']) {
            Session::flash('flash_error', trans('admin.restaurant_delivery_settings.flash_message.error'));
            return redirect($url);
        }else {
            $main_setting = RestaurantDeliverySetting::create($requestData);
            Session::flash('flash_message', trans('admin.restaurant_delivery_settings.flash_message.new'));
        }

        if(isset($requestData["sub_setting"])){
            $this->insertSubSetting($main_setting,collect($requestData["sub_setting"]));
        }

        return redirect('admin/'.$this->restaurant->res_Slug.'/restaurant-delivery-settings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug,$id)
    {
        $lang = Session::get('locale');
        $this->restaurant = Session::get('res');
        $breadcrumbs = [
            'title' => __('admin.restaurant_delivery_settings.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $this->restaurant['slug'] . '/restaurant-delivery-settings'),
                    'text' => __('admin.restaurant_delivery_settings.breadcrumbs.restaurant_delivery_settings_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurant_delivery_settings.breadcrumbs.restaurant_delivery_settings_update')
                ]
            ]
        ];

        $restaurantDeliverySettings = RestaurantDeliverySetting::where('parent_id','=',$id)->orWhere('id','=',$id)->get();
        $mainRes = RestaurantDeliverySetting::findOrFail($id);
        $mainDS = $restaurantDeliverySettings->where('parent_id','=',0)->first();
        $subDS = $restaurantDeliverySettings->where('parent_id','!=',0);

        return view('admin.restaurant_delivery_settings.edit', compact('mainDS','subDS','breadcrumbs', 'lang','mainRes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug,$id)
    {
        $currentTime = Carbon::now()->toTimeString();
        $this->restaurant = Session::get('res');
        $resId = $this->restaurant->id;
        $requestData = $request->all();
        $validateList = [
            'district_id' => "required",
            'from' => "required",
            'to' => "required",
            'delivery_cost' => 'required|numeric|max:100000000',
            'min_order_amount' => 'required|numeric|max:100000000',
            'time' => "required|numeric",
        ];
        if($request->input('sub_setting') != null){
            foreach ($requestData['sub_setting'] as $key => $sub_setting){
                $validateList['sub_setting.'.$key.'.delivery_cost'] = 'numeric|min:1';
                $validateList['sub_setting.'.$key.'.bill_from'] = 'numeric|min:1';
                $validateList['sub_setting.'.$key.'.bill_to'] = 'numeric|min:1';
                $sub_delivery_cost = $sub_setting['delivery_cost'];
                $sub_bill_from = $sub_setting['bill_from'];
                $sub_bill_to = $sub_setting['bill_to'];
            }
            if($sub_delivery_cost < 1 || $sub_bill_from < 1|| $sub_bill_to < 1) {
                Session::flash('flash_error', trans('admin.restaurant_delivery_settings.flash_message.error_delivery_cost'));
            }
        }
        $requestData['restaurant_id'] = $this->restaurant->id;

        $messageList = [
            'delivery.after' => trans('admin.restaurant_delivery_settings.validation_message.delivery_time'),
        ];
        $main_setting = RestaurantDeliverySetting::findOrFail($id);
        $this->validate($request, $validateList, $messageList);

        $current_setting = RestaurantDeliverySetting::where('parent_id','=',$id)->get()->pluck('id');

        if(isset($requestData["sub_setting"])){
            $sub_setting = collect($requestData["sub_setting"]);
            $new_setting = $sub_setting->filter(function($item){
                return $item['setting_id'] == 0;
            });
            $old_setting = $sub_setting->filter(function($item){
                return $item['setting_id'] > 0;
            });
            
            $deleted_setting = $current_setting->diff($old_setting->pluck('setting_id'));
            RestaurantDeliverySetting::whereIn('id',$deleted_setting)->delete();
            if($new_setting->count() > 0 ){
                $this->insertSubSetting($main_setting,$new_setting);
            }

            if($old_setting->count() > 0 ){
                $this->updateSubSetting($old_setting);
            }
        }else{
            if($current_setting->count() > 0){
                RestaurantDeliverySetting::where('parent_id','=',$id)->delete();
            }
        }
        
        $sub_data = [];
        $sub_data['district_id'] = $requestData['district_id'];
        $sub_data['min_order_amount'] = $requestData['min_order_amount'];
        RestaurantDeliverySetting::where('parent_id','=',$id)->update($sub_data);

        $restaurantDeliverySetting = RestaurantDeliverySetting::findOrFail($id);
        $url = $request->fullUrl().'/edit';
        if($requestData['from'] > $requestData['to']) {
            Session::flash('flash_error', trans('admin.restaurant_delivery_settings.flash_message.error'));
            return redirect($url);
        } else {
            $restaurantDeliverySetting->update($requestData);
            Session::flash('flash_message', trans('admin.restaurant_delivery_settings.flash_message.update'));
        }


        return redirect('admin/'.$this->restaurant->res_Slug.'/restaurant-delivery-settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug,$id)
    {
        $this->restaurant = Session::get('res');

        $restaurantDeliverySetting = RestaurantDeliverySetting::findOrFail($id);

        $restaurantDeliverySetting->delete();

        RestaurantDeliverySetting::where('parent_id',$id)->delete();

        Session::flash('flash_message', trans('admin.restaurant_delivery_settings.flash_message.destroy'));
        return redirect('admin/'.$this->restaurant->res_Slug.'/restaurant-delivery-settings');
    }

    public function insertSubSetting($parent, $new_setting){
        $data = [];
        foreach($new_setting as $row){
            $data_row = [];
            $data_row['delivery_cost'] = $row['delivery_cost'];
            $data_row['restaurant_id'] = $parent->restaurant_id;
            $data_row['district_id'] = $parent->district_id;
            $data_row['min_order_amount'] = $parent->min_order_amount;
            $data_row['from'] = $row['bill_from'];
            $data_row['parent_id'] = $parent->id;
            $data_row['to'] = $row['bill_to'];
            $data_row['ward_id'] = $parent->ward_id;
            array_push($data,$data_row);
        }
        RestaurantDeliverySetting::insert($data);
    }
    
    public function updateSubSetting($updateable_setting){
        foreach($updateable_setting as $row){
            $data = [];
            $data['delivery_cost'] = $row['delivery_cost'];
            $data['to'] = $row['bill_to'];
            $data['from'] = $row['bill_from'];
            RestaurantDeliverySetting::where('id','=',$row['setting_id'])->update($data);
        }
    }

    public function getWardsByDistrictId() {
        $language = Session::get('locale');
        $district_id = '';
        if(request()->has('district_id')) {
            $district_id = request()->query('district_id');
        }
        $wards = array();
        if(empty($district_id)) return response()->json($wards);
        try {
            $district = District::where('id',$district_id)->firstOrFail();
            $wards = Ward::select("name_$language as name", "type_$language as type", "wards.*")->where('district_id',$district->id)->get()->toArray();
        } catch (Exception $exception) {
            return response()->json($wards);
        }
        return response()->json($wards);
    }
}
