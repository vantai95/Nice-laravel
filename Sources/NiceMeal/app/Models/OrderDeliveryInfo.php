<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class OrderDeliveryInfo extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_delivery_info';

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
    protected $fillable = ['restaurant_id', 'order_id', 'user_id', 'residence', 'full_address', 'province_id',
        'district_id', 'ward_id'];

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

}
