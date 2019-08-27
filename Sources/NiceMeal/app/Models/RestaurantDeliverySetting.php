<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantDeliverySetting extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restaurant_delivery_settings';

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
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
    protected $fillable = ['restaurant_id', 'district_id', 'delivery_cost', 'min_order_amount', 'from', 'to', 'parent_id','ward_id','time'];

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

    public function restaurants()
    {
        return $this->belongsTo('App\Models\Restaurant','restaurant_id');
    }

    public function districts()
    {
        return $this->belongsTo('App\Models\District','district_id');
    }


}
