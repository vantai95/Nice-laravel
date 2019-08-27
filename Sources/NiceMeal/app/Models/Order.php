<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Order extends Model
{   

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    const OTP_PREFIX = "NM-";

    const STATUS_FILTER = [
        0 => [
            'name'=>'New',
            'color'=>'#36a3f7',
            'value'=>0,
            'raw_value'=>'new'
        ],
        1 => [
            'name'=>'Received',
            'color'=>'#36a3f7',
            'value'=>1,
            'raw_value'=>'received'
        ],
        2 => [
            'name'=>'Admin Accepted',
            'color'=>'#36a3f7',
            'value'=>2,
            'raw_value'=>'admin_accepted'
        ],
        3 => [
            'name'=>'Accepted',
            'color'=>'#36a3f7',
            'value'=>3,
            'raw_value'=>'accepted'
        ],
        4 => [
            'name'=>'Rejected',
            'color'=>'#36a3f7',
            'value'=>4,
            'raw_value'=>'rejected'
        ],
        5 => [
            'name'=>'Going',
            'color'=>'#36a3f7',
            'value'=>5,
            'raw_value'=>'going'
        ],
        6 => [
            'name'=>'Delivered',
            'color'=>'#36a3f7',
            'value'=>6,
            'raw_value'=>'delivered'
        ],
        7 => [
            'name'=>'Finished',
            'color'=>'#36a3f7',
            'value'=>7,
            'raw_value'=>'finished'
        ],
        8 => [
            'name'=>'Canceled',
            'color'=>'#36a3f7',
            'value'=>8,
            'raw_value'=>'canceled'
        ],
        9 => [
            'name'=>'Payment Fail',
            'color'=>'#36a3f7',
            'value'=>9,
            'raw_value'=>'payment_fail'
        ]
    ];

    const DELIVERY_TIME = [
        'asap'=>'As soon as possible',
        '15' => 'After 15 minutes',
        '30' => 'After 30 minutes',
        '45' => 'After 45 minutes',
        'other' => 'Other'
    ];

    const ORDER_STATUS = [
        'new' => 0,
        'received' => 1,
        'admin_accepted' => 2,
        'accepted' => 3,
        'rejected' => 4,
//        'going' => 5,
//        'delivered' => 6,
        'finished' => 7,
        'canceled' => 8,
        'payment_fail' => 9
    ];

    const PAYMENT_METHOD = [
        'ONLINE_PAYMENT' => 'online_payment',
        'COD_PAYMENT' => 'cod_payment',
    ];

    const SERVICES = [
        'DELIVERY' => 'delivery',
        'PICKUP' => 'pickup',
    ];

    const CUSTOMER_STATUS =[
        'new'=>[
            'name'=>'New',
            'from'=>0,
            'to'=>10
        ]
    ];
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
    protected $fillable = ['order_number', 'restaurant_id',	'user_id', 'total_amount', 'sub_total_amount', 'discount',
        'tax', 'shipping_fee', 'status', 'payment_method', 'order_type', 'delivery_time', 'notes', 'reject_reason',
        'promotion_id', 'amount_user_have','otp','otp_verified','admin_order_note','otp_expired_at',
        'direction','tax_rate','tax_type','take_red_invoice','kitchen_accepted','confirm_delivery_time','cooking_time','final_delivery_time','admin_accepted_at','token','token_expired'];

    public function status()
    {
        if($this->status == 0) {
            return __('admin.orders.statuses.new');
        } else if ($this->status == 1) {
            return __('admin.orders.statuses.received');
        } else if ($this->status == 2) {
            return __('admin.orders.statuses.admin_accepted');
        } else if ($this->status == 3) {
            return __('admin.orders.statuses.accepted');
        } else if ($this->status == 4) {
            return __('admin.orders.statuses.rejected');
        } else if ($this->status == 5) {
            return __('admin.orders.statuses.going');
        } else if ($this->status == 6) {
            return __('admin.orders.statuses.delivered');
        } else if ($this->status == 7) {
            return __('admin.orders.statuses.finished');
        } else if ($this->status == 8){
            return __('admin.orders.statuses.canceled');
        } else {
            return __('admin.orders.statuses.payment_fail');
        }
    }

    public function getStatus($status)
    {
        if($status == 0) {
            return __('admin.orders.statuses.new');
        } else if ($status == 1) {
            return __('admin.orders.statuses.received');
        } else if ($status == 2) {
            return __('admin.orders.statuses.admin_accepted');
        } else if ($status == 3) {
            return __('admin.orders.statuses.accepted');
        } else if ($status == 4) {
            return __('admin.orders.statuses.rejected');
        } else if ($status == 5) {
            return __('admin.orders.statuses.going');
        } else if ($status == 6) {
            return __('admin.orders.statuses.delivered');
        } else if ($status == 7) {
            return __('admin.orders.statuses.finished');
        } else if ($status == 8){
            return __('admin.orders.statuses.canceled');
        } else {
            return __('admin.orders.statuses.payment_fail');
        }
    }

    public function status_class()
    {
        if($this->status == 0){
            return 'm-badge--info';
        } else if ($this->status == 1) {
            return 'm-badge--info';
        } else if ($this->status == 4) {
            return 'm-badge--warning';
        } else if ($this->status >= 2 && $this->status <= 7) {
            return 'm-badge--success';
        } else {
            return 'm-badge--danger';
        }
    }

    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }

    public function paymentMethodClass()
    {
        if($this->payment_method == 'COD')
            return 'm-badge--info';
        return 'm-badge--success';
    }

    public function totalAmountVND() {
        if($this->total_amount) {
            return number_format($this->total_amount,0). " VNĐ";
        }
        return "0 VNĐ";
    }

    public function order_customer_infos()
    {
        return $this->hasMany(OrderCustomerInfo::class);
    }

    public function deliveryTime(){
        if($this->delivery_time){
            return $this->delivery_time;
        }
        return "As Soon As Possible";
    }
}
