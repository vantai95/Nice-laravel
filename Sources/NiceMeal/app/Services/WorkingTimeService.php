<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\RestaurantWorkTime;

class WorkingTimeService{

  protected $timeSettingService;

  public function __construct(TimeSettingService $timeSettingService){
    $this->timeSettingService = $timeSettingService;
  }
    //This is for api
    public static function getWorkingTime($restaurant){
        $workingTime = $restaurant->restaurantWorkTimes()->with('time_setting.time_setting_details')->select('id','restaurant_id','all_days',
        'sun','mon','tue','wed','thu','fri','sat','all_times','from_time','to_time')
        ->get();
        $fn_workingTime = [];
        foreach(Controller::WEEKNAME as $day){
            $fn_workingTime[$day] = [];
            foreach($workingTime as $wt){
                if($wt->time_setting->{$day}){
                  foreach($wt->time_setting->time_setting_details as $detail){
                    array_push($fn_workingTime[$day],[
                        'from_time' => $detail->from_time,
                        'to_time' => $detail->to_time,
                    ]);
                  }
                }
            }
        }
        return $fn_workingTime;
    }

    public function createWorkingTime($data,$restaurant){
      $working_time_data = [
        'restaurant_id' => $restaurant->id
      ];
      $working_time = RestaurantWorkTime::create($working_time_data);

      $this->timeSettingService->createTimeSetting($data,$working_time,$restaurant);
    }

    public function updateWorkingTime($workingTime,$data,$restaurant){
      $this->timeSettingService->updateTimeSetting($data,$workingTime->time_setting,$restaurant);
    }

    public function setUpInputData($data){


      return $data;
    }

}
