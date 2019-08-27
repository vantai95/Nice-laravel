<?php
namespace App\Services\Restaurant;

use App\Models\Restaurant;
use App\Models\Promotion;
use App\Services\PromotionService;
use App\Services\RestaurantService;
use App\Services\CommonService;
use App\Services\Restaurant\RestaurantBuilderService;
use App\Services\Restaurant\RestaurantFilterService;
use App\Services\Restaurant\RestaurantSortService;
use App\Services\ReviewService;
use App\Models\Tag;

class SearchService{


  public static function searchByLocation($location = ["district" => "","ward" => ""],
    $condition = [], $sort = ["key" => "", "direction" => "asc"], $segIdx = 0,$lang = "en")
  {
    $restaurants = Restaurant::join('districts','districts.id','restaurants.district_id')->select(
            "restaurants.name_$lang as name",
            "restaurants.title_brief_$lang as title_brief",
            "restaurants.description_$lang as description",
            "restaurants.address_$lang as address",
            "restaurants.review_rate as ranking",
            "districts.slug as district_slug",
            "restaurants.*"
        )
        ->where('restaurants.active', true)
        ->with('restaurantWorkTimes.time_setting.time_setting_details');
      $restaurants = RestaurantBuilderService::checkHasDeliverySettingBuilder($restaurants,$location);
      $restaurants = RestaurantBuilderService::deliverySettingsBuilder($restaurants,$location);
      $restaurants = RestaurantBuilderService::paymentBuilder($condition,$restaurants);
      $restaurants = RestaurantBuilderService::serviceBuilder($condition,$restaurants);
      $restaurants = RestaurantBuilderService::statusBuilder($condition,$restaurants);
      $restaurants = RestaurantBuilderService::paginateBuilder($segIdx,$restaurants);
      $restaurants = $restaurants->get();
      $restaurants = ReviewService::getStarWeekForMultiRestaurant($restaurants);

      $restaurants = self::countAvailPromotion($restaurants);
      $restaurants = RestaurantFilterService::filterByCuisine($condition,$restaurants);
      $restaurants = RestaurantFilterService::filterByCategories($condition,$restaurants);

      $maxCount = $restaurants->count();
      // $restaurants = RestaurantSortService::sort($sort,$restaurants);
      $restaurants = self::buildExtraInfo($restaurants);

      $restaurants = $restaurants->toArray();
      $restaurants = array_values($restaurants);
      return [$restaurants, $maxCount];
  }

  public static function countAvailPromotion($restaurants){
    $promotions = Promotion::whereIn('restaurant_id',$restaurants->pluck('id'))
    ->with('time_setting.time_setting_details')->where('status','=',1)->get();
    $promotions = PromotionService::promotionStatus($promotions);
    foreach($restaurants as &$restaurant){
        $restaurant->promotion_count = $promotions->where('restaurant_id',$restaurant->id)->count();
    }
    return $restaurants;
  }

  public static function buildExtraInfo($restaurants){
    foreach ($restaurants as $restaurant) {
        $restaurant->status = array_search($restaurant->status, Restaurant::STATUSES_FILTER);
        $restaurant->is_open_now = RestaurantService::getOpenStatus($restaurant->restaurantWorkTimes);
        $restaurant->image_url = CommonService::buildImageURL($restaurant->image);

    }
    return $restaurants;
  }
}
