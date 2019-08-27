<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSetting extends Model
{
    //

    const OBJECT_FILTER = [
      0 => "restaurant_work_times"
    ];

    protected $fillable = ['object_type','object_id','all_days','sun','mon','tue','wed','thu','fri',
                        'sat','all_times','period_type','from_date','to_date', 'restaurant_id', 'special_date','has_special_date'];


    public function time_setting_details(){
      return $this->hasMany('App\Models\TimeSettingDetail','time_setting_id');
    }
}
