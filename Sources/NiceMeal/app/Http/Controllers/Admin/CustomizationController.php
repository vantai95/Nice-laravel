<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CommonService;
use Session, Auth, DB;
use App\Models\Customization, App\Models\Restaurant, App\Models\CustomizationOption;
use App\Services\Customization\Admin;

class CustomizationController extends BelongToResController
{
    CONST default_index = 'customization';
    CONST required_method = ['edit','update','destroy','updateOtpSetting','updateTagInfo','updateDetailInfo','duplicateRestaurant','duplicateCustomization'];
    CONST model = Customization::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->restaurant = Session::get('res');
        $breadcrumbs = [
            'title' => __('admin.customizations.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $this->restaurant['slug'] . '/customizations'),
                    'text' => __('admin.customizations.breadcrumbs.customizations_index')
                ]
            ]
        ];
//        session(['mainPage' => $request->fullUrl()]);
        $keyword = $request->get('q');
        $status = $request->get('status');

        $customizations = Customization::select('customizations.*')
            ->orderBy('id', 'DESC');

        if ($request->get('per_page')) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') ? Session::get('perPage') : config('constants.PAGE_SIZE');

        if (!empty($status)) {
            if ($status == Customization::STATUS_FILTER['inactive']) {
                $customizations = $customizations->where('active', '=', false);
            } elseif ($status == Customization::STATUS_FILTER['active']) {
                $customizations = $customizations->where('active', '=', true);
            }
        }
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $customizations = $customizations->where(function ($query) use ($keyword) {
                $query->orWhere("customizations.name_en", 'like', $keyword);
                $query->orWhere("customizations.name_ja", 'like', $keyword);
            });
        }

        $restaurantId = $this->restaurant->id;
        $customizations = $customizations->where(function ($query) use ($restaurantId) {
            $query->where("customizations.restaurant_id", '=', $restaurantId);
        });
        $currentURL = urlencode($request->fullUrl());
        $customizations = $customizations->paginate($perPage);
        return view('admin.customizations.index', compact('breadcrumbs', 'status', 'customizations', 'currentURL'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->restaurant = Session::get('res');

        $breadcrumbs = [
            'title' => __('admin.customizations.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $this->restaurant['slug'] . '/customizations'),
                    'text' => __('admin.customizations.breadcrumbs.customizations_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.customizations.breadcrumbs.new_customization')
                ]
            ]
        ];

        $restaurants = Restaurant::all();
        $backUrl = url('admin/'.$this->restaurant->res_Slug.'/customizations');
        if(request()->has('back_url')) {
            $backUrl = request()->query('back_url');
        }

        return view('admin.customizations.create', compact('breadcrumbs', 'restaurants', 'backUrl'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $this->restaurant = Session::get('res');
        $resId = $this->restaurant->id;
        if($request->ajax()){
            if($this->checkDuplicateCreate($request)){
                return response()->json(['error'=> true,'message' => 'Name has been taken']);
            }
        }else{
            $this->validate($request, [
                'name_en' => "required|unique:customizations,name_en,null,null,restaurant_id,$resId",
                'name_ja' => "unique:customizations,name_ja,null,null,restaurant_id,$resId",
                'selection_type' => 'required',
                'required' => 'required'
            ]);
        }

        $requestData = $request->all();

        Admin\CustomizationService::createCustomization($requestData,$this->restaurant->id);



        if (isset($requestData['request_type']) && $requestData['request_type'] == 'ajax') {
            return response()->json(['error' => false]);
        } else {
            Session::flash('flash_message', trans('admin.customizations.flash_messages.new'));
            return redirect('admin/' . $slug . '/customizations');
        }

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
    public function edit($slug, $id)
    {
        $this->restaurant = Session::get('res');

        $breadcrumbs = [
            'title' => __('admin.customizations.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $this->restaurant['slug'] . '/customizations'),
                    'text' => __('admin.customizations.breadcrumbs.customizations_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.customizations.breadcrumbs.edit_customization')
                ]
            ]
        ];
        $option = CustomizationOption::where('customization_id', '=', $id)->where('restaurant_id','=',$this->restaurant->id)->get();
        $customization = Customization::findOrFail($id);
        $backUrl = url('admin/'.$this->restaurant->res_Slug.'/customizations');
        if(request()->has('back_url')) {
            $backUrl = request()->query('back_url');
        }
        return view('admin.customizations.edit', compact('breadcrumbs', 'customization', 'option', 'backUrl'));
    }

    public function getCustomization($restaurant_slug)
    {

        $this->restaurant = Session::get('res');

        $customization = $this->restaurant->getCustomizationList();
        return response()->json(['data' => $customization]);
    }

    public function getGroupCustomization($restaurant_slug)
    {

        $this->restaurant = Session::get('res');

        $customization = $this->restaurant->getGroupCustomization();
        return response()->json(['data' => $customization]);
    }

    public function getOptions($slug, $customization_id)
    {

        $options = Admin\OptionService::getOption($customization_id);
        return response()->json(['data' => $options]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug, $id)
    {
        //
        $this->restaurant = Session::get('res');
        $resId = $this->restaurant->id;
        if($request->ajax()){
            if($this->checkDuplicate($request,$id)){
                return response()->json(['error'=> true,'message' => 'Name has been exists']);
            }
        }else{
            $this->validate($request, [
                'name_en' => "required|unique:customizations,name_en,$id,id,restaurant_id,$resId",
                'name_ja' => "unique:customizations,name_ja,$id,id,restaurant_id,$resId",
                'selection_type' => 'required',
                'required' => 'required'
            ],[
                'name_en.unique' => "Register - The English name has already been taken.",
                'name_ja.unique' => "Register - The Japanese name has already been taken.",
            ]);
        }

        $customization = Customization::where('id', '=', $id)
            ->where('restaurant_id', '=', $this->restaurant->id)->first();
        $requestData = $request->all();
        Admin\CustomizationService::updateCustomization($requestData,$customization);
        if(!empty($requestData['back_url'])) {
            $backUrl = $requestData['back_url'];
        }

        if (isset($requestData['request_type']) && $requestData['request_type'] == 'ajax') {
            return response()->json(['error' => false]);
        } else {
            Session::flash('flash_message', trans('admin.customizations.flash_messages.update'));
//            return redirect('admin/' . $slug . '/customizations');
            return redirect($backUrl);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $id)
    {
        $customization = Customization::find($id);
        $customization->delete();
        Session::flash('flash_message', trans('admin.customizations.flash_messages.destroy'));
        return redirect()->back();
    }


//    public function validations(Request $request) {
//        $this->validate($request,[
//            'name_en' => "required|unique:dishes,name_en,null,null,restaurant_id,$resId",
//            'name_ja' => "required|unique:dishes,name_ja,null,null,restaurant_id,$resId",
//            'max_quantity'=>'required',
//            'min_quantity'=>'required',
//            'selection_type'=>'required',
//            'required' => 'required'
//        ]);
//    }

    public function changeStatusCustomization($slug, Request $request)
    {
        $item_id = $request->input('item_id');
        $customization = Customization::findOrFail($item_id);
        $active = $request->input('active');
        $customization->active = $active;
        $customization->save();
        return response()->json(['error' => false, 'message' => trans('admin.customizations.customization_status.success'), 'active' => $customization->active]);
    }

    public function checkDuplicate(Request $request,$id)
    {
        $nameEn = $request->input('name_en');
        $nameJa = $request->input('name_ja');
        $this->restaurant = Session::get('res');
        try {
            $customization = Customization::where('restaurant_id', $this->restaurant->id)->where('name_en', $nameEn)->orWhere('name_ja',$nameJa)->firstOrFail();
        } catch (\Exception $exception) {
            return 0;
        }
        return $customization->id != $id ? 1 : 0;
    }

    public function checkDuplicateCreate(Request $request)
    {
        $this->restaurant = Session::get('res');
        $nameEn = $request->input('name_en');
        $nameJa = $request->input('name_ja');
        $isExists = Customization::where('restaurant_id', $this->restaurant->id)
                            ->where(function($q) use($nameEn,$nameJa){
                                $q->where('name_en', $nameEn)
                                ->orWhere('name_ja', $nameJa);
                            })->get();
        return $isExists->count() >= 1 ? 1 : 0;
    }

    public function duplicateCustomization($slug, $id, Request $request)
    {

        $this->restaurant = Session::get('res');
        $requestData = $request->all();
        if(isset($requestData['data'])) {
            $data = $requestData['data'];
        } else {
            $data = '';
        }
        $cus = Customization::findOrFail($id);

        $newCus = $cus->replicate();

        $newCus->name_en = $newCus->name_en . " Copy " . rand(1000, 9999);
        $newCus->name_ja = $newCus->name_ja . " Copy " . rand(1000, 9999);

        $optionData = $cus->options;

        $newCus->save();

        if (!empty($optionData)) {
            $optionDataes = [];
            foreach ($optionData as $value) {
                $optionRow = [
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'restaurant_id' => $cus->restaurant_id,
                    'customization_id' => $newCus->id,
                    'name_en' => $value->name_en,
                    'name_ja' => $value->name_ja,
                    'price' => $value->price,
                    'max_quantity' => $value->max_quantity,
                    'min_quantity' => $value->min_quantity,
                ];
                array_push($optionDataes, $optionRow);
            }
            CustomizationOption::insert($optionDataes);
        }

        if (isset($data[0]['value']) && $data[0]['value'] == 'ajax') {
            return response()->json(['error' => false, 'message' => trans('admin.customizations.customization_status.success')]);
        } else {
            Session::flash('flash_message', trans('admin.dishes.flash_messages.duplicate'));
            return redirect('admin/' . $slug . '/customizations');
        }
    }
}
