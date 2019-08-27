<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewToken extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'review_tokens';

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
    protected $fillable = ['order_id', 'token', 'created_at'];



}
