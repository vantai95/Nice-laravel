<?php

namespace App\Http\Controllers\Admin;

use App\Models\TimeBasePricingAffect;
use App\Models\TimeBasePricingRule;
use App\Models\DishCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CommonService;
use Session,Auth,Route,DB;
use App\Models\Dish,App\Models\Restaurant
,App\Models\Category,App\Models\Customization,App\Models\DishCustomization
,App\Models\TimeBaseDisplayAffect;

class DishesController extends BelongToResController
{

    CONST default_index = 'dish';
    CONST required_method = ['edit','update','destroy','duplicateDishes','dishTBPs','dishTBDs','dishCustomizations'];
    CONST model = Dish::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$slug)
    {
        $lang = Session::get('locale');
        $this->restaurant = Session::get('res');

        $breadcrumbs = [
            'title' => __('admin.dishes.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'. $slug .'/dishes'),
                    'text' => __('admin.dishes.breadcrumbs.dishes_index')
                ]
            ]
        ];
//        session(['mainPage' => $request->fullUrl()]);
        $categories = Category::where('restaurant_id','=',$this->restaurant->id)->get();
        $keyword = $request->get('q');
        if($request->get('category_id')==null && count($categories)==0){
            Session::flash('flash_error', 'Please create a category first');
            return redirect('admin/'.$this->restaurant->res_Slug.'/categories');
        }
        $category_id = ($request->get('category_id')!= null && $request->get('category_id') != "" )? $request->get('category_id'): 'All';
        $status = $request->get('status');
        if($request->get('per_page') > 0){
            Session::put('perPage',$request->get('per_page'));
        }
        $perPage = Session::get('perPage') ? Session::get('perPage'):config('constants.PAGE_SIZE');
        $dishes = Dish::join('dishes_categories', 'dishes.id', 'dishes_categories.dish_id')
            ->join('categories','categories.id','dishes_categories.category_id')
            ->select('dishes.*', 'dishes_categories.category_id','dishes_categories.dish_id','dishes_categories.sequence as dish_sequence',"categories.title_en as cat_name")
            ->orderBy('dish_sequence','asc');

//        if(!empty($category_id)) {
//            $dishes = $dishes->where('dishes_categories.category_id',$category_id)
//                ->orderBy('dishes.id', 'desc');
//        }
//        else {
//            $dishes = $dishes->whereNull('deleted_at')
//                ->orderBy('dishes.id', 'desc');
//        }

        if (!empty($status)) {
            if ($status == Dish::STATUS_FILTER['inactive']) {
                $dishes = $dishes->where('dishes.active', '=', false);
            } elseif ($status == Dish::STATUS_FILTER['active']) {
                $dishes = $dishes->where('dishes.active', '=', true);
            }
        }
        if(!empty($keyword)){
            $keyword = CommonService::correctSearchKeyword($keyword);
            $dishes = $dishes->where(function($query) use ($keyword){
                $query->orWhere("dishes.name_en",'like',$keyword);
                $query->orWhere("dishes.name_ja",'like',$keyword);
            });
        }

        if ($category_id != 'All') {
            if(!empty($category_id)){
                $dishes = $dishes->where(function($query) use ($category_id){
                    $query->orWhere("dishes_categories.category_id",'=',$category_id);
                });
            }
        }
        $restaurantId = $this->restaurant->id;
        $dishes = $dishes->where(function ($query) use ($restaurantId) {
            $query->where("dishes.restaurant_id", '=',$restaurantId);
        });

        if(!empty($dishes)){
            $dishes = $dishes->paginate($perPage);
        }

        $currentURL = urlencode($request->fullUrl());

        return view('admin.dishes.index',compact('dishes','breadcrumbs','status','categories','category_id','lang', 'currentURL'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$slug)
    {
        $this->restaurant = Session::get('res');

        $breadcrumbs = [
            'title' => __('admin.dishes.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'. $slug .'/dishes'),
                    'text' => __('admin.dishes.breadcrumbs.dishes_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.dishes.breadcrumbs.new_dish')
                ]
            ]
        ];

        $backUrl = url('admin/'.$this->restaurant->res_Slug.'/dishes');
        if(request()->has('back_url')) {
            $backUrl = request()->query('back_url');
        }
        $categories = Category::where('restaurant_id','=',$this->restaurant->id)->get();
        return view('admin.dishes.create',compact('breadcrumbs','categories', 'backUrl'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$slug)
    {
        $this->restaurant = Session::get('res');
        $requestData = $request->except('customizations','tbds');
        $resId = $this->restaurant->id;
        
        $this->validate($request,[
            'name_en' => "required|unique:dishes,name_en,null,null,restaurant_id,$resId",
            'name_ja' => "unique:dishes,name_ja,null,null,restaurant_id,$resId",
            'categories' => 'required',
            'price'=> 'required'
        ]);
        
        $this->restaurant = Session::get('res');

        $requestData = $request->except('customizations','tbds','categories');
        $requestData_customizations = $request->input('customizations');
        $requestData_tbds = $request->input('tbds');
        $requestData_tbps = $request->input('tbps');
        $requestData_categories = $request->input('categories');
        $requestData['name_ja'] = !empty($request->get('name_ja')) ? $request->get('name_ja') : $request->get('name_en');
        $requestData['description_en'] = strip_tags($requestData['description_en']);
        $requestData['description_ja'] = !empty($request->get('description_ja')) ?  strip_tags($request->get('description_ja')) : strip_tags($request->get('description_en'));
        $requestData['restaurant_id'] = $this->restaurant->id;

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        if(!isset($requestData['slug'])){
            $requestData['slug'] = '';
        }

        if (is_null($requestData['image'])) {
            $requestData['image'] = '';
        }

        $id = Dish::create($requestData)->id;
        if(isset($requestData_categories)){
            $cat_data = [];
            foreach($requestData_categories as $key=>$value){
                $maxSequence = DishCategory::where('category_id', '=', $value )->max('sequence');
                $cat_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$this->restaurant->id,
                    'category_id'=>$value,
                    'dish_id'=>$id,
                    'sequence' => $maxSequence + 1
                ];
                array_push($cat_data,$cat_row);

            }
            DishCategory::insert($cat_data);
        }

        if(isset($requestData_customizations)){
            $customizations_data = [];
            foreach($requestData_customizations as $key=>$value){
                $customizations_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$this->restaurant->id,
                    'customization_id'=>$key,
                    'dish_id'=>$id,
                ];
                array_push($customizations_data,$customizations_row);
            }
            DishCustomization::insert($customizations_data);
        }
        if(isset($requestData_tbds)){   
            $tbds_data = [];               
            foreach($requestData_tbds as $key=>$value){
                $tbds_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$this->restaurant->id,
                    'rule_id' => $key,
                    'category_id' => null,
                    'dish_id'=>$id
                ];
                array_push($tbds_data,$tbds_row);
            }   
            
            TimeBaseDisplayAffect::insert($tbds_data);                
        }
        if(isset($requestData_tbps)){
            $tbps_data = [];
            foreach($requestData_tbps as $key=>$value){
                $tbps_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$this->restaurant->id,
                    'rule_id' => $key,
                    'dish_id'=>$id
                ];
                array_push($tbps_data,$tbps_row);
            }
            TimeBasePricingAffect::insert($tbps_data);
        }

        Session::flash('flash_message', trans('admin.dishes.flash_messages.new'));

        return redirect('admin/'.$this->restaurant->res_Slug.'/dishes');
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
    public function edit($slug,$id)
    {
        $this->restaurant = Session::get('res');
        $breadcrumbs = [    
            'title' => __('admin.dishes.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'. $slug .'/dishes'),
                    'text' => __('admin.dishes.breadcrumbs.dishes_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.dishes.breadcrumbs.edit_dish')
                ]
            ]
        ];

        $dish = Dish::findOrFail($id);
        $backUrl = url('admin/'.$this->restaurant->res_Slug.'/dishes');
        if(request()->has('back_url')) {
            $backUrl = request()->query('back_url');
        }

        $categories = Category::select('title_en','id')->where('restaurant_id','=',$dish->restaurant_id)->get();
        return view('admin.dishes.edit',compact('breadcrumbs','dish', 'categories', 'backUrl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug, $id)
    {
        $this->restaurant = Session::get('res');
        $resId = $this->restaurant->id;

        $this->validate($request,[
            'name_en' => "required|unique:dishes,name_en,$id,id,restaurant_id,$resId",
            'name_ja' => "unique:dishes,name_ja,$id,id,restaurant_id,$resId",
            'categories' => 'required',
            'price'=> 'required'
        ]);

        $dish = Dish::findOrFail($id);

        $requestData = $request->except('customizations','tbds');
        $requestData_customizations = $request->input('customizations');
        $requestData_tbds = $request->input('tbds');
        $requestData_tbps = $request->input('tbps'); 
        $requestData_categories = $request->input('categories');
        $requestData['name_ja'] = !empty($request->get('name_ja')) ? $request->get('name_ja') : $request->get('name_en');
        $requestData['description_en'] = strip_tags($requestData['description_en']);
        $requestData['description_ja'] = !empty($request->get('description_ja')) ?  strip_tags($request->get('description_ja')) : strip_tags($request->get('description_en'));

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        if (is_null($requestData['image'])) {
            $requestData['image'] = '';
        }
        $dish->update($requestData);
        
        DishCustomization::where('restaurant_id','=', $this->restaurant->id)
        ->where('dish_id','=',$id)->delete();
        TimeBaseDisplayAffect::where('restaurant_id','=', $this->restaurant->id)
        ->where('dish_id','=',$id)->delete();
        TimeBasePricingAffect::where('restaurant_id','=', $this->restaurant->id)
        ->where('dish_id','=',$id)->delete();
        DishCategory::where('restaurant_id','=', $this->restaurant->id)
        ->where('dish_id','=',$id)->delete();

        if(isset($requestData_categories)){
            $cat_data = [];
            foreach($requestData_categories as $key=>$value){
                $maxSequence = DishCategory::where('category_id', '=', $value )->max('sequence');
                $cat_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$this->restaurant->id,
                    'category_id'=>$value,
                    'dish_id'=>$id,
                    'sequence' => $maxSequence + 1
                ];
                array_push($cat_data,$cat_row);
            }
            DishCategory::insert($cat_data);
        }

        if(isset($requestData_customizations)){
            $customizations_data = [];
            foreach($requestData_customizations as $key=>$value){
                $customizations_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=> $this->restaurant->id,
                    'customization_id'=>$key,
                    'dish_id'=>$id
                ];
                array_push($customizations_data,$customizations_row);
            }
            DishCustomization::insert($customizations_data);
        }

        if(isset($requestData_tbds)){
            $tbds_data = [];
            foreach($requestData_tbds as $key=>$value){
                $tbds_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$this->restaurant->id,
                    'rule_id' => $key,
                    'category_id' => null,
                    'dish_id'=>$id
                ];
                array_push($tbds_data,$tbds_row);
            }
            TimeBaseDisplayAffect::insert($tbds_data);
        }

        if(isset($requestData_tbps)){
            $tbps_data = [];
            foreach($requestData_tbps as $key=>$value){
                $tbps_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$this->restaurant->id,
                    'rule_id' => $key,
                    'dish_id'=>$id
                ];
                array_push($tbps_data,$tbps_row);
            }
            TimeBasePricingAffect::insert($tbps_data);
        }

        $backUrl = $requestData['back_url'];

        Session::flash('flash_message', trans('admin.dishes.flash_messages.update'));
        //return redirect('admin/'.$this->restaurant->res_Slug.'/dishes');
        return redirect($backUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $id)
    {
        $dish = Dish::findOrFail($id);
        $dish->delete();
        Session::flash('flash_message', trans('admin.dishes.flash_messages.destroy'));
        return redirect()->back();
    }

    public function dishCustomizations($slug, $dish_id){
        $dish = Dish::find($dish_id);
        $customizations = $dish->customizationList();
        return response()->json(['data'=>$customizations]);
    }

    public function dishTBDs($slug, $dish_id){
        $dish = Dish::find($dish_id);
        $tbd = $dish->timeBaseRuleList();
        return response()->json(['data'=>$tbd]);
    }

    public function dishTBPs($slug, $dish_id){
        $dish = Dish::find($dish_id);
        $tbp = $dish->timeBasePricingRuleList();
        return response()->json(['data'=>$tbp]);
    }

    public function duplicateDishes($slug,$id){
        $dish = Dish::findOrFail($id);

        $newDish = $dish->replicate();
        $newDish->name_en = $newDish->name_en . " Copy " . rand(1000, 9999);
        $newDish->name_ja = $newDish->name_ja . " Copy " . rand(1000, 9999);

        $cusData = $dish->customization;
        $tbdData = $dish->timeBaseDisplayRule;
        $tbpData = $dish->timeBasePricingRule;
//        $category = $dish->category;
        $dishCategorys = $dish->dishCategory;

        $newDish->save();

//        if(!empty($category)){
//            $categoryData = [];
//            foreach($category as $value){
//                $category_row = [
//                    'created_at'=>date('Y-m-d h:i:s'),
//                    'updated_at'=>date('Y-m-d h:i:s'),
//                    'restaurant_id'=>$dish->restaurant_id,
//                    'category_id'=>$value->id,
//                    'dish_id'=> $newDish->id,
//                    'sequence'=>$value->sequence,
//                ];
//                array_push($categoryData,$category_row);
//            }
//            DishCategory::insert($categoryData);
//        }

        if(!empty($dishCategorys)) {
            $dishCategoryDatas = [];
            foreach($dishCategorys as $dishCategory) {
                $dishCategoryInfo = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$dish->restaurant_id,
                    'dish_id'=> $newDish->id,
                    'category_id'=>$dishCategory->category_id,
                    'sequence'=>$dishCategory->sequence,
                ];
                array_push($dishCategoryDatas,$dishCategoryInfo);
            }
            DishCategory::insert($dishCategoryDatas);
        }

        if(!empty($tbpData)){
            $timeBasePricingData = [];
            foreach($tbpData as $value){
                $tbps_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$dish->restaurant_id,
                    'rule_id'=>$value->id,
                    'dish_id'=> $newDish->id,
                ];
                array_push($timeBasePricingData,$tbps_row);
            }
            TimeBasePricingAffect::insert($timeBasePricingData);
        }

        if(!empty($tbdData)){
            $timeBaseDisplayData = [];
            foreach($tbdData as $value){
                $tbds_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$dish->restaurant_id,
                    'rule_id' => $value->id,
                    'category_id' => null,
                    'dish_id'=>$newDish->id,
                ];
                array_push($timeBaseDisplayData,$tbds_row);
            }
            TimeBaseDisplayAffect::insert($timeBaseDisplayData);
        }

        if(!empty($cusData)){
            $customizationData = [];
            foreach($cusData as $value){
                $customization_row = [
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'restaurant_id'=>$dish->restaurant_id,
                    'customization_id' => $value->id,
                    'dish_id'=>$newDish->id
                ];
                array_push($customizationData,$customization_row);
            }
            DishCustomization::insert($customizationData);
        }

        Session::flash('flash_message', trans('admin.dishes.flash_messages.duplicate'));
        return redirect('admin/'.$slug .'/dishes');
    }

    public function changeStatusDish($slug, Request $request){
        //Get dish by id
        $item_id = $request->input('item_id');
        $dishes= Dish::findOrFail($item_id);
        //Change dish status
        $active = $request ->input('active');
        $dishes->active = $active;
        $dishes->save();
        //Return response
        return response()->json(['error'=>false,'message' => trans('admin.dishes.dish_status.success'),'active' => $dishes->active]);
    }

    public function updateSequence(Request $request)
    {
        $dishIds = $request->get('dishIds');
        foreach ($dishIds as $key=>$dishId){
            DishCategory::where('dish_id',$dishId)->where('category_id', $request->get('cateId'))->update(['sequence'=> $key+1]);
        }
        return response()->json('updated', 200);
    }

}
