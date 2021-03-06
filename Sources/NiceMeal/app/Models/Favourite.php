<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favourites';

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
    protected $fillable = ['restaurant_id', 'user_id'];

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
}
