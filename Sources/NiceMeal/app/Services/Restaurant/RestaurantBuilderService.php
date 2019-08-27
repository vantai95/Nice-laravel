<?php
namespace App\Services\Restaurant;

class RestaurantBuilderService {

  public static function deliverySettingsBuilder($builder,$location = [],$lang = "en"){
    $builder = $builder->with(['restaurantDeliverySetting' => function($query) use ($lang,$location){
        $query = $query->select('restaurant_delivery_settings.id','restaurant_delivery_settings.restaurant_id',
        'restaurant_delivery_settings.district_id','restaurant_delivery_settings.delivery_cost',
        "districts.name_$lang as district_name",
        "districts.slug as district_slug",
        'restaurant_delivery_settings.min_order_amount','restaurant_delivery_settings.parent_id','restaurant_delivery_settings.ward_id')
        ->join('districts','districts.id','=','restaurant_delivery_settings.district_id')->where('restaurant_delivery_settings.parent_id','=',0);
        $query = self::locationBuilder($location,$query);
    }]);
    return $builder;
  }

  public static function workingTimeBuilder($builder, $lang="en"){
    $builder = $builder->with(['restaurantWorkTimes' => function($query){
      $query->select('id','restaurant_id')->with('time_setting.time_setting_details');
    }]);
    return $builder;
  }

  public static function allDeliverySettingListBuilder($builder,$lang){
    $builder = $builder->with(['restaurantDeliverySetting' => function($query) use ($lang){
        $query = $query->select('restaurant_delivery_settings.id','restaurant_delivery_settings.restaurant_id',
        'restaurant_delivery_settings.district_id','restaurant_delivery_settings.delivery_cost',
        "districts.name_$lang as district_name",
        'restaurant_delivery_settings.min_order_amount','restaurant_delivery_settings.parent_id',
            'restaurant_delivery_settings.ward_id',"wards.name_$lang as ward_name")
        ->join('districts','districts.id','=','restaurant_delivery_settings.district_id')
        ->leftJoin('wards','wards.id','=','restaurant_delivery_settings.ward_id');
      }]);
      return $builder;
  }

  public static function promotionBuildder($builder,$lang="en"){
    $builder = $builder->with(['promotions' => function($query) use ($lang){
      $query->select('restaurant_id','id',"name_$lang as name","description_$lang as description")->where('status',1);
    }]);
    return $builder;
  }

  public static function checkHasDeliverySettingBuilder($builder, $location = [], $lang = "en"){
    $builder = $builder->whereHas('restaurantDeliverySetting',function($query) use ($location){
      $query->join('districts','restaurant_delivery_settings.district_id','=','districts.id')
            ->where('restaurant_delivery_settings.parent_id','=',0);
      $query = self::locationBuilder($location,$query);
    });
    return $builder;
  }

  public static function serviceBuilder($condition,$builder){
    if (array_key_exists('services',$condition)  && $condition['services'] != null) {
        $conditionServices = $condition['services'];
        $builder = $builder->where(function ($query) use ($conditionServices) {
            foreach ($conditionServices as $index => $service) {
                if ($index == 0) $query->where("restaurants.$service", '=', 1);
                else $query->orWhere("restaurants.$service", '=', 1);
            }
        });
    }
    return $builder;
  }

  public static function locationBuilder($location,$query){
    if(count($location) != 0){
      if(is_string($location['district'])){
        $query = $query->where("districts.slug",'=',$location['district']);
      }
      else {
        $query = $query->where("restaurant_delivery_settings.district_id",'=',$location['district']);
      }

      if($location['ward'] !== null && $location['ward'] !== "" && intval($location['ward']) !== 0){
        $query = $query->where(function($sub_query) use ($location){
          $sub_query->whereNull('restaurant_delivery_settings.ward_id')->orWhere('restaurant_delivery_settings.ward_id','=',$location['ward']);
        });
      }
    }
    return $query;
  }

  public static function statusBuilder($condition,$builder){
    if (array_key_exists('statuses',$condition)&& $condition['statuses'] != null) {
        $builder = $builder->whereIn("restaurants.status", $condition['statuses']);
    }
    return $builder;
  }

  public static function paginateBuilder($segIdx = 0,$builder){
    $offset = env('LIMIT_SEARCH_ITEMS') * $segIdx;
    $builder = $builder->offset($offset)->limit(env('LIMIT_SEARCH_ITEMS'))->orderBy('restaurants.id');
    return $builder;
  }

  public static function paymentBuilder($condition,$builder){
    if (array_key_exists('payment_methods',$condition) && $condition['payment_methods'] != null) {
        $conditionPayMethods = $condition['payment_methods'];
        $builder = $builder->where(function ($query) use ($conditionPayMethods) {
            foreach ($conditionPayMethods as $index => $payment_method) {
                if ($index == 0) $query->where("restaurants.$payment_method", '=', 1);
                else $query->orWhere("restaurants.$payment_method", '=', 1);
            }
        });
    }
    return $builder;
  }

}
