<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\CustomerSignUp;
use Mail;

class CustomerSignupEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->data = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $email = new CustomerSignUp;
        Mail::to($this->data['customer']->email)
        ->send(new CustomerSignUp($this->data));
    }
}
