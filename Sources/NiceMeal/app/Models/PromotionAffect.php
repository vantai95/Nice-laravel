<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionAffect extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promotion_affects';

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
    protected $fillable = ['promotion_id', 'restaurant_id', 'dish_id', 'category_id'];

    public function promotion() {
        return $this->belongsTo('App\Models\Promotion','promotion_id');
    }

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant','restaurant_id');
    }

    public static function fields() {
        $self = new PromotionAffect();
        return $self->fillable;
    }
    
}
