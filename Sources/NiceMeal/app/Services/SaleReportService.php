<?php 
namespace App\Services;

use App\Services\DateTimeHandleService;
use App\Models\RestaurantWorkTime;
use App\Http\Controllers\Controller;
use App\Models\Order;

class SaleReportService {

    public static function getReport ($from_date, $to_date, $restaurant){
        $total_day = ((strtotime($to_date) - strtotime($from_date))/86400) + 1;

        $total_dayOfWeek = DateTimeHandleService::calculateDayInWeek(strtotime($from_date),strtotime($to_date));
        
        $work_times_input = RestaurantWorkTime::where('restaurant_id','=',$restaurant->id)->get();
        $orders = Order::where('restaurant_id','=',$restaurant->id)->whereDate("created_at",">=",$from_date)
        ->whereDate("created_at","<=",$to_date)
        ->get();

        $work_times_output = [];
        $total_hour = 0;
        foreach(Controller::WEEKNAME as $day_key => $day){
            if(isset($total_dayOfWeek[$day_key])){
                if(!isset($work_times_output[$day])){
                    $work_times_output[$day] = [];
                    $work_times_output[$day]['active'] = 0;
                    $work_times_output[$day]['total_time'] = 0;
                    $work_times_output[$day]['work_time_period'] = [];
                }
                $temp_period = [];
                foreach($work_times_input as $work_time){
                    if($work_time->{$day}){
                        $work_times_output[$day]['active'] = $work_time->{$day} || $work_times_output[$day]['active'];
                        $temp_period[$work_time->id] = $work_time;
                    }
                }
                $work_times_output[$day]['work_time_period'] = DateTimeHandleService::mergeTheseTime($temp_period);
    
                if(!$work_times_output[$day]['active']){
                    $total_day -= $total_dayOfWeek[$day_key];
                    unset($work_times_output[$day]);
                } else{
                    $work_times_output[$day]['total_time'] = DateTimeHandleService::calculateTotalHour($work_times_output[$day]['work_time_period']);
                    $total_hour += $work_times_output[$day]['total_time'];
                }
            }
        }
        $accepted = $orders->filter(function($item){
            return $item->status == 3;
        });
        $accepted_total = $accepted->sum('total_amount');
        $accepted_quantity = $accepted->count();

        $rejected = $orders->filter(function($item){
            return $item->status == 4;
        });
        $rejected_total = $rejected->sum('total_amount');
        $rejected_quantity = $rejected->count();

        $total_sale = $accepted_total + $rejected_total;
        $order_quantity = $accepted_quantity + $rejected_quantity;

        $working_day_total = $total_day;
        $working_hour_total = $total_hour;

        $order_per_day  = ($working_day_total == 0 ) ? 0 : round($order_quantity/$working_day_total,2);
        $order_per_hour =  ($working_hour_total == 0 ) ? 0 : round($order_quantity/$working_hour_total,2);

        $average_value = ($total_sale == 0 && $order_quantity == 0) ? 0 : round($total_sale/$order_quantity);
        
        $report = [
            'accepted_total' => number_format($accepted_total, 0, ',', '.') . " VNĐ",
            'accepted_quantity' => $accepted_quantity,
            'rejected_total' => number_format($rejected_total, 0, ',', '.') . " VNĐ",
            'rejected_quantity' => $rejected_quantity,
            'total_sale' => number_format($total_sale, 0, ',', '.') . " VNĐ",
            'order_quantity' => $order_quantity,
            'average_value' => number_format($average_value, 0, ',', '.') . " VNĐ",
            'working_day_total' => $working_day_total,
            'working_hour_total' => $working_hour_total,
            'order_per_day' => $order_per_day,
            'order_per_hour' => $order_per_hour
        ];
        return $report;
    }

}