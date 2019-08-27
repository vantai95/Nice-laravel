<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionAvailableTime extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promotions_available_times';

    public $timestamps = true;

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
    protected $fillable = ['promotion_id', 'all_days', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat' , 'all_times',
    'period_type','from_date','to_date', 'from_time', 'to_time'];

    public function promotion() {
        return $this->belongsTo('App\Models\Promotion','promotion_id');
    }

    public static function fields() {
        $self = new PromotionAvailableTime();
        return $self->fillable;
    }

}
