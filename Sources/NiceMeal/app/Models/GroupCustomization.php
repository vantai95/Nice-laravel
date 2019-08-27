<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupCustomization extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'group_customizations';

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
    protected $fillable = ['restaurant_id', 'group_id', 'customization_id', 'active'];

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
}
