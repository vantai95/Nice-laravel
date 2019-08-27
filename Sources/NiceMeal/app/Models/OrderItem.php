<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class OrderItem extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_items';

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
    protected $fillable = ['restaurant_id', 'order_id', 'dish_id', 'price', 'quantity', 'have_customization', 'free_item'];

    public function status()
    {
        if($this->active) {
            return __('admin.restaurants.statuses.active');
        }
        return __('admin.restaurants.statuses.inactive');
    }

    public function order_items_customizations(){
        return $this->hasMany(OrderItemCustomization::class);
    }
    
    public function dish(){
        return $this->belongsTo(Dish::class,'dish_id');
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

}
