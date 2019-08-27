<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class OrderItemCustomization extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_items_customizations';

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
    protected $fillable = ['restaurant_id', 'order_id', 'order_item_id', 'customization_id', 'customization_option_id',
        'price', 'quantity'];

    public function status()
    {
        if($this->active) {
            return __('admin.restaurants.statuses.active');
        }
        return __('admin.restaurants.statuses.inactive');
    }

    public function order_item(){
        return $this->belongsTo(OrderItem::class,'order_item_id');
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

}
