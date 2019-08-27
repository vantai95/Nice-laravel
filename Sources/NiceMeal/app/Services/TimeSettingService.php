<?php

namespace App\Services;
use App\Models\TimeSetting;
use App\Models\TimeSettingDetail;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TimeSettingService{

  // public const VALIDATE_

  public static function createTimeSetting($data,$object,$restaurant){


    $timeSettingData = self::initInputData($data,$object,$restaurant);
    $time_setting = TimeSetting::create($timeSettingData);
    if(!$data['all_times']){
      self::createTimeSettingDetail($data['specific_time'],$time_setting);
    }

  }

  public static function createTimeSettingDetail($data,$time_setting){
    $time_setting_detail_data = [];
    foreach($data as $time_detail){
      $row = [
        'time_setting_id' => $time_setting->id,
        'from_time' => $time_detail['from_time'],
        'to_time' => self::validateTime($time_detail['from_time'],$time_detail['to_time'])
      ];
      array_push($time_setting_detail_data,$row);
    }
    TimeSettingDetail::insert($time_setting_detail_data);
  }

  public static function updateTimeSetting($data,$time_setting,$restaurant){

    $timeSettingData = self::initInputData($data,null,$restaurant,"update");
    $time_setting->update($timeSettingData);
    if(!$data['all_times']){
      self::updateTimeSettingDetail($data['specific_time'],$time_setting);
    }else{
      $time_setting->time_setting_details()->delete();
    }

  }

  public static function updateTimeSettingDetail($data,$time_setting){
    $current_ids = $time_setting->time_setting_details->pluck('id');
    $update_ids = array_keys($data);

    //Get deleted time setting and delete them
    $time_setting->time_setting_details()->whereIn('id',$current_ids)->whereNotIn('id',$update_ids)->delete();

    //Get new time setting detail and create them
    $new_item_data = collect($data)->filter(function($item,$key) use ($current_ids){
      return !$current_ids->contains($key);
    });
    self::createTimeSettingDetail($new_item_data,$time_setting);

    //Update remain detail
    $remain_detail = $time_setting->time_setting_details->whereIn('id',$current_ids)->whereIn('id',$update_ids);
    foreach($remain_detail as $detail){
      $data[$detail->id]['to_time'] = self::validateTime($data[$detail->id]['from_time'],$data[$detail->id]['to_time']);
      $detail->update($data[$detail->id]);
    }
  }

  public static function initInputData($data,$object = null,$restaurant = null,$method = "create"){

    if(array_key_exists('has_special_date',$data) && $data['has_special_date']){
      $data['period_type'] = 0;
      $data['from_date'] = null;
      $data['to_date'] = null;
      $data['special_date'] = DateTimeHandleService::formatDate($data['special_date']);
      $data = self::initDefaultValueForDateInWeek($data,false);
      $data['all_days'] = 0;
    }else if(array_key_exists('period_type',$data) && $data['period_type']){
      $data['has_special_date'] = 0;
      $data['special_date'] = null;
      $from_date = DateTimeHandleService::formatDate($data['from_date']);
      $to_date = DateTimeHandleService::formatDate($data['to_date']);
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $data = self::initDefaultValueForDateInWeek($data,false);
      $data['all_days'] = 0;
    }else{
      $data['from_date'] = null;
      $data['to_date'] = null;
      $data['special_date'] = null;
      if ($data['all_days'] == 1) {
          $data = self::initDefaultValueForDateInWeek($data,true);
      }else{

        foreach(Controller::WEEKNAME as $date){
          if(array_key_exists($date,$data) && $data[$date] != null){
            $data[$date] = true;
          }else{
            $data[$date] = false;
          }
        }
      }
    }


    if($method == "create"){
      $data['restaurant_id'] = $restaurant->id;
      $data['object_type'] = $object->getTable();
      $data['object_id'] = $object->id;
    }
    unset($data['specific_time']);
    return $data;
  }

  public static function initDefaultValueForDateInWeek($data,$value = false){
    foreach(Controller::WEEKNAME as $date){
      $data[$date] = $value;
    }

    return $data;
  }

  public static function checkTimeSetting($timeSetting){
    if($timeSetting != null){
      $specialDayAvail = ($timeSetting->has_special_date) ? ($timeSetting->special_date === date('Y-m-d')) : 0;
      $dayAvail = $timeSetting->all_days == 1 || $timeSetting->{Controller::WEEKNAME[date('w')]} == 1 || $specialDayAvail;
      $timeAvil = $timeSetting->all_times == 1 || self::checkTimeSettingDetail($timeSetting->time_setting_details);

      return $dayAvail && $timeAvil;
    }else{
      return false;
    }

  }

  public static function checkTimeSettingDetail($timeSettingDetails){
    $result = false;
    foreach($timeSettingDetails as $detail){
          if($detail->to_time > "24:00:00"){
            $fromTimeSeconds = DateTimeHandleService::calculateSeconds($detail->from_time);
            $nowSeconds = DateTimeHandleService::calculateSeconds(date('H:i'));
            $toTimeSeconds = DateTimeHandleService::calculateSeconds($detail->to_time);
            if($nowSeconds + (24 * 60 * 60) < $toTimeSeconds ){
              $nowSeconds = DateTimeHandleService::calculateSeconds(date('H:i')) + (24 * 60 * 60);
            }
            $specificTimeAvail = $fromTimeSeconds <= $nowSeconds && $nowSeconds <= $toTimeSeconds;
          }else{
            $specificTimeAvail = (substr($detail->from_time, 0, 5) <= date('H:i') && date('H:i') <= substr($detail->to_time, 0, 5));
          }
          $result = $result || $specificTimeAvail;
    }
    return $result;
  }

  public static function validateTime($from_time,$to_time){
    if(DateTimeHandleService::calculateSeconds($from_time) >= DateTimeHandleService::calculateSeconds($to_time)){
      $to_time = explode(':',$to_time);
      $to_time = ($to_time[0] + 24). ':'.$to_time[1];
    }
    return $to_time;
  }
}
