<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;

class ReviewReceivedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $resData;
    public $userData;
    public $orderData;
    public $subject;
    public $reviewData;
    public $problemSolveLink;
    public $confirmLink;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData,$orderData,$resData)
    {
        \Log::info($resData);
        $this->resData = $resData;
        $this->orderData = $orderData;
        $this->userData = $userData;
        $this->reviewData = Review::where('order_id',$this->orderData->id)->first();
        $this->subject = '[NEW REVIEW] - For '.$this->resData->name_en.' restaurant';
        $this->problemSolveLink = '/reviews/send-problem-solved/'.$this->reviewData->problem_solve_token;
        $this->confirmLink = '/reviews/confirm-review/'.$this->reviewData->confirm_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'),'Nice Meal')->subject($this->subject)->view('emails.review_received');
    }
}
