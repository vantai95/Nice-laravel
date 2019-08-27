<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class DishCategory extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dishes_categories';

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
    protected $fillable = ['restaurant_id', 'category_id', 'dish_id'];

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant','restaurant_id');
    }

    public function dishes() {
        return $this->belongsTo('App\Models\Dish','dish_id');
    }

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
