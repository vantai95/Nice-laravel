<?php

namespace App\Http\Controllers\Admin;

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

class LocationController extends Controller
{

 public function index()
    {
    	$districts = District::select('id','sequence','name_en')->orderBy('districts.sequence','asc')->get();
    	return view('admin.locations.district',compact('districts'));
    }   

    public function updateSequenceDistrict(Request $request)
    {
    
        $disIds = $request->get('disIds');
        foreach ($disIds as $key=>$disId){
            District::where('id',$disId)->update(['sequence'=> $key+1]);
        }
        return response()->json('updated', 200);

    }

    public function showDistrict()
    {   
        $districts = District::select('id','sequence','name_en')->orderBy('districts.sequence','asc')->get();
        return view('admin.locations.ward',compact('districts'));
    }

    public function searchWardByDistrict(Request $request)
    {
        $district_id = $request->get('district_id');
        $wards = Ward::select('name_en','sequence','id')->where('district_id',$district_id)->orderby('sequence','asc')->get();
        $districts = District::select('id','sequence','name_en')->orderBy('districts.sequence','asc')->get();
        return view('admin.locations.ward',compact('district_id','wards','districts'));

    }

    public function updateSequenceWard(Request $request)
    {
    
        $wardIds = $request->get('wardIds');
        foreach ($wardIds as $key=>$wardId){
            Ward::where('id',$wardId)->update(['sequence'=> $key+1]);
        }
        return response()->json('updated', 200);

    }
}
