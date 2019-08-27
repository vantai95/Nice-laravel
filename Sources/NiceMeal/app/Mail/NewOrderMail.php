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

use Illuminate\Support\Facades\File;
use Log, Auth, Session;
class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $restaurant;
    public $user_data;
    public $order;
    public $subject;
    public $confirmLink;
    public $rejectLink;
    public $order_delivery_info;
    public $order_customer_info;
    public $order_items;
    public $sendToAdmin;
    public $previousOrder;
    public $orderNumb;
    public $previousId;
    public $previousOrderNumb;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_data,$restaurant,$order_id, $sendToAdmin,$link)
    {
        //
        $this->restaurant = $restaurant;
        $this->user_data = $user_data;
        $this->order = Order::where("id",$order_id)->first();
        $this->subject = '[New Order] From '.$this->restaurant->name_en.' restaurant';
        $this->confirmLink = $link['confirm'];
        $this->rejectLink = $link['reject'];
        $this->order_customer_info = OrderCustomerInfo::where('order_id', '=', $order_id)->firstOrFail();
        $this->order_delivery_info = OrderDeliveryInfo::where('order_id', '=', $order_id)->firstOrFail();
        $this->order_items = OrderItem::where('order_id', '=', $order_id)->get();
        $this->sendToAdmin = $sendToAdmin;
        $this->previousOrder = Order::where('user_id', $this->order_customer_info->user_id)
                ->where('restaurant_id',$this->restaurant->id)
                ->count() - 1;
//        $this->previousOrder = Order::where('id', $this->previousId)
//            ->where('user_id', $this->order_customer_info->user_id)->first();
        $this->orderNumb = $this->order->order_number;
        Log::info($this->previousOrder);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'),'Nice Meal')->subject($this->subject)->view('emails.new_order');

    }
}
