<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     * data is mail information array
     * data =  ['email' => 'example.email_domain',
     *          'name' => 'Your Name',
     *          'subject' => 'Your subject'.
     *          'view_path' => 'view path'
     *         ]
     */
    public function __construct($data)
    {
        $this->data['email'] = array_key_exists('email', $data) ? $data['email'] : env('MAIL_FROM_ADDRESS');
        $this->data['name'] = array_key_exists('name', $data) ? $data['name'] : env('MAIL_FROM_NAME');
        $this->data['subject'] = $data['subject'];
        $this->data['user_name'] = array_key_exists('user_name', $data) ? $data['user_name'] : '';
        $this->data['message'] = array_key_exists('message', $data) ? $data['message'] : '';
        $this->data['view_path'] = $data['view_path'];
    }

    /**
     * Build the mail.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->data['view_path'], ['message' => $this->data['message']])
            ->from($this->data['email'], $this->data['name'])
            ->subject($this->data['subject']);
    }
}
