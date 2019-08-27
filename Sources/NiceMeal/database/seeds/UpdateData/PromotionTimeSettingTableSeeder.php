<?php

use Illuminate\Database\Seeder;
use App\Models\PromotionAvailableTime;
use App\Models\TimeSetting;
use App\Models\TimeSettingDetail;
use App\Services\TimeSettingService;

class PromotionTimeSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $availTime = PromotionAvailableTime::whereNull('from_time')->whereNull('to_time')->whereNull('deleted_at')->get();
        foreach($availTime as &$time){
          $time->object_id = $time->promotion_id;
          $time->object_type = "promotions";
          $time->has_special_date = 0;
          $time->special_date = null;
          unset($time->deleted_at);
          unset($time->from_time);
          unset($time->id);
          unset($time->to_time);
          unset($time->promotion_id);
        }

        $availTime = $availTime->toArray();
        foreach($availTime as &$time){
          $time = TimeSettingService::initInputData($time,null,null,"update");
        }
        TimeSetting::insert($availTime);

        $availTimeHasTime = PromotionAvailableTime::whereNotNull ('from_time')->whereNotNull ('to_time')->whereNull('deleted_at')->get();

        foreach($availTimeHasTime as &$time){
          $time->object_id = $time->promotion_id;
          $time->object_type = "promotions";
          $time->has_special_date = 0;
          $time->special_date = null;
          $detail['from_time'] = $time->from_time;
          $detail['to_time'] = $time->to_time;
          unset($time->id);
          unset($time->deleted_at);
          unset($time->from_time);
          unset($time->to_time);
          unset($time->promotion_id);
          $timeSettingData = $time->toArray();
          $timeSettingData = TimeSettingService::initInputData($timeSettingData,null,null,"update");
          $detail['time_setting_id'] = TimeSetting::create($timeSettingData)->id;
          TimeSettingDetail::create($detail);
        }


    }
}
