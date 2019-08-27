<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryCustomization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Dish;
use App\Models\DishCategory;
use App\Models\Restaurant;
use App\Services\CommonService;
use Session, Log, Route;
use App\Models\TimeBaseDisplayAffect;
use Storage;

class CategoriesController extends BelongToResController
{
    CONST default_index = 'category';
    CONST required_method = [
        'edit',
        'update',
        'destroy',
        'categoryCustomizations',
        'duplicateCategories',
        'categoryTBDs'
    ];
    CONST model = Category::class;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     * @internal param Request $request
     */
    public function index(Request $request)
    {
        $this->restaurant = Session::get('res');
        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $this->restaurant['slug'] . '/categories'),
                    'text' => __('admin.categories.breadcrumbs.category_index')
                ]
            ]
        ];
        $links = [
            'list' => url('admin/' . $this->restaurant['slug'] . '/categories'),
            'create' => url('admin/' . $this->restaurant['slug'] . '/categories/create')
        ];
//        session(['mainPage' => $request->fullUrl()]);
        $keyword = $request->get('q');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $categories = Category::where('categories.restaurant_id', $this->restaurant['id'])->orderBy('sequence', 'asc');
        if (!empty($status)) {
            if ($status == Category::STATUS_FILTER['inactive']) {
                $categories = $categories->where('active', '=', false);
            } elseif ($status == Category::STATUS_FILTER['active']) {
                $categories = $categories->where('active', '=', true);
            }
        }
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $categories = $categories->where(function ($query) use ($keyword) {

                $query->orWhere('title_en', 'LIKE', $keyword);
//                $query->orWhere('title_vi', 'LIKE', $keyword);
                $query->orWhere('title_ja', 'LIKE', $keyword);
            });
        }
        $categories = $categories->get();
        $currentURL = urlencode($request->fullUrl());

        return view('admin.categories.index', compact('categories', 'status', 'breadcrumbs', 'links', 'currentURL'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->restaurant = Session::get('res');

        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $this->restaurant['slug'] . '/categories'),
                    'text' => __('admin.categories.breadcrumbs.category_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.categories.breadcrumbs.add_category')
                ]
            ]
        ];
        $restaurants = Restaurant::get();
        $backUrl = url('admin/' . $this->restaurant->res_Slug . '/categories');
        if (request()->has('back_url')) {
            $backUrl = request()->query('back_url');
        }
        $dishes = Dish::where('dishes.restaurant_id',
            $this->restaurant['id'])->whereNull('deleted_at')->orderBy('dishes.name_en', 'asc')->get();
        return view('admin.categories.create', compact('breadcrumbs', 'restaurants', 'dishes', 'backUrl'));
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
        $this->restaurant = Session::get('res');
        $resId = $this->restaurant->id;
        $this->validate($request, [
            'title_en' => "required|unique:categories,title_en,null,null,restaurant_id,$resId",
            'title_ja' => "unique:categories,title_ja,null,null,restaurant_id,$resId",
        ]);
        $requestData = $request->all();
        $requestData_tbds = $request->input('tbds');
        $requestData_customizations = $request->input('customizations');
        $requestData_dished = $request->input('dished');
        $requestData['title_ja'] = !empty($request->get('title_ja')) ? $request->get('title_ja') : $request->get('title_en');

        $categorySequence = Category::where('restaurant_id', $resId)->orderBy('sequence', 'desc')->first();
        if (!empty($categorySequence)) {
            $requestData['sequence'] = $categorySequence->sequence + 1;
        } else {
            $requestData['sequence'] = 1;
        }
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        if (is_null($requestData['image'])) {
            $requestData['image'] = '';
        }

        $this->restaurant = Session::get('res');
        $requestData['restaurant_id'] = $this->restaurant->id;
        $id = Category::create($requestData)->id;

        if (isset($requestData_customizations)) {
            $customizations_data = [];
            foreach ($requestData_customizations as $key => $value) {
                $customizations_row = [
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'restaurant_id' => $this->restaurant->id,
                    'customization_id' => $key,
                    'category_id' => $id,
                ];
                array_push($customizations_data, $customizations_row);
            }
            CategoryCustomization::insert($customizations_data);
        }
        if (isset($requestData_tbds)) {
            $tbds_data = [];
            foreach ($requestData_tbds as $key => $value) {
                $tbds_row = [
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'restaurant_id' => $this->restaurant->id,
                    'rule_id' => $key,
                    'category_id' => $id
                ];
                array_push($tbds_data, $tbds_row);
            }
            TimeBaseDisplayAffect::insert($tbds_data);
        }
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
        Session::flash('flash_message', trans('admin.categories.flash_messages.new'));
        return redirect('admin/' . $this->restaurant['slug'] . '/categories');
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
        $this->restaurant = Session::get('res');

        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/' . $this->restaurant['slug'] . '/categories'),
                    'text' => __('admin.categories.breadcrumbs.category_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.categories.breadcrumbs.edit_category')
                ]
            ]
        ];
        $category = Category::findOrFail($id);
        $restaurants = Restaurant::get();
        $backUrl = url('admin/' . $this->restaurant->res_Slug . '/categories');
        if (request()->has('back_url')) {
            $backUrl = request()->query('back_url');
        }
        $dishes = Dish::where('dishes.restaurant_id',
            $this->restaurant['id'])->whereNull('deleted_at')->orderBy('dishes.name_en', 'asc')->get();

        return view('admin.categories.edit', compact('category', 'breadcrumbs', 'restaurants', 'dishes', 'backUrl'));
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
//                $categories = Category::select()->get();
//                $result = $this->batchDuplicate($categories);
//                if($result) {
//                    Session::flash('flash_message', trans('admin.categories.flash_messages.duplicate_success'));
//                } else {
//                    Session::flash('flash_message', trans('admin.categories.flash_messages.duplicate_error'));
//                }
//            } else {
//                if(isset($requestData['idx'])) {
//                    $list = explode(',',$requestData['idx']);
//                    $categories = Category::whereIn('id',$list)->get();
//                    $result = $this->batchDuplicate($categories);
//                    if($result) {
//                        Session::flash('flash_message', trans('admin.categories.flash_messages.duplicate_success'));
//                    } else {
//                        Session::flash('flash_message', trans('admin.categories.flash_messages.duplicate_error'));
//                    }
//                }
//            }
//        }
//        if($requestData['action'] == 'delete') {
//            Session::flash('flash_message', trans('admin.categories.flash_messages.delete_coming_soon'));
//        }
//        return redirect('admin/'.$slug.'/categories');
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $slug, $id)
    {
        $this->restaurant = Session::get('res');

        $resId = $this->restaurant->id;
        $this->validate($request, [
            'title_en' => "required|unique:categories,title_en,$id,id,restaurant_id,$resId",
            'title_ja' => "unique:categories,title_ja,$id,id,restaurant_id,$resId"
        ]);
        $requestData = $request->all();
        $requestData_tbds = $request->input('tbds');
        $requestData_customizations = $request->input('customizations');
        $requestData_dishes = $request->input('dished');
        $requestData['title_ja'] = !empty($request->get('title_ja')) ? $request->get('title_ja') : $request->get('title_en');
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        $category = Category::findOrFail($id);

        if (is_null($requestData['image'])) {
            $requestData['image'] = '';
        }

        $category->update($requestData);

        DishCategory::where('restaurant_id', '=', $this->restaurant->id)
            ->where('category_id', '=', $id)->delete();
        CategoryCustomization::where('restaurant_id', '=', $this->restaurant->id)
            ->where('category_id', '=', $id)->delete();
        TimeBaseDisplayAffect::where('restaurant_id', '=', $this->restaurant->id)
            ->where('category_id', '=', $id)->whereNull('dish_id')->delete();

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
        if (isset($requestData_customizations)) {
            $customizations_data = [];
            foreach ($requestData_customizations as $key => $value) {
                $customizations_row = [
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'restaurant_id' => $this->restaurant->id,
                    'customization_id' => $key,
                    'category_id' => $id,
                ];
                array_push($customizations_data, $customizations_row);
            }
            CategoryCustomization::insert($customizations_data);
        }
        if (isset($requestData_tbds)) {
            $tbds_data = [];
            foreach ($requestData_tbds as $key => $value) {
                $tbds_row = [
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'restaurant_id' => $this->restaurant->id,
                    'rule_id' => $key,
                    'category_id' => $id
                ];
                array_push($tbds_data, $tbds_row);
            }
            TimeBaseDisplayAffect::insert($tbds_data);
        }
        $backUrl = $requestData['back_url'];

        Session::flash('flash_message', trans('admin.categories.flash_messages.update'));
//        return redirect('admin/' . $this->restaurant['slug'] . '/categories');
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
        $category = Category::findOrFail($id);
        $category->delete();
        Session::flash('flash_message', trans('admin.categories.flash_messages.destroy'));
        return redirect()->back();
    }

    public function categoryTBDs($slug, $id)
    {
        $category = Category::find($id);
        $tbd = $category->timeBaseRuleList();
        return response()->json(['data' => $tbd]);
    }

//    protected function batchDuplicate($categories = array()) {
//        if(empty($categories)) return false;
//        \DB::beginTransaction();
//        try {
//            foreach ($categories as $key => $category) {
//                $new_category = Category::findOrFail($category->id)->replicate();
//                $new_category->save();
//            }
//            \DB::commit();
//            $is_success = true;
//        } catch (\Exception $e) {
//            \DB::rollback();
//            $is_success = false;
//        }
//        return $is_success;
//    }

    public function duplicateCategories($slug, $id)
    {
        $this->restaurant = Session::get('res');

        $cat = Category::findOrFail($id);

        $newCat = $cat->replicate();

        $newCat->title_en = $newCat->title_en . " Copy " . rand(1000, 9999);
        $newCat->title_ja = $newCat->title_ja . " Copy " . rand(1000, 9999);
        $newCat->sequence = $newCat->sequence + 1;

        $cusData = $cat->customization;
        $tbdData = $cat->timeBaseDisplayRule;
        $dishData = $cat->dish;

        $newCat->save();

        if (!empty($dishData)) {
            $dishesData = [];
            foreach ($dishData as $value) {
                $ds_row = [
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'restaurant_id' => $cat->restaurant_id,
                    'category_id' => $newCat->id,
                    'dish_id' => $value->id,
                ];
                array_push($dishesData, $ds_row);
            }
            DishCategory::insert($dishesData);
        }

        if (!empty($tbdData)) {
            $timeBaseDisplayData = [];
            foreach ($tbdData as $value) {
                $tbds_row = [
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'restaurant_id' => $cat->restaurant_id,
                    'rule_id' => $value->id,
                    'category_id' => $newCat->id,
                    'dish_id' => null,
                ];
                array_push($timeBaseDisplayData, $tbds_row);
            }
            TimeBaseDisplayAffect::insert($timeBaseDisplayData);
        }

        if (!empty($cusData)) {
            $customizationData = [];
            foreach ($cusData as $value) {
                $customization_row = [
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'restaurant_id' => $cat->restaurant_id,
                    'customization_id' => $value->id,
                    'category_id' => $newCat->id
                ];
                array_push($customizationData, $customization_row);
            }
            CategoryCustomization::insert($customizationData);
        }

        Session::flash('flash_message', trans('admin.dishes.flash_messages.duplicate'));
        return redirect('admin/' . $slug . '/categories');
    }

    public function categoryCustomizations($slug, $id)
    {
        $category = Category::find($id);
        $customizations = $category->customizationList();
        return response()->json(['data' => $customizations]);
    }

    public function changeStatusCategory($slug, Request $request)
    {
        $item_id = $request->input('item_id');
        $categories = Category::findOrFail($item_id);
        $active = $request->input('active');
        $categories->active = $active;
        $categories->save();
        return response()->json([
            'error' => false,
            'message' => trans('admin.categories.category_status.success'),
            'active' => $categories->active
        ]);
    }

    public function upload()
    {
        return;
    }

    public function updateSequence(Request $request)
    {
        $cateIds = $request->get('cateIds');
        foreach ($cateIds as $key => $cateId) {
            Category::where('id', $cateId)->update(['sequence' => $key + 1]);
        }
        return response()->json('updated', 200);
    }
}
