<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionRule extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'commission_rules';

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
    protected $fillable = ['restaurant_id', 'level', 'total_from', 'total_to', 'rate'];

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
}
