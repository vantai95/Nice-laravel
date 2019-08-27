<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeBasePricingRule extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_base_pricing_rules';

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
    protected $fillable = ['restaurant_id', 'name', 'active', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'period_type',
        'from_date', 'to_date', 'all_times', 'from_time', 'to_time', 'all_days', 'type', 'value', 'inscrease'];

    /**
     * Get the users of role.
     */

    public function restaurants()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function status_class()
    {
        if ($this->active) {
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function status()
    {
        if ($this->active) {
            return __('admin.time_base_pricing_rules.statuses.active');
        }
        return __('admin.time_base_pricing_rules.statuses.inactive');
    }

    public function type()
    {
        if ($this->type) {
            return __('admin.time_base_pricing_rules.select.price');
        }
        return __('admin.time_base_pricing_rules.select.percent');
    }

    public function inscrease() {
        return ($this->inscrease) ? __('admin.time_base_pricing_rules.select.increase')
            : __('admin.time_base_pricing_rules.select.decrease');
    }


    public function canDelete()
    {
        return !count($this->users) > 0;
    }
}
