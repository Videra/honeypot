<?php

namespace App\Listeners;

use App\Events\AttemptedBrokenAccessControl;
use App\Models\Attempt;
use Illuminate\Support\Facades\Log;

class LogAttemptedBrokenAccessControl
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param AttemptedBrokenAccessControl $event
     * @return void
     */
    public function handle(AttemptedBrokenAccessControl $event)
    {
        $attempt = Attempt::create($event->attempt);

        Log::info("guest AttemptedBrokenAccessControl from IP $attempt->ip_address via URL $attempt->url with PAYLOAD $attempt->payload");
    }
}
