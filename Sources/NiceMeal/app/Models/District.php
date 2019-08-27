<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Sluggable;

use Session, Log;
use App\Services\CommonService;
use App\Services\PromotionService;
use App\Services\RestaurantService;

class District extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'districts';

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];

    protected $lang;

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

    protected $fillable = ['province_id', 'name_en', 'name_ja', 'type_en', 'type_ja', 'location','sequence'];


    public function __construct()
    {
        $this->lang = Session::get('locale');
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

    public function restaurantDeliverySetting(){
        return $this->hasMany('App\Models\RestaurantDeliverySetting','district_id');
    }

    public function imageUrl()
    {
        if (!empty($this->image) && File::exists(public_path(config('constants.UPLOAD.DISTRICT_IMAGE')) . '/' . $this->image)) {
            return asset(config('constants.UPLOAD.DISTRICT_IMAGE') . '/' . $this->image);
        }
        return url(config('constants.DEFAULT.DISTRICT_IMAGE'));
    }

    // $condition: query data conditions, is Object {'cuisines': [], 'categories': [], ...}. If null then return all
    // $sort: sort data condition , is Object {'key': keySort, 'direction': 'asc or desc'}. If null then return by default
    // @param  integer|null  $segIdx: index of segment

    public function wards(){
        return $this->hasMany('App\Models\Ward','district_id');
    }
}
