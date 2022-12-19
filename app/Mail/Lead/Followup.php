<?php

namespace App\Mail\Lead;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Followup extends Mailable
{
    use Queueable, SerializesModels;

    public $email_content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->email_content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('followup@website1.com', 'Follow up')
                ->view('emails.lead_followup');
    }
}
