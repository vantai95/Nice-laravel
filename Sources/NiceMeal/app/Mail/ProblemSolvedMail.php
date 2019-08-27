<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProblemSolvedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $resData;
    public $review;
    public $subject;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($resData,$review)
    {
        $this->review = $review;
        $this->resData = $resData;
        $this->subject = '[PROBLEM SOLVED] - From '.$this->resData->name_en.' restaurant';
        $this->link = '/reviews/approve-solved/'.$this->review->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'),'Nice Meal')->subject($this->subject)->view('emails.problem_solved');

    }
}
