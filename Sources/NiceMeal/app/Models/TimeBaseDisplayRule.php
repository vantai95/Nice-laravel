<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class TimeBaseDisplayRule extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_base_display_rules';

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
        'from_date', 'to_date', 'all_times', 'from_time', 'to_time','all_days'];

    /**
     * Get the users of role.
     */

    public function restaurants()
    {
        return $this->belongsTo('App\Models\Restaurant','restaurant_id');
    }

    public function checkThis(){
        $now = Carbon::now();

        $isDateAvail = $this->period_type == 0 || ($this->from_date <= $now->format('Y-m-d') && $now->format('Y-m-d') <= $this->to_date);
        $isDayNameAvail = $this->all_days == 1 || $this[Controller::WEEKNAME[$now->dayOfWeek]] == 1;
        $isTimeAvail = $this->all_times == 1 || (substr($this->from_time, 0, 5) <= $now->format('H:i') && $now->format('H:i') <= substr($this->to_time, 0, 5));
        return $isDateAvail && $isDayNameAvail && $isTimeAvail;
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function status()
    {
        if($this->active) {
            return __('admin.restaurants.statuses.active');
        }
        return __('admin.restaurants.statuses.inactive');
    }


    public function canDelete()
    {
        return !count($this->users) > 0;
    }
}
