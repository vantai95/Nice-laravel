<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Log, Auth;
use App\Models\Dish;
use App\Models\Promotion;
use App\Models\PromotionAvailableTime;
use App\Models\PromotionAffect;
use App\Services\CommonService;
use Carbon\Carbon;
use App\Services\DateTimeHandleService;
use App\Services\TimeSettingService;


class PromotionsController extends BelongToResController
{
    CONST default_index = 'promotion';
    CONST required_method = [
        'edit',
        'update',
        'destroy',
        'duplicatePromotions'
    ];
    CONST model = Promotion::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     *
     * @internal param Request $request
     */
    public function index(Request $request,$slug=NULL)
    {
        // get data from session
        $lang = Session::get('locale');
        $this->restaurant = Session::get('res');

        // set breadcrumbs
        $breadcrumbs = [
            'title' => trans_choice('admin.promotions.breadcrumbs.title', isset($slug)? 1 : 0),
            'links' => [
                [
                    'href' => url('admin/'.(isset($slug) ? $this->restaurant->res_Slug . '/promotions' : 'vouchers')),
                    'text' => trans_choice('admin.promotions.breadcrumbs.promotion_index', isset($slug)? 1 : 0)
                ]
            ]
        ];

        // query all vouchers or all promotions
        isset($slug) ? $promotions = Promotion::where('is_global', 0)->where('restaurant_id', $this->restaurant->id)->select('*', "name_$lang as name")->orderBy('id', 'desc')
        : $promotions = Promotion::where('is_global', 1)->select('*', "name_$lang as name")->orderBy('id', 'desc');

        // get search params
        $keyword = $request->get('q');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        // filter with search params
        if (!empty($status)) {
            if ($status == Promotion::STATUS_FILTER['inactive']) {
                $promotions = $promotions->where('status', '=', false);
            } elseif ($status == Promotion::STATUS_FILTER['active']) {
                $promotions = $promotions->where('status', '=', true);
            }
        }
        if(!empty($keyword)){
            $keyword = CommonService::correctSearchKeyword($keyword);
            $promotions = $promotions->where(function($query) use ($keyword, $lang){
                $query->orWhere("promotions.name_$lang",'like',$keyword);
            });
        }

        // set pagination
        $promotions = $promotions->paginate($perPage);

        // return result
        return view('admin.promotions.index', compact('promotions', 'status', 'breadcrumbs' , 'lang', 'slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($slug=NULL)
    {
        // get data from session
        $lang = Session::get('locale');
        $this->restaurant = Session::get('res');

        // set breadcrumbs
        $breadcrumbs = [
            'title' => trans_choice('admin.promotions.breadcrumbs.title', isset($slug) ? 1 : 0),
            'links' => [
                [
                    'href' => url('admin/' . (isset($slug) ? $this->restaurant->res_Slug . '/promotions' : 'vouchers')),
                    'text' => trans_choice('admin.promotions.breadcrumbs.promotion_index', isset($slug) ? 1 : 0)
                ],
                [
                    'href' => url('#'),
                    'text' => trans_choice('admin.promotions.breadcrumbs.add_promotion', isset($slug) ? 1 : 0)
                ]
            ]
        ];

        // get all promotion statuses
        $statuses = Promotion::STATUS_FILTER;

        // return result
        return view('admin.promotions.create',compact('breadcrumbs', 'statuses', 'lang', 'slug'));
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
        // check whether voucher page or promotion page
        $isVoucher = count(func_get_args())==1;
        if (!$isVoucher) {
            $slug = func_get_args()[1];
        }
        // get restaurant data
        $this->restaurant = Session::get('res');

        // handle request data
        $request->merge([
            'is_global' => isset($slug) ? false : true,
            'status' => $request['status'] ?? 0,
            'created_by' => Auth::id(),
            'value' => CommonService::price2Number($request['value']) ?? NULL,
            'maximun_discount' => CommonService::price2Number($request['maximun_discount']) ?? NULL,
            'max_order_value' => CommonService::price2Number($request['max_order_value']) ?? NULL,
            'min_order_value' => CommonService::price2Number($request['min_order_value']) ?? NULL,
            'item_value_from' => CommonService::price2Number($request['item_value_from']) ?? NULL,
            'item_value_to' => CommonService::price2Number($request['item_value_to']) ?? NULL,
            'free_item' => !empty($request['free_item']) ? implode(',', $request['free_item']) : NULL,
            'from_time' => isset($request['from_time']) ? Carbon::parse($request['from_time'])->format('H:i') : NULL,
            'to_time' => isset($request['to_time']) ? Carbon::parse($request['to_time'])->format('H:i') : NULL,
            'restaurant_id' => isset($slug) ? $this->restaurant->id : NULL,
            'include_request' => $request['include_request'] ?? 0,
        ]);

        // validation
        $validationList = [
            'name_en' => 'required',
            'description_en' => 'required',
            'item_value_to' => 'nullable|integer|gte:item_value_from',
            'max_order_value' => 'nullable|integer|gte:min_order_value',
            'to_time' => 'nullable|after_or_equal:from_time',
        ];

        if($request->get('type') == 0){
            $validationList['value'] = 'required|numeric|min:0|max:100';
        }elseif($request->get('type') == 1){
            $validationList['value'] = 'required';
        }

        $this->validate($request,$validationList);

        $requestData = $request->all();
        $requestData['description_en'] = strip_tags($requestData['description_en']);
        $requestData['description_ja'] = strip_tags($requestData['description_ja']);

        // save promotion data and return this promotion
        $promotion = Promotion::create($requestData);

        // save apply_to items and apply_to categories
        if (isset($requestData['dishes_id'])) {
            foreach ($requestData['dishes_id'] as $dishId) {
                PromotionAffect::create([
                    'restaurant_id' => $this->restaurant->id,
                    'promotion_id' => $promotion->id,
                    'dish_id' => $dishId,
                    'category_id' => Dish::where('id', $dishId)->first()->category
                ]);
            }
        }
        else if (isset($requestData['categories_id'])) {
            foreach ($requestData['categories_id'] as $cateId) {
                PromotionAffect::create([
                    'restaurant_id' => $this->restaurant->id,
                    'promotion_id' => $promotion->id,
                    'dish_id' => NULL,
                    'category_id' => $cateId
                    ]);
                }
            }

        // save available times
        // $availTimeData = [];
        // foreach (PromotionAvailableTime::fields() as $fieldName) {
        //     $availTimeData[$fieldName] = NULL;
        //     foreach($requestData as $key=>$value) {
        //         if ($fieldName == $key) $availTimeData[$fieldName] = $value;
        //         if($requestData['period_type'] == 1){
        //           $date = DateTimeHandleService::formatDate($request->input('special_date'));
        //           $requestData['from_date'] = $date;
        //           $requestData['to_date'] = $date;
        //         }else{
        //           $requestData['from_date'] = null;
        //           $requestData['to_date'] = null;
        //         }
        //     }
        // }
        // $availTimeData['promotion_id'] = $promotion->id;
        // PromotionAvailableTime::create($availTimeData);

        TimeSettingService::createTimeSetting($requestData,$promotion,$this->restaurant);

        // return result
        Session::flash('flash_message', trans_choice('admin.promotions.flash_messages.new', isset($slug) ? 1 : 0));
        return redirect((isset($slug) ? '/admin/' . $this->restaurant->res_Slug . '/promotions': '/admin/vouchers'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $isVoucher = count(func_get_args())==1;
        if ($isVoucher) {
            $slug = NULL;
            $id = func_get_args()[0];
        }
        else {
            $slug = func_get_args()[0];
            $id = func_get_args()[1];
        }

        $lang = Session::get('locale');
        $this->restaurant = Session::get('res');
        $breadcrumbs = [
            'title' => trans_choice('admin.promotions.breadcrumbs.title', isset($slug) ? 1 : 0),
            'links' => [
                [
                    'href' => isset($slug) ? url('admin/' . $this->restaurant->res_Slug . '/promotions') : url('admin/vouchers'),
                    'text' => trans_choice('admin.promotions.breadcrumbs.promotion_index', isset($slug) ? 1 : 0)
                ],
                [
                    'href' => url('#'),
                    'text' => trans_choice('admin.promotions.breadcrumbs.edit_promotion', isset($slug) ? 1 : 0)
                ]
            ]
        ];

        $statuses = Promotion::STATUS_FILTER;
        if ($isVoucher) {
            $promotion = Promotion::with('time_setting.time_setting_details')->findOrFail($id);
        } else {
            $promotion = Promotion::with('time_setting.time_setting_details')->where('restaurant_id', $this->restaurant->id)->findOrFail($id);
            $promotion->dishes_id = PromotionAffect::where('restaurant_id', $this->restaurant->id)->where('promotion_id', $promotion->id)->pluck('dish_id');
            $promotion->categories_id = PromotionAffect::where('restaurant_id', $this->restaurant->id)->where('promotion_id', $promotion->id)->whereNull('dish_id')->pluck('category_id');
        }
        $promotion->free_item = explode(',', $promotion->free_item);
        return view('admin.promotions.edit',compact('promotion', 'breadcrumbs', 'statuses', 'lang', 'slug'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        // check whether voucher page or promotion page
        $isVoucher = count(func_get_args())==2;
        $this->restaurant = Session::get('res');
        if ($isVoucher) {
            $slug = NULL;
            $id = func_get_args()[1];
        }
        else {
            $slug = func_get_args()[1];
            $id = func_get_args()[2];
        }

        // get restaurant data
        $this->restaurant = Session::get('res');

        // find promotion by id
        $promotion = Promotion::with('time_setting.time_setting_details')->findOrFail($id);

        // handle request data
        $request->merge([
            'is_global' => isset($slug) ? false : true,
            'status' => $request['status'] ?? 0,
            'created_by' => Auth::id(),
            'value' => CommonService::price2Number($request['value']) ?? NULL,
            'maximun_discount' => CommonService::price2Number($request['maximun_discount']) ?? NULL,
            'max_order_value' => CommonService::price2Number($request['max_order_value']) ?? NULL,
            'min_order_value' => CommonService::price2Number($request['min_order_value']) ?? NULL,
            'item_value_from' => CommonService::price2Number($request['item_value_from']) ?? NULL,
            'item_value_to' => CommonService::price2Number($request['item_value_to']) ?? NULL,
            'free_item' => !empty($request['free_item']) ? implode(',', $request['free_item']) : NULL,
            'from_time' => isset($request['from_time']) ? Carbon::parse($request['from_time'])->format('H:i') : NULL,
            'to_time' => isset($request['to_time']) ? Carbon::parse($request['to_time'])->format('H:i') : NULL,
            'restaurant_id' => isset($slug) ? $this->restaurant->id : NULL,
            'include_request' => $request['include_request'] ?? 0,
        ]);

        \Log::debug($request);
        // validation
        $validationList = [
            'name_en' => 'required',
            'description_en' => 'required',
            'item_value_to' => 'nullable|integer|gte:item_value_from',
            'max_order_value' => 'nullable|integer|gte:min_order_value',
            'to_time' => 'nullable|after_or_equal:from_time',
        ];

        if($request->get('type') == 0){
            $validationList['value'] = 'required|numeric|min:0|max:100';
        }elseif($request->get('type') == 1){
            $validationList['value'] = 'required';
        }

        $this->validate($request,$validationList);

        $requestData = $request->all();

        // update apply_to items and apply_to categories
        if(isset($slug)) PromotionAffect::where('restaurant_id', $this->restaurant->id)
        ->where('promotion_id', $promotion->id)->delete();
        if (isset($requestData['dishes_id'])) {
            foreach ($requestData['dishes_id'] as $dishId) {
                PromotionAffect::create([
                    'restaurant_id' => $this->restaurant->id,
                    'promotion_id' => $promotion->id,
                    'dish_id' => $dishId,
                    'category_id' => Dish::where('id', $dishId)->first()->category
                ]);
            }
        }
        else if (isset($requestData['categories_id'])) {
            foreach ($requestData['categories_id'] as $cateId) {
                PromotionAffect::create([
                    'restaurant_id' => $this->restaurant->id,
                    'promotion_id' => $promotion->id,
                    'dish_id' => NULL,
                    'category_id' => $cateId
                ]);
            }
        }

        // update promotion data
        $requestData['description_en'] = strip_tags($requestData['description_en']);
        $requestData['description_ja'] = strip_tags($requestData['description_ja']);

        $promotion->update($requestData);

        // update available times
        // $availTimeData = [];
        // foreach (PromotionAvailableTime::fields() as $fieldName) {
        //     $availTimeData[$fieldName] = NULL;
        //     foreach($requestData as $key=>$value) {
        //         if ($fieldName == $key) $availTimeData[$fieldName] = $value;
        //         if($requestData['period_type'] == 1){
        //           $date = DateTimeHandleService::formatDate($request->input('special_date'));
        //           $requestData['from_date'] = $date;
        //           $requestData['to_date'] = $date;
        //         }else{
        //           $requestData['from_date'] = null;
        //           $requestData['to_date'] = null;
        //         }
        //     }
        // }
        // $availTimeData['promotion_id'] = $promotion->id;
        // $availTime = PromotionAvailableTime::where('promotion_id', $promotion->id)->firstOrFail();
        // $availTime->update($availTimeData);
        TimeSettingService::updateTimeSetting($requestData,$promotion->time_setting,$this->restaurant);

        // return result
        Session::flash('flash_message', trans_choice('admin.promotions.flash_messages.update', isset($slug) ? 1 : 0));
        return redirect('admin/'.(isset($slug) ? $this->restaurant->res_Slug.'/promotions' : 'vouchers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        $isVoucher = count(func_get_args())==1;
        if ($isVoucher) {
            $id = func_get_args()[0];
        }
        else {
            $slug = func_get_args()[0];
            $id = func_get_args()[1];
        }

        $this->restaurant = Session::get('res');
        $promotion = Promotion::findOrFail($id);
        isset($slug) ?  PromotionAffect::where('restaurant_id', $this->restaurant->id)
            ->where('promotion_id', $promotion->id)->delete()
            : PromotionAffect::where('promotion_id', $promotion->id)->delete();
        PromotionAvailableTime::where('promotion_id', $promotion->id)->delete();
        $promotion->delete();
        Session::flash('flash_message', trans_choice('admin.promotions.flash_messages.destroy', isset($slug) ? 1 : 0));
        return redirect((isset($slug) ? '/admin/' . $this->restaurant->res_Slug . '/promotions' : '/admin/vouchers'));
    }

    public function upload()
    {
        return;
    }

    public function duplicatePromotions()
    {
        $isVoucher = count(func_get_args())==1;
        if ($isVoucher) {
            $id = func_get_args()[0];
        }
        else {
            $slug = func_get_args()[0];
            $id = func_get_args()[1];
        }

        $this->restaurant = Session::get('res');

        CommonService::duplicateRow('promotions', $id, ['name_en']);

        Session::flash('flash_message', trans_choice('admin.promotions.flash_messages.duplicate', isset($slug) ? 1 : 0));
        return redirect((isset($slug) ? '/admin/' . $this->restaurant->res_Slug . '/promotions' : '/admin/vouchers'));
    }
}
