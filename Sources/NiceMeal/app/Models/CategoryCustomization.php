<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryCustomization extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories_customizations';

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
    protected $fillable = ['restaurant_id', 'customization_id', 'category_id'];

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function customization() {
        return $this->belongsTo('App\Models\Customization', 'customization_id');
    }
}
