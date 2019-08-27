<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App,Lang, Session;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [];
        if(Auth::user()->isAdmin() || Auth::user()->isManageAllRestaurant()){
          Session::forget('res');
        }
        return view('admin.index', compact('params'));
    }

    public function changeLocalization($language){
        App::setLocale($language);
        Session::put('locale', $language);
        return redirect()->back();
    }

    public function clearSession(Request $request){
        Session::forget('res');
        return redirect('admin');
    }

}
