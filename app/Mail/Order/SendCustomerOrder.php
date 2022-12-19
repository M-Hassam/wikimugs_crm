<?php

namespace App\Mail\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCustomerOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from('no-reply@mail.com', 'Order Completion')
        ->view('emails.order_complete');
        foreach ($this->data['order_files'] as $file){
            $this->attach(public_path('uploads/files/'.$file->file));
        }
        return $this;
    }
}
