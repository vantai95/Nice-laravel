<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Restaurant;
use App\Models\Tag;
use App\Models\RestaurantDeliverySetting;
use App\Models\RestaurantWorkTime;
use App\Models\Ward;
use Lang,Session,Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use File;

class ContactController extends Controller
{
    public function index()
    {
        $language = Session::get('locale');
        $districts = District::select("id","name_$language as name", "type_$language as type", "districts.*")->orderBy("sequence",'asc')->get();
        $wards = Ward::select("id","district_id",'wards.*',"wards.name_$language as name","wards.type_$language as type")->get();
        $tags = Tag::select("id", "name_$language as name" )->orderBy('tags.id', 'desc')->get();
        return view('user.contact.submit_restaurant', compact('districts','wards','tags','language'));
    }
    public function submitRestaurant (Request $request)
    {
        $validators = Validator::make($request->all(), [
            'ri_restaurant_name' => 'required',
            'ri_address' => 'required',
            'ri_district' => 'required',
            'ri_ward' => 'required',
            'ri_phone' => 'required | min: 8',
            'ri_email' => 'required | email',
            'ri_link' => 'required',
            'oi_fullname' => 'required',
            'owner_phone' => 'required| min: 8 | unique:restaurants',
            'owner_email' => 'required | email | unique:restaurants',
            'imgContract' => 'mimes:jpeg,bmp,png,pdf',
            'imgCV' => 'mimes:jpeg,bmp,png,pdf',
            'imgBusinessLicense' => 'mimes:jpeg,bmp,png,pdf',
        ]);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "message" => $validators->messages()
            ]);
        }

        //Add Restaurant
        $requestData = $request->all();
        $requestData['name_en'] = $request->get('ri_restaurant_name');
        $requestData['address_en'] = $request->get('ri_address');
        $requestData['phone'] = $request->get('ri_phone');
        $requestData['email'] = $request->get('ri_email');
        $requestData['link'] = $request->get('ri_link');
        $requestData['delivery'] = ($request->get('delivery') == "true") ? true : false;
        $requestData['pickup'] = ($request->get('pickup')  == "true") ? true : false;
        $requestData['cod_payment'] = ($request->get('cod_payment')  == "true") ? true : false;
        $requestData['online_payment'] = ($request->get('online_payment')  == "true") ? true : false;
        $requestData['owner_name'] = $request->get('oi_fullname');
        $requestData['owner_phone'] = $request->get('owner_phone');
        $requestData['owner_email'] = $request->get('owner_email');
        $requestData['status'] = 1;
        $requestData['province_id'] = 1;
        $requestData['district_id'] = $request->get('ri_district');
        $requestData['ward_id'] = $request->get('ri_ward');
        $requestData['active'] = false;

        $foodCuisine= json_decode($request->get('ri_food_cuisine'), true);
        $tags = Tag::whereIn('id',$foodCuisine)->get();
        $title_brief_en='';$title_brief_ja='';
        foreach($tags as $key => $value){
            if($key==0){
                $title_brief_en=$value->name_en;
                $title_brief_ja=$value->name_ja;
            }else{
                $title_brief_en .=", ".$value->name_en;
                $title_brief_ja .=", ".$value->name_ja;
            }
        }

        $requestData['title_brief_en'] = $title_brief_en;
        $requestData['title_brief_ja'] = $title_brief_ja;
        $requestData['tags'] ='';

        if ($request->hasFile('imgContract')) {
            $contractFile = $request->file('imgContract');
            $contractContent = file_get_contents($contractFile, true);
            $contractName = time().'_contract'.'.'.$contractFile->getClientOriginalExtension();
            $requestData['contract'] = $contractName;
            Storage::disk(ENV('FILESYSTEM_CLOUD'))->put($contractName, $contractContent);
        }
        if ($request->hasFile('imgCV')) {
            $cvFile = $request->file('imgCV');
            $cvContent = file_get_contents($cvFile, true);
            $cvName = time().'_identity_card'.'.'.$cvFile->getClientOriginalExtension();
            $requestData['identity_card'] = $cvName;
            Storage::disk(ENV('FILESYSTEM_CLOUD'))->put($cvName, $cvContent);
        }
        if ($request->hasFile('imgBusinessLicense')) {
            $blFile = $request->file('imgBusinessLicense');
            $blContent = file_get_contents($blFile, true);
            $blName = time().'_business_license'.'.'.$blFile->getClientOriginalExtension();
            $requestData['business_license'] = $blName;
            Storage::disk(ENV('FILESYSTEM_CLOUD'))->put($blName, $blContent);
        }

        $res =Restaurant::create($requestData);
        $idRestaurant = $res->id;
        $requestData['restaurant_id'] = $idRestaurant;
        //add data Restaurant Delivery Setting
        $deliveryLocation= json_decode($request->get('delivery_location'), true);
        foreach ($deliveryLocation as $key => $value)
        {
            $dl= json_decode(($value), true);
            foreach( $dl as $key => $value)
            {
                $requestData[$key] = $value;
            }
            RestaurantDeliverySetting::create($requestData);
        }

        //add data Restaurant Working Time
        $openingTime= json_decode($request->get('opening_time'), true);
        foreach ($openingTime as $key => $value)
        {
            $ot= json_decode(($value), true);
            foreach( $ot as $key => $value)
            {
                if($key == 'from_time')
                {
                    if($requestData['all_times'] == 1)
                    {
                        $requestData['from_time'] = date("00:00:00");
                    }
                    else {
                        $fromTime = explode(' ', $value);
                        if($fromTime[1] == 'AM'){
                            $requestData['from_time'] = (strval($fromTime[0]).':'.'00');
                        }
                        else {
                            $requestData['from_time'] = (strval(($fromTime[0] + 12)).':'.'00');
                        }
                    }
                }
                else if ($key == 'to_time') {
                    if($requestData['all_times'] == 1)
                    {
                        $requestData['to_time'] = date("24:59:59");
                    }
                    else {
                        $toTime = explode(' ', $value);
                        if($toTime[1] == 'AM'){
                            $requestData['to_time'] = (strval($toTime[0]).':'.'00');
                        }
                        else {
                            $requestData['to_time'] = (strval(($toTime[0] + 12)).':'.'00');
                        }
                    }
                }
                else
                {
                    $requestData[$key] = $value;
                }
            }
            RestaurantWorkTime::create($requestData);
        }
        // Log::info($requestData);
        return response()->json(['success' => true]);
    }
}
