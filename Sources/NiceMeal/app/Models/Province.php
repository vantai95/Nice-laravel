<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Province extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'provinces';

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
    protected $fillable = ['name_en', 'name_ja', 'type_en', 'type_ja'];

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

    public function districts(){
        return $this->hasMany('App\Models\District','province_id');
    }
}
