<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Restaurant;
use App\Models\Cuisine;
use App\Models\RestaurantCuisine;
use App\Services\CommonService;
use Session, Log, Auth;


class RestaurantsCuisinesController extends Controller
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
        $this->restaurant = Session::get('res');
        $breadcrumbs = [
            'title' => __('admin.restaurants_cuisines.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'.$this->restaurant->res_Slug.'/restaurants-cuisines'),
                    'text' => __('admin.restaurants_cuisines.breadcrumbs.cuisine_index')
                ]
            ]
        ];
        $keyword = $request->get('q');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');
        $cuisines = Cuisine::join('restaurants_cuisines','restaurants_cuisines.cuisine_id','=','cuisines.id')->orderBy('restaurants_cuisines.created_at', 'desc');
        
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $cuisines = $cuisines->where(function ($query) use ($keyword) {

                $query->orWhere('name_en', 'LIKE', $keyword);
//                $query->orWhere('title_vi', 'LIKE', $keyword);
                $query->orWhere('name_ja', 'LIKE', $keyword);
            });
        }


        $cuisines = $cuisines->where('restaurants_cuisines.restaurant_id',$this->restaurant->id)->select("cuisines.*","restaurants_cuisines.restaurant_id as restaurant_id","restaurants_cuisines.id as restaurants_cuisines_id")
        ->paginate($perPage);
        return view('admin.restaurants_cuisines.index', compact('cuisines', 'status', 'breadcrumbs'));
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
            'title' => __('admin.restaurants_cuisines.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'.$this->restaurant->res_Slug.'/cuisines'),
                    'text' => __('admin.restaurants_cuisines.breadcrumbs.cuisine_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants_cuisines.breadcrumbs.new_cuisine')
                ]
            ]
        ];

        $restaurants = Restaurant::orderBy('name_en', 'asc')->get();
        if(Auth::user()->isRestaurant()){
            $restaurants = Restaurant::where('id','=', Session::get('res')->id)->orderBy('name_en', 'asc')->get();
        }
        $cuisines = Cuisine::orderBy('name_en', 'asc')->get();
        return view('admin.restaurants_cuisines.create', compact('breadcrumbs', 'restaurants','cuisines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     * @param String
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request,$slug)
    {
        $this->validate($request, [
            'cuisine_id' => 'required',
        ]);
        $requestData = $request->all();
        $res = Session::get('res');
        $requestData['restaurant_id'] = $res->id;

        RestaurantCuisine::create($requestData);
        Session::flash('flash_message', trans('admin.cuisines.flash_messages.new'));
        return redirect('admin/'.$slug.'/restaurants-cuisines');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($slug,$id)
    {
        $breadcrumbs = [
            'title' => __('admin.restaurants_cuisines.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/restaurants-cuisines'),
                    'text' => __('admin.restaurants_cuisines.breadcrumbs.cuisine_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.restaurants_cuisines.breadcrumbs.edit_cuisine')
                ]
            ]
        ];
        $restaurant_cuisines = RestaurantCuisine::findOrFail($id);
        $restaurants = Restaurant::get();
        if(Auth::user()->isRestaurant()){
            $restaurants = Restaurant::where('id','=', Session::get('res')->id)->orderBy('name_en', 'asc')->get();
        }
        $cuisines = Cuisine::get();

        return view('admin.restaurants_cuisines.edit', compact('restaurant_cuisines', 'breadcrumbs','restaurants','cuisines'));
    }

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
        $this->validate($request, [
            'cuisine_id' => 'required',
        ]);

        $requestData = $request->all();
        $res = Session::get('res');
        $requestData['restaurant_id'] = $res->id;

        $cuisine = RestaurantCuisine::findOrFail($id);
        $cuisine->update($requestData);
        Session::flash('flash_message', trans('admin.cuisines.flash_messages.update'));
        return redirect('admin/'.$slug.'/restaurants-cuisines');
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
        $cuisine = RestaurantCuisine::findOrFail($id);
        $cuisine->delete();
        Session::flash('flash_message', trans('admin.cuisines.flash_messages.destroy'));
        return redirect('admin/'. $slug .'/restaurants-cuisines');
    }
}
