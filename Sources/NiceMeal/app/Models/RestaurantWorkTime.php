<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class RestaurantWorkTime extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restaurant_work_times';

    public $timestamps = true;

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];
    const DAY_FILTER = [
        'Monday' => 'Monday',
        'Tuesday' => 'Tuesday',
        'Wednesday' => 'Wednesday',
        'Thursday' => 'Thursday',
        'Friday' => 'Friday',
        'Saturday' => 'Saturday',
        'Sunday' => 'Sunday'
    ];
    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['restaurant_id',
     // 'all_days', 'sun', 'mon', 'tue', 'wed', 'thu',
     //                      'fri', 'sat', 'all_times', 'from_time', 'to_time','period_type','from_date','to_date'
      ];

    public function status()
    {
        if($this->active) {
            return __('admin.restaurants.statuses.active');
        }
        return __('admin.restaurants.statuses.inactive');
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name_en'
            ]
        ];
    }

    public function time_setting(){
      return $this->hasOne('App\Models\TimeSetting','object_id')->where('object_type','=',$this->table);
    }

    public function getTable(){
      return $this->table;
    }

    public function imageUrl()
    {
        if (!empty($this->image) && File::exists(public_path(config('constants.UPLOAD.RESTAURANT_IMAGE')) . '/' . $this->image)) {
            return asset(config('constants.UPLOAD.RESTAURANT_IMAGE') . '/' . $this->image);
        }
        return url(config('constants.DEFAULT.RESTAURANT_IMAGE'));
    }
}
