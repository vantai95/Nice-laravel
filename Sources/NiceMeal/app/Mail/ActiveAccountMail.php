<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActiveAccountMail extends Mailable
{
    use Queueable, SerializesModels;
    public $restaurant;
    public $userInfo;
    public $subject;
    public $accountToken;
    public $isTakeawayDomain;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userInfo,$restaurant,$accountToken, $isTakeawayDomain)
    {
        $this->accountToken = $accountToken;
        $this->restaurant = $restaurant;
        $this->userInfo = $userInfo;       
        $this->isTakeawayDomain = $isTakeawayDomain;
        if($this->isTakeawayDomain){
            $this->subject = '[ACTIVE ACCOUNT] From VnTakeaway.com';
        }else{
            $this->subject = '[ACTIVE ACCOUNT] From Nicemeal.com';
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->isTakeawayDomain){
            return $this->from(env('MAIL_FROM_ADDRESS'),'VnTakeaway')->subject($this->subject)->view('emails.active_account');
        }
        return $this->from(env('MAIL_FROM_ADDRESS'),'Nice Meal')->subject($this->subject)->view('emails.active_account');
        
    }
}
