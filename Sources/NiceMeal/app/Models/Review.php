<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reviews';

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
    protected $fillable = ['order_id', 'customer_id', 'restaurant_id','food_rate','service_rate','comment','status','published','confirm_token','problem_solve_token'];

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    const REVIEW_STATUS = [
        'new' => 0,
        'received' => 1,
        'confirmed' => 2,
        'solved' => 3,
        'reported' => 4
    ];

    public function status()
    {
        if($this->status == 0) {
            return __('admin.reviews.statuses.new');
        } else if ($this->status == 1) {
            return __('admin.reviews.statuses.received');
        } else if ($this->status == 2) {
            return __('admin.reviews.statuses.confirmed');
        } else if ($this->status == 3) {
            return __('admin.reviews.statuses.solved');
        } else {
            return __('admin.reviews.statuses.reported');
        }
    }

    public function getStatus($status)
    {
        if($status == 0) {
            return __('admin.reviews.statuses.new');
        } else if ($status == 1) {
            return __('admin.reviews.statuses.received');
        } else if ($status == 2) {
            return __('admin.reviews.statuses.confirmed');
        } else if ($status == 3) {
            return __('admin.reviews.statuses.solved');
        } else {
            return __('admin.reviews.statuses.reported');
        }
    }

    public function status_class()
    {
        if($this->status == 0){
            return 'm-badge--info';
        } else if ($this->status == 1) {
            return 'm-badge--info';
        } else if ($this->status == 2) {
            return 'm-badge--success';
        } else if ($this->status == 3) {
            return 'm-badge--warning';
        } else {
            return 'm-badge--danger';
        }
    }


}
