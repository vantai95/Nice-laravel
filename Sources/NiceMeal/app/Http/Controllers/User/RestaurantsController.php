<?php

namespace App\Http\Controllers\User;

use App, Lang, DB, Session, Log, Exception, Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Customization;
use App\Models\DishCustomization;
use App\Models\Promotion;
use App\Models\CustomizationOption;
use App\Models\RestaurantWorkTime;
use App\Models\RestaurantDeliverySetting;
use App\Models\TimeBaseDisplayAffect;
use App\Models\District;
use App\Models\TimeBaseDisplayRule;
use Carbon\Carbon;
use App\Services\CartService;
use App\Services\CommonService;
use App\Services\RestaurantService;
use App\Services\ReviewService;
use App\Services\WorkingTimeService;
use App\Models\Faq;
use App\Models\FaqType;

class RestaurantsController extends Controller
{
    public function show(Request $request,$slug)
    {
        $lang = Session::get('locale');
        $restaurant = RestaurantService::getRestaurantFromRequest($request,$slug,$lang);
        $isRestaurantPage = true;
        if($restaurant == null){
            Session::flash("flash_error","No delivery available");
            return redirect('/');
        }

        $orderServices = collect($restaurant->orderServices());
        $orderPayments = collect($restaurant->orderPayments());
        $resCategories = RestaurantService::getRestaurantMenu($restaurant->id, $lang);
        $cart = Session::get('cart');
        return view('newuser.views.restaurant.show',compact('slug', 'restaurant',
         'cart','orderServices', 'orderPayments','resCategories','isRestaurantPage'));
    }

    public function getCart(Request $request)
    {
        $restaurantInput = $request->input('restaurant');
        if($restaurantInput == null){
            $cart = Session::get('cart');
        }else{
            $restaurant = new Restaurant($restaurantInput);
            $restaurant->id = $restaurantInput['id'];
            $restaurant->name = $restaurantInput['name'];
            $restaurant->restaurant_slug = $restaurantInput['restaurant_slug'];
            $restaurant->district_id = $restaurantInput['district_id'];
            $restaurant->ward_id = array_key_exists('ward_id',$restaurantInput) ? $restaurantInput['ward_id'] : null;
            $cart = Session::get('cart');

            $cart = RestaurantService::getCartForThisRestaurant($cart,$restaurant,true);

            Session::put('cart',$cart);
        }

        return response()->json($cart);
    }

    public function restaurantInfo($slug,Request $request)
    {
        $cart = Session::get('cart');
        $lang = Session::get('locale');
        $restaurant = RestaurantService::getRestaurantFromRequest($request,$slug,$lang,['allDeliverySettingListBuilder']);

        if($restaurant == null){
            Session::flash("flash_error","No delivery available");
            return redirect('/');
        }
        $categories = RestaurantService::getRestaurantCategories($restaurant->id,$lang)[0];
        $dateInWeek = collect(Controller::WEEKNAME);
        $orderServices = collect($restaurant->orderServices());
        $orderPayments = collect($restaurant->orderPayments());

        return view('user.restaurants.info', compact('slug', 'dateInWeek','restaurant', 'categories', 'cart', 'orderServices', 'orderPayments'));
    }

    // show intro
    public function getIntro($slug,Request $request)
    {
        $cart = Session::get('cart');
        $lang = Session::get('locale');
        $restaurant = RestaurantService::getRestaurantFromRequest($request,$slug,$lang);

        if($restaurant == null){
            Session::flash("flash_error","No delivery available");
            return redirect('/');
        }
        $categories = RestaurantService::getRestaurantCategories($restaurant->id,$lang)[0];
        $orderServices = collect($restaurant->orderServices());
        $orderPayments = collect($restaurant->orderPayments());
        return view('user.restaurants.intro', compact('slug','restaurant', 'categories', 'cart', 'orderServices', 'orderPayments'));
    }

    public function getPromotions($slug, Request $request){

        $cart = Session::get('cart');
        $lang = Session::get('locale');

        $restaurant = RestaurantService::getRestaurantFromRequest($request,$slug,$lang,['promotionBuildder']);
        $orderServices = collect($restaurant->orderServices());
        $orderPayments = collect($restaurant->orderPayments());
        if($restaurant == null){
            Session::flash("flash_error","No delivery available");
            return redirect('/');
        }
        $categories = RestaurantService::getRestaurantCategories($restaurant->id,$lang)[0];
        return view('user.restaurants.promotion', compact('slug','restaurant', 'categories', 'cart', 'orderServices', 'orderPayments'));
    }
    public function showFaqs($slug, Request $request)
    {
        //get Faqs restaurant
        $lang = Session::get('locale');
        $cart = Session::get('cart');
        $restaurantId = $cart['restaurant_id'];
        $resFaqType = Restaurant::select("faqs")->findOrFail($restaurantId);
        $faqsTypeId = ($resFaqType['faqs'] == null) ? [] : json_decode($resFaqType['faqs']);
        $faqsTypeArr = FaqType::select("id","name_$lang as name")->whereIn('id',$faqsTypeId)->with(['faqs' => function($query) use ($lang){
            $query->select("id","faq_type_id","question_$lang as question", "anwser_$lang as answer");
        }])->get();
        return view('newuser.views.faqs.show',compact('faqsTypeArr'));
    }
}

?>
