<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class RestaurantCuisine extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restaurants_cuisines';

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
    protected $fillable = ['restaurant_id', 'cuisine_id'];

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
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

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name_en'
            ]
        ];
    }

    public function imageUrl()
    {
        if (!empty($this->image) && File::exists(public_path(config('constants.UPLOAD.RESTAURANT_IMAGE')) . '/' . $this->image)) {
            return asset(config('constants.UPLOAD.RESTAURANT_IMAGE') . '/' . $this->image);
        }
        return url(config('constants.DEFAULT.RESTAURANT_IMAGE'));
    }
}
