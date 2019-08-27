<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class OrderTransaction extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_transactions';

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
    protected $fillable = ['order_id', 'order_number', 'restaurant_id', 'payment_mode', 'transaction_id', 'amount', 'status','note'];
}
