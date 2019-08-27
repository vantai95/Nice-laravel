<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use DB;
use Carbon\Carbon;
use App\Services\TimeSettingService;

use App\Services\CartService;

class PromotionService{
    public static function getPromotion($restaurant,$lang){
        $promotions = $restaurant->promotions()
        ->select("id","name_$lang","description_$lang","promotion_code","restaurant_id","is_global","free_item",
                "type","value","free_item","maximun_discount","item_value_from","item_value_to","status","include_request",'apply_to',
                'min_order_value','max_order_value')
        ->with(['time_setting.time_setting_details','promotion_affects' => function($query) use ($lang){
            $query->select('promotion_affects.id','promotion_affects.promotion_id','promotion_affects.restaurant_id',
            'promotion_affects.dish_id','promotion_affects.category_id',"dishes.name_$lang as dish_name","categories.title_$lang as category_name")
            ->leftJoin('dishes','dishes.id','=','promotion_affects.dish_id')
            ->leftJoin('categories','categories.id','=','promotion_affects.category_id');
        }])->where('promotions.status','=',1)->get();
        $free_items = $promotions->where('free_item','!=','[]')->where('free_item','!=',null)->pluck('free_item');
        $free_items_id = "";
        foreach($free_items as $fi){
            $free_items_id .= ','.$fi;
            $free_items_id = trim($free_items_id,',');
        }

        $free_items = Dish::select('id',"name_$lang as name","description_$lang as description")
        ->whereIn('id',explode(',',$free_items_id))->get();

        foreach($promotions as $key => &$prt){
            $fil = explode(',',$prt->free_item);
            $prt->free_items_list = $free_items->whereIn('id',$fil);
            unset($prt->free_item);
        }
        return $promotions;
    }

    public static function promotionStatus($promotions) {
      return $promotions->filter(function ($promotion, $key){
        return TimeSettingService::checkTimeSetting($promotion->time_setting);
      });
    }

    public static function createPromotionAffect($promotion,$restaurant){

    }

    public static function createPromotionAvailTime($promotion, $restaurant){

    }
}
