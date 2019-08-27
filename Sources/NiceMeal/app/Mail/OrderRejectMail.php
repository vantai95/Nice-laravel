<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;
use App\Models\OrderCustomerInfo;
use App\Models\OrderDeliveryInfo;
use App\Models\OrderItem;
use App\Models\UserCustomerInfo;
use App\Models\OrderItemCustomization;
use App\Models\Restaurant;
use Log;

class OrderRejectMail extends Mailable
{
    use Queueable, SerializesModels;
    public $restaurant;
    public $user_data;
    public $order;
    public $reject_subject;
    public $confirmLink;
    public $order_delivery_info;
    public $order_customer_info;
    public $order_items;
    public $data;
    public $sendToAdmin;
    public $orderLink;
    public $contactLink;
    public $resName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$sendToAdmin, $subject)
    {
        //
        $this->order = Order::where("id",$data['order_id'])->first();
        $order_id = $this->order->id;
        $this->restaurant = Restaurant::findOrFail($this->order->restaurant_id);
//        $this->reject_subject = '[Cancelled Order] From '.$this->restaurant->name_en.' restaurant';
        $this->subject = $subject;
        $this->order_customer_info = OrderCustomerInfo::where('order_id', '=', $order_id)->firstOrFail();
        $this->data = $data;
        $this->sendToAdmin = $sendToAdmin;
        $this->orderLink = url('/');
        $this->contactLink = url('/contact-us');
        $this->resName = $this->restaurant->name_en;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::debug($this->subject);
        return $this->from(env('MAIL_FROM_ADDRESS'),'Nice Meal')->subject($this->subject)->view('emails.order_rejected');
    }
}
