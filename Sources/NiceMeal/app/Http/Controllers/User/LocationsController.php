<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App;
use Lang;
use Session, Log, Exception, Auth;
use Carbon\Carbon;
use App\Models\District;
use App\Models\Ward;
use App\Models\Cuisine;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Tag;
use App\Models\UsersSession;
use App\Services\Restaurant\SearchService;
use App\Services\LocationService;

class LocationsController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function show(Request $request, $slug) {
        $lang = Session::get('locale');
        $service = $request->input('service');
        $cart = Session::get('cart');
        $cart['service'] = $service;
        $allDistricts = District::select("name_$lang as name", "type_$lang as type", "districts.*")->orderBy('districts.sequence', 'asc')->get();
        $district = $allDistricts->where('slug', $slug)->first();
        setcookie("location_info",json_encode([
          'district' => [
            'id' => $district->id,
            'slug' => $district->slug
          ],
          'ward' => $request->input('ward'),
          'province_id' => $district->province_id
        ]),time() + (86400 * 30),'/');

        if(Auth::check()){
            UsersSession::create([
                'user_id' => Auth::user()->id,
                'district_id' => $district->id,
                'ward_id'    => $request->input('ward'),
                'province_id' => $district->province_id
            ]);
        }
        // query db
        $allDistricts = District::select("name_$lang as name", "type_$lang as type", "districts.*")->orderBy('districts.sequence', 'asc')->get();
        $district = $allDistricts->where('slug', $slug)->first();
        $allWards = Ward::select("name_$lang as name", "type_$lang as type", "wards.*")->where('district_id',$district->id)->orderBy('created_at', 'asc')->get();
        return view('newuser.views.restaurant.list');
        //insert and update session customer
        // return view('user.locations.show', compact('allDistricts', 'district', 'cuisines', 'categories','allWards'));
    }

    public function restaurants(Request $request, $slug) {
        $lang = Session::get('locale');
        App::setLocale($lang);
        $district = District::where('slug',$slug)->first();
        [$restaurants, $maxCount] = SearchService::searchByLocation(['district' => $slug, 'ward' => $request->input('ward')],
        $request->input('condition'),$request->input('sort'),$request->input('segIdx'),$lang);


        return response()->json(['restaurants' => $restaurants, 'maxCount' => $maxCount]);
    }

    public function getRestaurants($slug, Request $request) {
        $lang = Session::get('locale');
        App::setLocale($lang);

        $segIdx = 0;

        // query from database
        $restaurants = Restaurant::join('districts', 'restaurants.district_id', '=', 'districts.id')
            ->leftJoin('restaurant_delivery_settings', 'restaurants.id', '=', 'restaurant_delivery_settings.restaurant_id')
            ->leftJoin('restaurants_cuisines', 'restaurants.id', '=', 'restaurants_cuisines.restaurant_id')
            ->select(DB::RAW("DISTINCT restaurants.id as id,
                restaurants.name_$lang as name,
                restaurants.title_brief_$lang as title_brief,
                restaurants.description_$lang as description,
                restaurants.address_$lang as address,
                restaurants.review_rate as ranking,
                restaurants.*,
                districts.id as district_id,
                CONCAT(districts.name_$lang) as district_name,
                max(restaurant_delivery_settings.delivery_cost) as max_delivery_cost,
                min(restaurant_delivery_settings.min_order_amount) as min_order_amount"
            ))
            ->where("restaurants.name_$lang", 'RLIKE', $request['value'])
            ->orWhere("restaurants.title_brief_$lang", 'RLIKE', $request['value'])
            ->where('restaurants.active', 1)
            ->groupBy('id');

        $restaurants = $restaurants->where('restaurants.active', 1)->get();
        $maxCount = $restaurants->count();

        // add attributes into objects
        foreach ($restaurants as $idx => $restaurant) {
            $restaurant->status = array_search($restaurant->status, Restaurant::STATUSES_FILTER);
            $restaurant->is_open_now = $restaurant->isOpenNow();
            $restaurant->idx = $idx;
        }

        // sorting
        if (isset($sort)) {
            if ($sort['key'] == '') {
                ($sort['direction'] == 'asc')
                    ? $restaurants = $restaurants->sortByDesc('vip_restaurant')->sortByDesc('is_open_now')
                    : $restaurants = $restaurants->sortBy('vip_restaurant')->sortByDesc('is_open_now');
            } else {
                ($sort['direction'] == 'asc')
                    ? $restaurants = $restaurants->sortBy($sort['key'])
                    : $restaurants = $restaurants->sortByDesc($sort['key']);

            }
        }

        $idx = 0;
        foreach ($restaurants as $restaurant) {
            $restaurant->idx = $idx;
            $idx = $idx + 1;
        }

        // paginate items
//        $restaurants = $restaurants->slice($segIdx * env('LIMIT_SEARCH_ITEMS'), env('LIMIT_SEARCH_ITEMS'));

        // return result
        return response()->json(['restaurants' => $restaurants, 'maxCount' => $maxCount]);
    }

    public function wards($district_id) {
        $lang = Session::get('locale');
        App::setLocale($lang);

        $wards = App\Models\Ward::where('district_id', $district_id)->select(
            "id",
            DB::raw("CONCAT(type_$lang, ' ', name_$lang) as name")
        )
        ->get();
        return response()->json(['wards' => $wards]);
    }

    public function districts($province_id){
      $lang = Session::get('locale');
      $districts = App\Models\District::where('province_id', $province_id)->select(
          "id",
          "name_$lang as name",
          "slug"
      )
      ->get();
      return response()->json(['districts' => $districts]);
    }

    public function allLocations(){
        $lang = Session::get('locale');
        $allLocations = LocationService::getAllLocations($lang)->get();
        return response()->json(['allLocations' => $allLocations]);
    }
}
?>
