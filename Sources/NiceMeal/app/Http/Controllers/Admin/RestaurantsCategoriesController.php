<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use App\Services\CommonService;
use Session, Log, Auth;


class RestaurantsCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     * @internal param Request $request
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/restaurants-categories'),
                    'text' => __('admin.restaurants_categories.breadcrumbs.category_index')
                ]
            ]
        ];
        $keyword = $request->get('q');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');
        $categories = Category::join('restaurants_categories','restaurants_categories.category_id','=','categories.id')->orderBy('restaurants_categories.created_at', 'desc');
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
        $categories = $categories->select("categories.*","restaurants_categories.restaurant_id as restaurant_id","restaurants_categories.id as restaurants_categories_id","restaurants_categories.image as restaurants_categories_image")
        ->paginate($perPage);
        return view('admin.restaurants_categories.index', compact('categories', 'status', 'breadcrumbs'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function sequenceIndex(Request $request)
    {
        $categories = Category::orderBy('sequence', 'asc')->get();
        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.layouts.breadcrumbs.change_sequence')
                ]
            ]
        ];
        return view('admin.restaurants_categories.sequence_index', compact('categories', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/categories'),
                    'text' => __('admin.categories.breadcrumbs.category_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.categories.breadcrumbs.add_category')
                ]
            ]
        ];
        $restaurants = Restaurant::orderBy('name_en', 'asc')->get();
        $categories = Category::orderBy('title_en', 'asc')->get();
        return view('admin.restaurants_categories.create', compact('breadcrumbs', 'restaurants','categories'));
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
        if(Auth::user()->isRestaurant()){
            $this->validate($request, [
                'category_id' => 'required',
            ]);
        }
        else{
            $this->validate($request, [
                'restaurant_id' => 'required',
                'category_id' => 'required',
            ]);
        }
        
        $requestData = $request->all();
        if(Auth::user()->isRestaurant()){
            $requestData['restaurant_id'] = Session::get('res')->id;
        }
        $fnData = [];
        $imagesIndex = 0;
        $photoName = '';
        foreach ($requestData as $key => $value)
        {
            //if $key is image_, add image
            if (strpos($key, 'image_') !== false) {
                $base64_img = $value;
                $photoName = time() . '.' . $imagesIndex . '.' . $request->get('img_ext_' . $imagesIndex);
                //encode base-64 string to image

                if (!empty($base64_img)) {
                    $image = explode(",", $base64_img)[1];
                } else {
                    $image = '';
                }
                File::put(public_path(config('constants.UPLOAD.IMAGES')) . '/' . $photoName, base64_decode($image));

                //add image to Database
                $fnData[] = [
                    'image' => $photoName,
                ];
                $imagesIndex++;
            }
        }
        
        if($photoName!=''){
            $requestData['image'] = $photoName;
        }
        
        RestaurantCategory::create($requestData);
        Session::flash('flash_message', trans('admin.categories.flash_messages.new'));
        return redirect('admin/restaurants-categories');
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
        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/restaurants-categories'),
                    'text' => __('admin.categories.breadcrumbs.category_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.categories.breadcrumbs.edit_category')
                ]
            ]
        ];

        $category = Category::join('restaurants_categories','restaurants_categories.category_id','=','categories.id')
                            ->where("restaurants_categories.id",'=', $id)
                            ->orderBy('restaurants_categories.created_at', 'asc')
                            ->select("categories.*","restaurants_categories.restaurant_id as restaurant_id","restaurants_categories.id as restaurants_categories_id","restaurants_categories.image as restaurants_categories_image")
                            ->first();
        
        $restaurants = Restaurant::orderBy('name_en', 'asc')->get();
        $categories = Category::orderBy('title_en', 'asc')->get();

        return view('admin.restaurants_categories.edit', compact('category', 'breadcrumbs','restaurants','categories'));
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
        if(Auth::user()->isRestaurant()){
            $this->validate($request, [
                'category_id' => 'required',
            ]);
        }
        else{
            $this->validate($request, [
                'restaurant_id' => 'required',
                'category_id' => 'required',
            ]);
        }
        
        $requestData = $request->all();
        if(Auth::user()->isRestaurant()){
            $requestData['restaurant_id'] = Session::get('res')->id;
        }
        $category = RestaurantCategory::findOrFail($id);
        $category->update($requestData);
        Session::flash('flash_message', trans('admin.categories.flash_messages.update'));
        return redirect('admin/restaurant-categories');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateSequence(Request $request)
    {
        $requestDatas = $request->all();
        foreach ($requestDatas['categories'] as $requestData) {
            Category::where('id', $requestData['id'])->update([
                'sequence' => $requestData['sequence'],
            ]);
        }
        return response('updated', 200);

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
        $category = Category::findOrFail($id);
        $category->delete();
        Session::flash('flash_message', trans('admin.categories.flash_messages.destroy'));
        return redirect('admin/restaurants_categories');
    }
}
