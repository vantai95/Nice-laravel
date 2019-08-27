<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckoutToMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $otp;
    public $restaurant;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$otp, $restaurant)
    {
        $this->data = $data;
        $this->otp = $otp;
        $this->restaurant = $restaurant;
        $this->subject = '[OTP Confirmed] From '. $restaurant->name_en. ' restaurant';
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'),'Nice Meal')->subject($this->subject)->view('emails.otp');
    }

}
