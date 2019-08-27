<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Customization extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customizations';

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];

    const SELECTION_TYPE = [
        'single_choice' => 1,
        'multiple_choice' => 2
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
    protected $fillable = ['restaurant_id', 'name_en', 'title_ja', 'name_ja', 'description_en', 'description_ja', 'price',
        'active', 'required', 'has_options', 'selection_type', 'max_quantity', 'min_quantity','quantity_changeable'];

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

    public function options(){
        return $this->hasMany('App\Models\CustomizationOption','customization_id','id');
    }

    public function categoryCustomizations(){
        return $this->hasMany('App\Models\CategoryCustomization','customization_id','id');
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

}
