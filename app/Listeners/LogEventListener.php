<?php

namespace App\Listeners;

use App\Events\LogEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\{
    LogModel
}
use Log;

class LogEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // Log::info('hey something just happened in listener');
        // dd('inside listener construct');
    }

    /**
     * Handle the event.
     *
     * @param  LogEvent  $event
     * @return void
     */
    public function handle(LogEvent $event)
    {
        // dd('inside listener');
        LogModel::insert($event);
    }
}
