<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeBasePricingAffect extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_base_pricing_affects';

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
    protected $fillable = ['restaurant_id', 'rule_id', 'category_id', 'dish_id'];

    /**
     * Get the users of role.
     */

    public function restaurants()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function canDelete()
    {
        return !count($this->users) > 0;
    }
}
