<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DishCategory;
use App\Models\District;
use App\Models\Province;
use App\Models\Restaurant,App\Models\Tag;
use App\Models\SettingKey;
use App\Models\Setting;
use App\Models\Ward;
use App\Services\CommonService;
use App\Services\Restaurant\RestaurantDuplicateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Log, Auth, Session, DB;
use Storage;
use App\Models\FaqType;

class RestaurantsController extends BelongToResController
{
    CONST default_index = 'restaurant';
    CONST required_method = ['edit','update','destroy',
        'updateOtpSetting','updateTagInfo','updateDetailInfo',
        'duplicateRestaurant','updateIntro','exchangeRateUpdate'];
    CONST model = Restaurant::class;
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/restaurants'),
                    'text' => __('admin.restaurants.breadcrumbs.restaurants_index')
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
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $restaurants = Restaurant::select('restaurants.*' )->orderBy('restaurants.sequence', 'desc');
        // filter with search params
        if (!empty($status)) {
            if ($status == Restaurant::STATUS_FILTER['inactive']) {
                $restaurants = $restaurants->where('active', '=', false);
            } elseif ($status == Restaurant::STATUS_FILTER['active']) {
                $restaurants = $restaurants->where('active', '=', true);
            }
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $restaurants = $restaurants->where(function ($query) use ($keyword) {
                $query->orWhere('restaurants.name_en', 'LIKE', $keyword);
                $query->orWhere('restaurants.name_ja', 'LIKE', $keyword);
            });
        }
        if(Auth::user()->isRestaurant() && !(Auth::user()->isAdmin() || Auth::user()->isManageAllRestaurant())){
            $userId = Auth::user()->id;
            $restaurants = $restaurants->join('users_restaurants','restaurants.id','users_restaurants.restaurant_id')
                            ->where(function ($query) use ($userId) {
                                $query->orWhere("users_restaurants.user_id", '=',$userId);
                            }) ;
        }

        $restaurants = $restaurants->distinct('users_restaurants.restaurant_id')->paginate($perPage);
        return view ('admin.restaurants.index',compact('restaurants', 'status',  'breadcrumbs', 'lang'));
    }

    public function show(){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/restaurants'),
                    'text' => __('admin.restaurants.breadcrumbs.restaurants_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants.breadcrumbs.add_restaurant')
                ]
            ]
        ];

        $statuses = Restaurant::STATUSES_FILTER;
        $faqs = FaqType::get();
        return view('admin.restaurants.create',compact('breadcrumbs', 'statuses','lang','faqs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->merge(['maximum_discount' => CommonService::price2Number($request['maximum_discount']) ?? NULL]);
        $this->validation('restaurants', $request, [
            'name_en' => 'required|unique:restaurants,name_en',
            'tags' => 'required',
            'address_en' => 'required',
            'email' => 'required|string|email|max:255',
            'active' => 'integer|boolean',
            'phone' => 'required|min:8',
            'online_payment' => 'integer|boolean|required_without:cod_payment',
            'cod_payment' => 'integer|boolean|required_without:online_payment',
            'delivery' => 'integer|boolean|required_without:pickup',
            'pickup' => 'integer|boolean|required_without:delivery',
            'slug' => 'regex:/^([A-Za-z0-9-]+)$/|unique:restaurants,slug',
            'maximum_discount' => 'nullable|integer'
        ]);
        $requestData = $request->all();
        $requestData['active'] = isset($requestData['active']) ? true : false;
        $requestData['online_payment'] = isset($requestData['online_payment']) ? true : false;
        $requestData['cod_payment'] = isset($requestData['cod_payment'])? true : false;
        $requestData['delivery'] = isset($requestData['delivery']) ? true : false;
        $requestData['pickup'] = isset($requestData['pickup'])? true : false;
        $vip_restaurant = isset($requestData['vip_restaurant']) ? (int) $requestData['vip_restaurant'] : 0;
        $requestData['vip_restaurant'] = $vip_restaurant > 0 ? $vip_restaurant : null;
        $requestData['published'] = isset($requestData['published']) ? true : false;
        $requestData['address_ja'] = $request->get('address_en');
        $requestData['note'] = $request->get('note');
        $requestData['name_ja'] = !empty($request->get('name_ja')) ? $request->get('name_ja') : $request->get('name_en');
        $requestData['description_en'] = strip_tags($requestData['description_en']);
        $requestData['description_ja'] = !empty($request->get('description_ja')) ?  strip_tags($request->get('description_ja')) : strip_tags($request->get('description_en'));
        $requestData['faqs'] = isset($requestData['faqs']) ? json_encode($requestData['faqs']) : "";
        //dd($requestData);
        //$restaurantSequence = Restaurant::where('restaurant_id',$resId)->orderBy('sequence','desc')->first();

        if(!empty($restaurantSequence)){
          $requestData['sequence'] =  $restaurantSequence->sequence + 1;
        }else {
            $requestData['sequence'] = 1;
        }
        foreach ($requestData as $key => $value) {
            //if $key is image, add image
            if (strpos($key, 'image') !== false) {
                $base64_img = $value;
                $photoName = time() . '.png';
                //encode base-64 string to image
                if (!empty($base64_img)) {
                    $image = explode(",", $base64_img)[1];
                } else {
                    $image = '';
                }
                //File::put(public_path(config('constants.UPLOAD.IMAGES')) . '/' . $photoName, base64_decode($image));
                Storage::disk(ENV('FILESYSTEM_CLOUD'))->put($photoName, base64_decode($image));
                //add image to Database
                $requestData['image'] = $photoName;

            }
        }
        if (empty($requestData['image'])) {
            $requestData['image'] = '';
        }
        //print_r($requestData);
        $tags = Tag::whereIn('id',$requestData['tags'])->get();
        $title_brief_en='';$title_brief_ja='';
        foreach($tags as $key => $value){
            if($key==0){
                $title_brief_en=$value->name_en;
                $title_brief_ja=$value->name_ja;
            }else{
                $title_brief_en .=", ".$value->name_en;
                $title_brief_ja .=", ".$value->name_ja;
            }
        }

        $requestData['title_brief_en'] = $title_brief_en;
        $requestData['title_brief_ja'] = $title_brief_ja;
        $requestData['tags'] ='';
        $requestData['status'] = 1;

        Restaurant::create($requestData);
         if (isset($requestData_dished)) {
            $dishes_data = [];
            foreach ($requestData_dished as $key => $value) {
                $dishes_row = [
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'restaurant_id' => $this->restaurant->id,
                    'category_id' => $id,
                    'dish_id' => $value,
                    'sequence' => $key + 1
                ];
                array_push($dishes_data, $dishes_row);
            }
            DishCategory::insert($dishes_data);
        }

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.new'));
        return redirect('admin/restaurants');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/restaurants'),
                    'text' => __('admin.restaurants.breadcrumbs.restaurants_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants.breadcrumbs.edit_restaurant')
                ]
            ]
        ];

        $restaurant = Restaurant::findOrFail($id);
        if(empty($restaurant->image)) $restaurant->image = '';
        $title_brief = explode(", ", $restaurant->title_brief_en);
        $tag = json_encode(Tag::whereIn('name_en',$title_brief)->pluck("id")->toArray());
        $statuses = Restaurant::STATUSES_FILTER;
        return view('admin.restaurants.edit',compact('restaurant', 'breadcrumbs', 'statuses', 'tag', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $request->merge(['maximum_discount' => CommonService::price2Number($request['maximum_discount']) ?? NULL]);
        $this->validation('restaurants', $request, [
            'name_en' => 'required|unique:restaurants,name_en,'.$id,
            'title_brief_en' => 'required',
            'address_en' => 'required',
            'tags' => 'required',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|min:8',
            'active' => 'integer|boolean',
            'online_payment' => 'integer|boolean|required_without:cod_payment',
            'cod_payment' => 'integer|boolean|required_without:online_payment',
            'delivery' => 'integer|boolean|required_without:pickup',
            'pickup' => 'integer|boolean|required_without:delivery',
            'slug' => 'regex:/^([A-Za-z0-9-]+)$/|unique:restaurants,slug,'.$id,
            'maximum_discount' => 'nullable|integer',
            'intro' => 'request|string',
            'vip_restaurant' => 'nullable|integer'
        ]);

        $restaurant = Restaurant::findOrFail($id);

        $requestData = $request->all();
        $requestData['active'] = isset($requestData['active']) ? true : false;
        $requestData['online_payment'] = isset($requestData['online_payment']) ? true : false;
        $requestData['cod_payment'] = isset($requestData['cod_payment']) ? true : false;
        $requestData['delivery'] = isset($requestData['delivery']) ? true : false;
        $requestData['pickup'] = isset($requestData['pickup']) ? true : false;
        $vip_restaurant = isset($requestData['vip_restaurant']) ? (int) $requestData['vip_restaurant'] : 0;
        $requestData['vip_restaurant'] = $vip_restaurant > 0 ? $vip_restaurant : null;
        $requestData['name_ja'] = !empty($request->get('name_ja')) ? $request->get('name_ja') : $request->get('name_en');
        $requestData['description_en'] = strip_tags($requestData['description_en']);
        $requestData['description_ja'] = !empty($request->get('description_ja')) ?  strip_tags($request->get('description_ja')) : strip_tags($request->get('description_en'));

        $isRemoveImage = true;
        foreach ($requestData as $key => $value) {
            //if $key is image, add image
            if (strpos($key, 'image') !== false) {
                $base64_img = $value;
                $photoName = time() . '.png';
                //encode base-64 string to image
                if (!empty($base64_img)) {
                    $image = explode(",", $base64_img)[1];
                } else {
                    $image = '';
                }
                //File::put(public_path(config('constants.UPLOAD.IMAGES')) . '/' . $photoName, base64_decode($image));
                Storage::disk(ENV('FILESYSTEM_CLOUD'))->put($photoName, base64_decode($image));
                //add image to Database
                $requestData['image'] = $photoName;

            }
        }

        $tags = Tag::whereIn('id',$requestData['tags'])->get();
        $title_brief_en='';$title_brief_ja='';
        foreach($tags as $key => $value){
            if($key==0){
                $title_brief_en=$value->name_en;
                $title_brief_ja=$value->name_ja;
            }else{
                $title_brief_en .=", ".$value->name_en;
                $title_brief_ja .=", ".$value->name_ja;
            }
        }

        $requestData['title_brief_en'] = $title_brief_en;
        $requestData['title_brief_ja'] = $title_brief_ja;
        $requestData['tags'] ='';


        $restaurant->update($requestData);
        if (isset($requestData_dishes)) {
                $ds_data = [];
                foreach ($requestData_dishes as $key => $value) {
                    $ds_row = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $this->restaurant->id,
                        'dish_id' => $value,
                        'category_id' => $id,
                        'sequence' => $key + 1
                    ];
                    array_push($ds_data, $ds_row);
                }
                DishCategory::insert($ds_data);
            }
        Session::flash('flash_message', trans('admin.restaurants.flash_messages.update'));
        return redirect('admin/restaurants');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        File::delete(public_path(config('constants.UPLOAD.IMAGES')). '/' . $restaurant->image);

        $restaurant->delete();

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.destroy'));
        return redirect('admin/restaurants');
    }

    public function getCategories($restaurant_id){
         $categories = Category::where('categories.restaurant_id','=',$restaurant_id)
        ->orderBy('categories.created_at', 'desc')->get();

        return response()->json(['data'=>$categories]);
    }

    public function chooseRestaurant(){

        if(Auth::user()->isRestaurant()){
            Session::flash('flash_error', 'Bạn không có quyền vào trang!');
            return redirect('admin');
        }

        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants.breadcrumbs.choose')
                ]
            ]
        ];

        $restaurant = Restaurant::all();
        return view('admin.restaurants.choose',compact('breadcrumbs','restaurant'));
    }

    public function doChooseRestaurant($restaurant_id){
        $res = Restaurant::where('id','=',$restaurant_id)
                ->select(DB::raw('restaurants.*,restaurants.slug as res_Slug'))
                ->first();
        Session::put('res',$res);
        return redirect('admin/'.$res->res_Slug.'/detail-info');
    }

    public function duplicateRestaurant($id){
        $res = Restaurant::findOrFail($id);
        RestaurantDuplicateService::dupRestaurant($res);

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.duplicate'));
        return redirect('admin/restaurants');
    }

    public function upload()
    {
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function top()
    {
        if(Auth::user()->isRestaurant()){
            Session::flash('flash_error', 'Bạn không có quyền vào trang!');
            return redirect('admin/foodie');
        }
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/restaurants'),
                    'text' => __('admin.restaurants.breadcrumbs.restaurants_index')
                ]
            ]
        ];
        $restaurants = Restaurant::select('id','name_en','name_ja','vip_restaurant') -> whereNotNull ('vip_restaurant') -> get ();

        return view('admin.restaurants.top',compact('restaurants', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateTop(Request $request)
    {

        if(Auth::user()->isRestaurant()){
            Session::flash('flash_error', 'Bạn không có quyền vào trang!');
            return redirect('admin/foodie');
        }
        $requestData = $request->all();
        $maxValue = Restaurant::max('vip_restaurant');
        // $restaurants =
        // // foreach $restaurants
        // $restaurant = Restaurant::find($id);
        // $restaurant->vip_restaurant = $requestData['vip_restaurant'];

        foreach ($requestData['restaurant_id'] as $key => $value) {
                    $restaurants = Restaurant::where('id',$value)->first();
                        $restaurants->update(['vip_restaurant'=> $maxValue+$key+1]);
                }

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.update_top'));
        return redirect('admin/top');
    }

    // Show detail info of restaurant
    public function showDetailInfo($slug)
    {
        $lang = Session::get('locale');
        $daysFullName = \Lang::get("admin.day_name");
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.general_info'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants.breadcrumbs.detail_info')
                ]
            ]
        ];
        $detailInfo = Restaurant::where('slug',$slug)
        ->with('restaurantWorkTimes.time_setting.time_setting_details')
        ->with(['restaurantDeliverySetting' => function($query) use ($lang){
          $query->select('restaurant_delivery_settings.id','restaurant_delivery_settings.restaurant_id',
          'restaurant_delivery_settings.district_id','restaurant_delivery_settings.delivery_cost',
          "districts.name_$lang as district_name",
          'restaurant_delivery_settings.min_order_amount','restaurant_delivery_settings.parent_id')
          ->join('districts','districts.id','=','restaurant_delivery_settings.district_id');
        }])->first();

        if($detailInfo->online_payment == 1 && $detailInfo->cod_payment == 0) {
            $payment_type = 'online';
        } elseif ($detailInfo->online_payment == 0 && $detailInfo->cod_payment == 1) {
            $payment_type = 'cod';
        } elseif ($detailInfo->cod_payment == 1 && $detailInfo->online_payment == 1) {
            $payment_type = 'cod_and_online';
        } else {
            $payment_type = 'no_setting';
        }

        $onlinePayments = Setting::where('restaurant_id',$detailInfo->id)->select('settings.*')->get();

        if(!$onlinePayments->isEmpty()) {
            $paypal = false;
            $nganluong = false;
            foreach ($onlinePayments as $onlinePayment) {
                if($onlinePayment['key'] == 'paypal') {
                    if($onlinePayment['value'] == 1) {
                        $paypal = true;
                    }
                }

                if($onlinePayment['key'] == 'nganluong') {
                    if($onlinePayment['value'] == 1) {
                        $nganluong = true;
                    }
                }
            }
        } else {
            $paypal = false;
            $nganluong = false;
        }
        ($detailInfo->faqs == null) ? $detailInfo->faqs = [] : $detailInfo->faqs = json_decode($detailInfo->faqs);
        $faqs = FaqType::get();
        return view('admin.restaurants.general_info.detail_info',compact('detailInfo','breadcrumbs','lang','daysFullName', 'payment_type', 'onlinePayments', 'paypal', 'nganluong','faqs'));
    }

    // edit detail info
    public function updateDetailInfo($slug, $id, Request $request)
    {
        $request->merge(['maximum_discount' => CommonService::price2Number($request['maximum_discount']) ?? NULL]);
        $requestData = $request->all();
        $validateList = [
            'name_en' => 'required|unique:restaurants,name_en,'.$id,
            'address_en' => 'required',
            'email' => 'required|string|email|max:255'.$id,
            'phone' => 'required|min:8',
            'slug' => 'regex:/^([A-Za-z0-9-]+)$/|unique:restaurants,slug,'.$id,
            'delivery' => 'integer|boolean|required_without:pickup',
            'pickup' => 'integer|boolean|required_without:delivery',
            'maximum_discount' => 'nullable|integer'
        ];
        \Log::debug($requestData);
        $requestData['link'] ? $validateList['link'] = 'url' : $validateList['link'] = '';
        $requestData['owner_email'] ? $validateList['owner_email'] = 'string|email' : $validateList['owner_email'] = '';
        $requestData['owner_phone'] ? $validateList['owner_phone'] = 'min:10' : $validateList['owner_phone'] = '';
        $requestData['delivery'] = isset($requestData['delivery']) ? true : false;
        $requestData['pickup'] = isset($requestData['pickup']) ? true : false;
        $requestData['published'] = isset($requestData['published']) ? true : false;
        $requestData['active'] = isset($requestData['active']) ? true : false;
        $requestData['faqs'] = isset($requestData['faqs']) ? json_encode($requestData['faqs']) : "";
        $this->validate($request, $validateList);
        $detailInfo = Restaurant::where('slug',$slug)->findOrFail($id);

        if (is_null($requestData['image'])) {
            $requestData['image'] = '';
        }
        $detailInfo->update($requestData);
        $res_data = Session::get('res');
        $res_data->res_Slug = $requestData['slug'];
        Session::put('res',$res_data);

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.update'));
        return redirect('admin/'.$requestData['slug'].'/detail-info');
    }

    // show intro
    public function showIntro($slug)
    {
    $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.intro.breadcrumbs.intros'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.intro.breadcrumbs.intro_detail')
                ]
            ]
        ];
        $intro = Restaurant::where('slug',$slug)->first();

        return view('admin.restaurants.intros.intro',compact('lang','breadcrumbs','intro'));
    }

    //update intro
    public function updateIntro($slug, $id, Request $request)
    {
        $requestData = $request->all();
        $validateList = [
            'intro' => 'required',
        ];
        $this->validate($request, $validateList);

        $intro = Restaurant::where('slug',$slug)->findOrFail($id);

        $intro->update($requestData);

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.update_intro'));
        return redirect('admin/'.$slug.'/intro');
    }

    // General Tag info
    public function showTagInfo($slug)
    {
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.tags'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants.breadcrumbs.tag_info')
                ]
            ]
        ];
        $tagInfo = Restaurant::where('slug',$slug)->first();
        $title_brief = explode(", ", $tagInfo->title_brief_en);
        $tags = json_encode(Tag::whereIn('name_en',$title_brief)->pluck("id")->toArray());
        $allTags = Tag::all();

        return view('admin.restaurants.tags.tag_info',compact('lang','breadcrumbs','tags','tagInfo','allTags','title_brief'));
    }

    // edit tag info
    public function updateTagInfo($slug, $id, Request $request)
    {
        $requestData = $request->all();
        $validateList = [
            'tags' => 'required | max:3'
        ];
        $errorList =[
            'tags.required' => 'Please select at least one option',
            'tags.max' => 'You can only choose 3 options',
        ];
        $this->validate($request, $validateList, $errorList);
        $tags = Tag::whereIn('id',$requestData['tags'])->get();
        $title_brief_en='';$title_brief_ja='';
        foreach($tags as $key => $value){
            if($key==0){
                $title_brief_en=$value->name_en;
                $title_brief_ja=$value->name_ja;
            }else{
                $title_brief_en .=", ".$value->name_en;
                $title_brief_ja .=", ".$value->name_ja;
            }
        }

        $requestData['title_brief_en'] = $title_brief_en;
        $requestData['title_brief_ja'] = $title_brief_ja;
        $requestData['tags'] ='';
        $tagInfo = Restaurant::where('slug',$slug)->findOrFail($id);

        $tagInfo->update($requestData);

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.update_tag'));
        return redirect('admin/'.$slug.'/general-info-tags');
    }

    // otp setting
    public function showOtpSetting($slug)
    {
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.otp'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants.breadcrumbs.otp_info')
                ]
            ]
        ];
        $otpSetting = Restaurant::where('slug',$slug)->first();

        return view('admin.restaurants.otp_setting.otp_setting',compact('lang','breadcrumbs','otpSetting'));
    }

    // edit otp info
    public function updateOtpSetting($slug, $id, Request $request)
    {
        $requestData = $request->all();
        $validateList = [
            'otp' => 'required',
            'otp_value' => 'required'
        ];
        $this->validate($request, $validateList);

        $otpSetting = Restaurant::where('slug',$slug)->findOrFail($id);

        $otpSetting->update($requestData);

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.update_otp'));
        return redirect('admin/'.$slug.'/otp-settings');
    }

    public function import() {
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/restaurants'),
                    'text' => __('admin.restaurants.breadcrumbs.restaurants_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants.breadcrumbs.import_restaurants')
                ]
            ]
        ];

        return view('admin.restaurants.import',compact('lang','breadcrumbs'));
    }

    public function importPost(Request $request) {
        $request->validate([
            'file_import' => 'required'
        ]);

        $path = $request->file('file_import')->getRealPath();
        $data = \Excel::selectSheetsByIndex(0)->load($path)->get();

        if($data->count()){
            try {
                foreach ($data as $key => $value) {
                    $province_id = Province::where('name_en',$value->province)->firstOrFail()->id;
                    $district_id = District::where('name_en',$value->district)->where('province_id',$province_id)->firstOrFail()->id;
                    $ward_id = Ward::where('name_en',$value->ward)->where('district_id',$district_id)->firstOrFail()->id;
                    $arr[] = [
                        'name_en' => $value->name,
                        'name_ja' => $value->name,
                        'slug' => str_slug($value->name),
                        'address_en' => $value->address,
                        'address_ja' => $value->address,
                        'province_id' => $province_id,
                        'district_id' => $district_id,
                        'ward_id' => $ward_id,
                        'phone' => $value->phone,
                        'email' => $value->email,
                        'link' => $value->website,
                    ];
                }
            } catch (\Exception $exception) {
                Session::flash('flash_error', trans('admin.restaurants.flash_messages.new_error'));
                return redirect('admin/restaurants/import');
            }

            if(!empty($arr)){
                Restaurant::insert($arr);
            }
        }

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.new'));
        return redirect('admin/restaurants');

    }

    public function exchangeRate($slug) {
        $lang = Session::get('locale');
        $res = Session::get('res');
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.exchange_rate'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants.breadcrumbs.exchange_rate')
                ]
            ]
        ];
        try {
            $settings = Setting::where('restaurant_id', $res->id)->where('key','exchange_rate')->firstOrFail();
        } catch (\Exception $exception) {
            $setting_keys = SettingKey::all();
            foreach ($setting_keys as $key) {
                $arr[] = ['key' => $key->name,'value'=> 23000,'restaurant_id'=> $res->id];
            }
            if(!empty($arr)) {
                Setting::insert($arr);
            }
            $settings = Setting::where('restaurant_id', $res->id)->where('key','exchange_rate')->firstOrFail();
        }

        return view('admin.restaurants.exchange_rate.index',compact('lang','breadcrumbs','settings'));
    }

    public function exchangeRateUpdate($slug,$id,Request $request) {
        $requestData = $request->all();

        $validateList = array(
            'key' => 'required',
            'value' => 'required|numeric'
        );

        $this->validate($request, $validateList);

        try {
            $setting = Setting::findOrFail($id);
        } catch (\Exception $exception) {
            Session::flash('flash_error', trans('admin.restaurants.flash_messages.exchange_rate_error'));
            return redirect('admin/'.$slug.'/exchange-rate');
        }

        $setting->update([
           'value' => $requestData['value']
        ]);

        Session::flash('flash_message', trans('admin.restaurants.flash_messages.exchange_rate'));
        return redirect('admin/'.$slug.'/exchange-rate');
    }
    public function changeStatus($slug, Request $request)
    {

        $item_id = $request->input('item_id');
        $restaurants = Restaurant::findOrFail($item_id);
        $vip_restaurant = $request->input('vip_restaurant');
        $restaurants->vip_restaurant= $vip_restaurant;
        $restaurants->save();
        return response()->json(['error'=>false,'message' => trans('admin.categories.category_status.success'),'vip_restaurant' => $restaurants->vip_restaurant]);
    }

    public function changeStatusRestaurant(Request $request){
        $item_id = $request->input('item_id');
        $restaurant= Restaurant::findOrFail($item_id);

        $active = $request ->input('active');
        $restaurant->active = $active;

        $restaurant->save();

        return response()->json(['error'=>false,'message' => trans('admin.restaurants.restaurant_status.success'),'active' => $restaurant->active]);
    }

    public function updateSequence(Request $request)
    {
        $resIds = $request->get('resIds');
        foreach ($resIds as $key=>$resId){
            Restaurant::where('id',$resId)->update(['vip_restaurant'=> $key+1]);
        }
        return response()->json('updated', 200);
    }

    public function showPaymentSetting($slug) {
        $lang = Session::get('locale');
        $res = Session::get('res');
        $breadcrumbs = [
            'title' => __('admin.restaurants.breadcrumbs.payment'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants.breadcrumbs.payment_info')
                ]
            ]
        ];
        $detailInfo = Restaurant::where('slug',$slug)->first();
        //get paypal setting
        $paypalSetting = Setting::join('setting_keys','settings.key','=','setting_keys.name')
        ->where('setting_keys.name',config('constants.PAYPAL') )
        ->where('settings.restaurant_id',$res->id)->first();
        $paypalSettingValue=0;
        if(!empty($paypalSetting)){
            if($paypalSetting->value>0)
                $paypalSettingValue = $paypalSetting->value;
        }

        //get paypal setting
        $nganLuongSetting = Setting::join('setting_keys','settings.key','=','setting_keys.name')
        ->where('setting_keys.name',config('constants.NGAN_LUONG'))
        ->where('settings.restaurant_id',$res->id)->first();
        $nganLuongSettingValue=0;
        if(!empty($nganLuongSetting)){
            if($nganLuongSetting->value>0)
                $nganLuongSettingValue = $nganLuongSetting->value;
        }
        return view('admin.restaurants.payment_setting.payment_setting',compact('lang','breadcrumbs','detailInfo','paypalSettingValue','nganLuongSettingValue'));
    }

    public function savePaymentSetting($slug, $id, Request $request) {
        $requestData = $request->all();
        $this->validation('restaurants', $request, [
            'online_payment' => 'integer|boolean|required_without:cod_payment',
            'cod_payment' => 'integer|boolean|required_without:online_payment'
        ]);
        if(!empty($requestData['online_payment']) && $requestData['online_payment']==1){
            $this->validation('restaurants', $request, [
                'paypalSettingValue' => 'integer|boolean|required_without:nganLuongSettingValue',
                'nganLuongSettingValue' => 'integer|boolean|required_without:paypalSettingValue'
            ]);
        }
        try {
            $restaurant = Restaurant::findOrFail($id);
            $requestData['online_payment'] = isset($requestData['online_payment']) ? true : false;
            $requestData['cod_payment'] = isset($requestData['cod_payment']) ? true : false;
            $restaurant->update($requestData);

            $settingPaypal = Setting::where("restaurant_id",$restaurant->id)
                            ->where("key",config('constants.PAYPAL'))->first();

            if(!empty($settingPaypal)){
                $settingPaypal->update([
                    'value' => isset($requestData['paypalSettingValue'])?true:false
                ]);
            }else{
                $data = [];
                $data['key'] = config('constants.PAYPAL');
                $data['value'] = isset($requestData['paypalSettingValue'])?true:false;
                $data['restaurant_id'] = $id;
                Setting::create($data);
            }

            $settingNganLuong = Setting::where("restaurant_id",$restaurant->id)
                            ->where("key",config('constants.NGAN_LUONG'))->first();

            if(!empty($settingNganLuong)){
                $settingNganLuong->update([
                    'value' => isset($requestData['nganLuongSettingValue'])?true:false
                ]);
            }else{
                $data = [];
                $data['key'] = config('constants.NGAN_LUONG');
                $data['value'] = isset($requestData['nganLuongSettingValue'])?true:false;
                $data['restaurant_id'] = $id;
                Setting::create($data);
            }


        } catch (\Exception $exception) {
            Session::flash('flash_error', "Cannot change setting");
            return redirect('admin/'.$slug.'/payment-settings');
        }

        Session::flash('flash_message', 'Change setting success');
        return redirect('admin/'.$slug.'/payment-settings');
    }

}
