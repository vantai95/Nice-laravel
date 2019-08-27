<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'taxes';

    const TYPES = [
        'inclusive' => 0,
        'exclusive' => 1
    ];

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
    protected $fillable = ['restaurant_id', 'rate','type','aff_type', 'aff_id'];


    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
}
