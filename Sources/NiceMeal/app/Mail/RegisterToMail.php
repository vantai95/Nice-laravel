<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterToMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $verify_url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $verify_url)
    {
        $this->data = $data;
        $this->verify_url = $verify_url;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'),'Nice Meal')->subject('Confirm register !')->view('emails.auth.register');
    }

}
