<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Log;
use App\Models\User;
use App\Models\Role;
use App\Models\Upload;
use App\Models\UsersRestaurant;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;


class UploadsController extends BelongToResController
{
    CONST default_index = 'upload';
    CONST required_method = ['edit','update','destroy'];
    CONST model = Upload::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     *
     * @internal param Request $request
     */
    public function index(Request $request,$slug)
    {
        $breadcrumbs = [
            'title' => __('admin.uploads.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/uploads'),
                    'text' => __('admin.uploads.breadcrumbs.upload_index')
                ]
            ]
        ];

        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');
        if(Auth::user()->isAdmin()){
            $imageLists = Upload::orderBy('id', 'desc')->get();
        }else{
            $imageLists = Upload::where('user_id',Auth::user()->id)->orWhere('restaurant_id',null)->orderBy('id', 'desc')->get();
        }
        
        return view('admin.uploads.index', compact('imageLists', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request,$slug)
    {
        $this->restaurant = Session::get('res');
		$user = Auth::user();
        $requestData = $request->all();
        $validateList = [];
        foreach ($requestData as $key => $value) {
            //if $key is image_, add image
            if (strpos($key, 'image_') !== false) {
                $validateList[$key] = 'regex:/^data:image/';
            }
        }
        $this->validate($request, $validateList, []);
        $image = '';
        // retrieve all the field of request data
		// $key = name of field, $value = value of field
		$fnData = [];
        $imagesIndex =0;
        $restaurantId = $this->restaurant->id;
        foreach ($requestData as $key => $value) {
            //if $key is image_, add image
            if (strpos($key, 'image_') !== false) {
				$base64_img = $value;
				$photoName = time() . '.' . $imagesIndex . '.' . $request->get('img_ext_'.$imagesIndex);
				//encode base-64 string to image
				if (!empty($base64_img)) {
					$image = explode(",", $base64_img)[1];
				} else {
					$image = '';
				}
				
                File::put(public_path(config('constants.UPLOAD.IMAGES')) . '/' . $photoName, base64_decode($image));
                //add image to Database
				
				$fnData[] = [
					'file_name' => $photoName,
					'extension' => $request->get('img_ext_'.$imagesIndex),
                    'user_id' => $user->id,
                    'restaurant_id' => $restaurantId
				];
				$imagesIndex++;
            }
        }
        
        Upload::insert($fnData);

        Session::flash('flash_message', trans('admin.uploads.flash_messages.new'));

        return redirect('admin/'.$slug.'/uploads');
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($slug,$id)
    {
        $success = false;
        try {
            $imageList = Upload::findOrFail($id);

            $imageList->delete();

            Session::flash('flash_message', trans('admin.uploads.flash_messages.destroy'));
            $success = true;
        } catch (\Exception $exception) {
            Session::flash('flash_message', trans('admin.uploads.flash_messages.can\'t_destroy'));
            //
        }
        return response()->json([
            'message' => trans('admin.uploads.flash_messages.destroy'),
            'id' => $id,
            'slug' => $slug,
            'result' => $success
        ]);
    }

    public function upload()
    {
        return;
    }

}
