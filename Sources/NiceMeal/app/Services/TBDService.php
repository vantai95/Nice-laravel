<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\TimeBaseDisplayRule;
use App\Models\Dish;
use Carbon\Carbon;

class TBDService{

    public static function verifyTBD_Dish_N_R($dish_tbds){
        $dish_show = false;

        foreach($dish_tbds as $dish_tbd){
            $dish_show = $dish_show || self::checkTBD($dish_tbd);
        }

        return $dish_show;
    }

    public static function checkTBDs($tbds){
        $show = false;

        foreach($tbds as $tbd){
            $show = $show || self::checkTBD($tbd);
        }

        return $show;
    }

    public static function checkSingleDishTBD($dish_id){

        $dish_tbds = TimeBaseDisplayRule::where('dish_id','=',$dish_id)
        ->join('time_base_display_affects','time_base_display_rules.id','=','time_base_display_affects.rule_id')
        ->select('time_base_display_rules.*')
        ->get();
        if($dish_tbds->count() == 0) return 0;

        return self::verifyTBD_Dish_N_R($dish_tbds);
    }

    public static function checkMultipleDishes($dish_list){
        $disappear_list = [];
        $dishes_tbds = Dish::whereIn('dishes.id',$dish_list->pluck('id'))
        ->select('dishes.id','dishes.price')
        ->with(['timeBaseDisplayAffect' => function($query){
          $query->join('time_base_display_rules','time_base_display_rules.id','=','time_base_display_affects.rule_id')
          ->select('time_base_display_rules.*','time_base_display_affects.rule_id','time_base_display_affects.dish_id');
        }])->where('active',1)->get();
        
        //Check if item removed
       $removed_list = $dish_list->filter(function($item) use ($dishes_tbds){
           return !$dishes_tbds->contains('id',$item['id']);
       });

       if($removed_list->count() > 0 ){
           foreach($removed_list as $removed){
               $disappear_list[$removed['id']] = $removed;
           }
           return $disappear_list;
       }

        //Check TBD
        foreach($dish_list as $dish){
          $current_dish = $dishes_tbds->where('id','=',$dish['id'])->first();
            if($current_dish->timeBaseDisplayAffect->count() > 0 && !self::verifyTBD_Dish_N_R($current_dish->timeBaseDisplayAffect)){
                $disappear_list[$dish['id']] = $dish;
            }
        }
        return $disappear_list;
    }

    public static function getTBD($rulesId) {
        $now = Carbon::now();
        $isAvailable = false;

        if (TimeBaseDisplayRule::whereIn('id', explode(',', $rulesId))->where('active', 1)->get()->count() == 0) return -1;

        foreach (explode(',', $rulesId) as $ruleId) {
            $rule = TimeBaseDisplayRule::where('id', $ruleId)->where('active', 1)->first();

            if (!$rule) continue;

            $isDateAvail = $rule->period_type == 0 || ($rule->from_date <= $now->format('Y-m-d') && $now->format('Y-m-d') <= $rule->to_date);
            $isDayNameAvail = $rule->all_days == 1 || $rule[Controller::WEEKNAME[$now->dayOfWeek]] == 1;
            $isTimeAvail = $rule->all_times == 1 || (substr($rule->from_time, 0, 5) <= $now->format('H:i') && $now->format('H:i') <= substr($rule->to_time, 0, 5));
            $isAvailable = $isAvailable || ($isDateAvail && $isDayNameAvail && $isTimeAvail);
        }

        return $isAvailable ? 1 : 0;
    }

    public static function checkTBD($tbd){
      $now = Carbon::now();

      $isDateAvail = $tbd->period_type == 0 || ($tbd->from_date <= $now->format('Y-m-d') && $now->format('Y-m-d') <= $tbd->to_date);
      $isDayNameAvail = $tbd->all_days == 1 || $tbd->{Controller::WEEKNAME[$now->dayOfWeek]} == 1;
      $isTimeAvail = $tbd->all_times == 1 || (substr($tbd->from_time, 0, 5) <= $now->format('H:i') && $now->format('H:i') <= substr($tbd->to_time, 0, 5));
      return $isDateAvail && $isDayNameAvail && $isTimeAvail;
    }
}
