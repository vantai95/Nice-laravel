<?php

namespace App\Http\Controllers\Api\User\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Lang;
use Session, Log, Exception, Auth;
use App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Customization;
use App\Models\DishCustomization;
use App\Models\CustomizationOption;
use App\Models\RestaurantWorkTime;
use App\Models\RestaurantDeliverySetting;
use App\Models\TimeBaseDisplayAffect;
use App\Models\District;
use App\Models\TimeBaseDisplayRule;
use DB;
use Carbon\Carbon;
use App\Services\CommonService;
use App\Services\RestaurantService;
use App\Services\PromotionService;
use App\Services\WorkingTimeService;
use App\Services\CartService;

class RestaurantController extends Controller
{

    public function getMenu(Request $request){
        $lang = $request->header('language');
        $district_id = $request->input('district_id');
        $ward_id = $request->input('ward_id');

        $restaurant_id = $request->input('restaurant_id');
        // init variables
        $restaurant = RestaurantService::getRestaurantFromRequest($request,"",$lang,['allDeliverySettingListBuilder']);
            if($restaurant == null){
                return response()->json([
                    'success' => false,
                    'error_code' => "RESTAURANT01",
                    "message" => "No delivery setting available"
                ]);
            }

        // $restaurant->restaurant_work_times = WorkingTimeService::getWorkingTime($restaurant);

        $restaurant->promotions =  PromotionService::getPromotion($restaurant,$lang);

        $now = Carbon::now();
        $cart = CartService::initCart([
            'restaurant' => $restaurant->restaurant_slug,
            'restaurant_id' => $restaurant->id,
            'district_id' => $district_id,
            'ward_id' => $ward_id
        ]);
        $cart = collect($cart);

        [$categories,$customizations,$dish_customizations] = RestaurantService::getRestaurantMenu($restaurant->id,$lang);
        $exchange_rate = RestaurantService::getRestaurantExchangeRate($restaurant->id);
        return response()->json([
            'success' => true,
            'restaurant' => $restaurant,
            'dish_customizations' => $dish_customizations,
            'customizations' => $customizations,
            'categories' => $categories,
            'cart' => $cart,
            'exchange_rate' =>$exchange_rate
        ]);
    }

}
