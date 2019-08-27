<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Lang;
use Session, Log, Exception, Auth;

use App\Models\District;
use App\Models\User;
use App\Models\Role;
use App\Models\EmailMarketing;
use App\Models\Ward;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        /*if (!Auth::check()) {
            return redirect('login');
        }*/
        $checkLogin = Session::get('flash_error');
        $userCheck = 0;
        if($checkLogin) {
            $userCheck = 1;
        }
        return view('newuser.views.home',compact('userCheck'));

        $language = Session::get('locale');
        $districts = District::select("name_$language as name", "type_$language as type", "districts.*")->orderBy("sequence",'asc')->get();

        if(array_key_exists('location_info',$_COOKIE)){
          $location_info = json_decode($_COOKIE['location_info']);
          $locationUrl = "/locations/{$location_info->district->slug}";
          if($location_info->ward !== null){
            $locationUrl .= "?ward={$location_info->ward}";
          }
          return redirect($locationUrl);
        }

        return view('user.home', compact('districts'));
    }

    public function changeLocalization($language)
    {
        App::setLocale($language);
        Session::put('locale', $language);
        return redirect()->back();
    }

    public function emailMarketing(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $requestData = $request->all();
        $requestData['recieve_new_deals'] = true;

        if (!EmailMarketing::where('email', $requestData['email'])->first())
            EmailMarketing::create($requestData);

        return;
    }
    public function mealRest(){
        $language = Session::get('locale');

        if (Auth::check()) {
            $user = Auth::user();
            if (Auth::user()->isAdmin() || Auth::user()->isRestaurant()) {
                return redirect('admin');
            }
        }
        return view('user.mealrest', compact('language'));
    }

    public function getWardsByDistrictSlug() {
        $language = Session::get('locale');
        $slug = '';
        if(request()->has('slug')) {
            $slug = request()->query('slug');
        }
        $wards = array();
        if(empty($slug)) return response()->json($wards);
        try {
            $district = District::where('slug',$slug)->firstOrFail();
            $wards = Ward::select("name_$language as name", "type_$language as type", "wards.*")->where('district_id',$district->id)->get()->toArray();
        } catch (Exception $exception) {
            return response()->json($wards);
        }
        return response()->json($wards);
    }

}

?>
