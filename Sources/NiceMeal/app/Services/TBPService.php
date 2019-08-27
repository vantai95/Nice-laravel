<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use DB;
use Carbon\Carbon;

class TBPService
{
    public static function timeBasePricing($tbps, $default_price)
    {
        $now = Carbon::now();

        foreach ($tbps as $key => $rule) {
            $isDateAvail = $rule->period_type == 0 || ($rule->from_date <= $now->format('Y-m-d') && $now->format('Y-m-d') <= $rule->to_date);
            $isDayNameAvail = $rule->all_days == 1 || $rule->{Controller::WEEKNAME[$now->dayOfWeek]} == 1;
            $isTimeAvail = $rule->all_times == 1 || (substr($rule->from_time, 0,
                        5) <= $now->format('H:i') && $now->format('H:i') <= substr($rule->to_time, 0, 5));
            if (($isDateAvail && $isDayNameAvail && $isTimeAvail) == false) {
                unset($tbps[$key]);
            }
        }
        $tbps = $tbps->values();

        if ($tbps->count() == 0) {
            return $default_price;
        } else {
            if ($tbps->count() == 1) {
                return $tbps->first()->value;
            } else {
                if ($tbps->count() > 1) {
                    return $tbps->min('value');
                }
            }
        }
    }

    public static function timeBasePricingMultiDish($dish_list)
    {
        $new_dish_list = [];
        foreach ($dish_list as $dish) {
            $current_price = self::timeBasePricing((object)$dish);
            if ($dish['price'] != $current_price) {
                $dish['old_price'] = $dish['price'];
                $dish['price'] = $current_price;
                $new_dish_list[$dish['id']] = $dish;
            }
        }
        return $new_dish_list;
    }
}