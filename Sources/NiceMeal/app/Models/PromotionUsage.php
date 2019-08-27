<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionUsage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promotion_usages';

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
    protected $fillable = ['order_id', 'restaurant_id', 'promotion_id', 'promotion_value', 'free_item_id'];

    public function promotion() {
        return $this->belongsTo('App\Models\Promotion','promotion_id');
    }

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant','restaurant_id');
    }

    public static function fields() {
        $self = new PromotionUsage();
        return $self->fillable;
    }
    
}
