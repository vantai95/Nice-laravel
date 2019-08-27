<?php

namespace App\Models;

use Carbon\Carbon;

use App\Models\PromotionAvailableTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Controller;
use App\Models\TimeSetting;
use App\Services\TimeSettingService;

class Promotion extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promotions';

    public $timestamps = true;

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];

    const PROMOTION_TYPES = [
        '%' => 0,
        'value' => 1,
        'free_item' => 2
    ];

    const PROMOTION_APPLY_TO = [
        'BY MENU' => 0,
        'BY CATEGORY' => 1,
        'BY ITEM' => 2,
        'BY BILL' => 3
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
    protected $fillable = ['name_en', 'name_ja', 'description_en', 'description_ja', 'image', 'promotion_code', 'restaurant_id', 'is_global', 'type' , 'value', 'free_item', 'created_by', 'maximun_discount', 'number_usage', 'apply_to', 'min_order_value', 'max_order_value', 'item_value_from', 'item_value_to', 'status', 'include_request'];

    public function status()
    {
        return ($this->status) ? __('admin.promotions.statuses.active') : __('admin.promotions.statuses.inactive');
    }

    public function isAvailable() {
        $timeSetting = TimeSetting::where('object_id','=',$this->id)
        ->where('object_type','=',$this->table)->with('time_setting_details')->first();
        if($timeSetting != null){
          return TimeSettingService::checkTimeSetting($timeSetting);
        }else{
          return false;
        }
    }

    public function status_class()
    {
        if ($this->status) {
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function time_setting(){
      return $this->hasOne('App\Models\TimeSetting','object_id')->where('object_type','=',$this->table);
    }

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant','restaurant_id');
    }

    public function promotion_affects(){
        return $this->hasMany('App\Models\PromotionAffect');
    }

    function isValid($promoCode=NULL) {
        return $promoCode ? (strtolower($this->promotion_code)==strtolower($promoCode) && $this->isAvailable()) : $this->isAvailable();
    }

    public function getTable(){
      return $this->table;
    }
}
