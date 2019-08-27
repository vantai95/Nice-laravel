<?php

namespace App\Mail;

use App\Models\ReviewToken;
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
use Session;

class OrderConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $restaurant;
    public $user_data;
    public $order;
    public $subject;
    public $confirmLink;
    public $order_delivery_info;
    public $order_customer_info;
    public $order_items;
    public $data;
    public $previousOrder;
    public $token;
    public $res_slug;
    public $orderNumb;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->order = Order::where("id",$data['order_id'])->first();
        $review_token = ReviewToken::where("order_id",$data['order_id'])->first();
        $this->token = $review_token->token;
        $order_id = $this->order->id;
        $this->restaurant = Restaurant::findOrFail($this->order->restaurant_id);
        $this->res_slug = Session::get('res')->res_Slug;
        $this->subject = '[Confirmed Order] From '.$this->restaurant->name_en.' restaurant';
        $this->order_customer_info = OrderCustomerInfo::where('order_id', '=', $order_id)->firstOrFail();
        $this->order_delivery_info = OrderDeliveryInfo::where('order_id', '=', $order_id)->firstOrFail();
        $this->order_items = OrderItem::where('order_id', '=', $order_id)->get();
        $this->data = $data;
        $this->previousOrder = Order::where('user_id', $this->order_customer_info->user_id)
                ->where('restaurant_id',$this->restaurant->id)
                ->count() - 1;
//        $this->previousOrder = Order::where('id', $previousId)
//            ->where('user_id', $this->order_customer_info->user_id)->first();
        $this->orderNumb = $this->order->order_number;
        \Log::info($this->orderNumb);
        \Log::info($this->previousOrder);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'),'Nice Meal')->subject($this->subject)->view('emails.order_confirmed');
    }
}
