<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CommonService;
use Illuminate\Support\Facades\File;
use Log, Auth, Session;
use App\Models\Cuisine;

class CuisinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.cuisines.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/cuisines'),
                    'text' => __('admin.cuisines.breadcrumbs.cuisines_index')
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

        $cuisines = Cuisine::select('cuisines.*' )->orderBy('cuisines.id', 'desc');

        // filter with search params
        if ($status == Cuisine::STATUS_FILTER['inactive']) {
            $cuisines = $cuisines->where('cuisines.active', '=', false);
        } elseif ($status == Cuisine::STATUS_FILTER['active']) {
            $cuisines = $cuisines->where('cuisines.active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $cuisines = $cuisines->where(function ($query) use ($keyword) {
                $query->orWhere('cuisines.name_en', 'LIKE', $keyword);
                $query->orWhere('cuisines.name_ja', 'LIKE', $keyword);
            });
        }

        $cuisines = $cuisines->paginate($perPage);
        return view ('admin.cuisines.index',compact('cuisines', 'status',  'breadcrumbs', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.cuisines.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/cuisines'),
                    'text' => __('admin.cuisines.breadcrumbs.cuisines_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.cuisines.breadcrumbs.add_cuisines')
                ]
            ]
        ];

        return view('admin.cuisines.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validations($request);

        $requestData = $request->all();
        unset($requestData['_token']);

        Cuisine::insert($requestData);

        Session::flash('flash_message', trans('admin.cuisines.flash_messages.new'));
        return redirect('admin/cuisines');
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
    public function edit($id)
    {
        $breadcrumbs = [
            'title' => __('admin.cuisines.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/cuisines'),
                    'text' => __('admin.cuisines.breadcrumbs.cuisines_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.cuisines.breadcrumbs.edit_cuisine')
                ]
            ]
        ];

        $cuisine = Cuisine::findOrFail($id);

        return view('admin.cuisines.edit',compact('cuisine', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validations($request);

        $cuisine = Cuisine::findOrFail($id);

        $requestData = $request->all();

        $cuisine->update($requestData);

        Session::flash('flash_message', trans('admin.cuisines.flash_messages.update'));
        return redirect('admin/cuisines');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cuisine = Cuisine::findOrFail($id);

        $cuisine->delete();

        Session::flash('flash_message', trans('admin.cuisines.flash_messages.destroy'));
        return redirect('admin/cuisines');
    }

    public function validations(Request $request) {
        $this->validate($request,[
            'name_en' => 'required',
            'name_ja' => '',
        ]);
    }
}
