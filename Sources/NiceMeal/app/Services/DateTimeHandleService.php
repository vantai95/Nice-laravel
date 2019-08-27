<?php
namespace App\Services;

class DateTimeHandleService {

    public static function calculateDayInWeek($from_date,$to_date){
        $return_array = [];
        for($i = $from_date; $i <= $to_date; $i+= 86400){
            $day = date('w',$i);
            if(!isset($return_array[$day])){
                $return_array[$day] = 0;
            }
            $return_array[$day] ++;
        }
        return $return_array;
    }

    public static function calculateTotalHour($period_time){
        $total_hour = 0;
        foreach($period_time as $period){
            $total_hour += self::calculateSeconds($period->to_time) - self::calculateSeconds($period->from_time);
        }
        return $total_hour/3600;
    }

    public static function mergeTheseTime($period_time){
        $temp_period = [];
        $intersect = 0;
        $period_time = collect($period_time);
        foreach($period_time as $key=>$period){
            $temp_period[$key] = self::checkIntersect($period,$period_time);
            $intersect += $temp_period[$key]->intersect;
        }
        $temp_period = collect($temp_period)->unique(function($item){
            return $item->from_time.$item->to_time;
        });

        if($intersect > 0 ){
            return self::mergeTheseTime($temp_period);
        }else{
            return $temp_period;
        }
    }

    public static function checkIntersect($current_work_time,$work_time_list){
        $intersect = $work_time_list->filter(function($work_time) use($current_work_time){
            $from_time = $current_work_time->from_time;
            $to_time = $current_work_time->to_time;
            $condition1 = $from_time < $work_time->from_time && $work_time->from_time < $to_time &&
                          $from_time < $work_time->to_time && $to_time < $work_time->to_time;
            $condition2 = $from_time < $work_time->to_time && $work_time->to_time < $to_time &&
                          $from_time > $work_time->from_time && $to_time > $work_time->from_time;
            $condition3 = $from_time >= $work_time->from_time && $from_time <= $work_time->to_time &&
                          $to_time <= $work_time->to_time && $to_time >= $work_time->from_time;
            $condition4 = $current_work_time->id == $work_time->id;
            if($condition1 || $condition2 || $condition3 || $condition4){
                return $work_time;
            }
        });
        $min = $intersect->min('from_time');
        $max = $intersect->max('to_time');
        $intersectOrNot = 0;

        if($intersect->count() > 1){
            $intersectOrNot = 1;
        }else if($intersect->count() == 1){
            $intersectOrNot = 0;
        }

        $obj = new \stdClass;
        $obj->id = $current_work_time->id;
        $obj->intersect = $intersectOrNot;
        $obj->from_time = $min;
        $obj->to_time = $max;
        return $obj;
    }

    public static function calculateSeconds($hhii){
        $time = explode(':',$hhii);
        $seconds = intval($time[0]) * 3600 + intval($time[1]) * 60;
        return $seconds;
    }

    public static function formatDate($ddmmyyyy){
      $date = explode('-',$ddmmyyyy);
      $date = $date[2].'-'.$date[1].'-'.$date[0];
      return $date;
    }

    public static function calculateHourOver24($hhii){
      $temp_ = explode(':', $hhii);
      if ($temp_[0] > 24) {
          $hhii = ($temp_[0] - 24) . ':' . $temp_[1] . ':' . $temp_[2];
      }
      return $hhii;
    }

    public static function yymmdd_to_ddmmyy($yymmdd){
      return date('d-m-Y',strtotime($yymmdd));
    }
}
