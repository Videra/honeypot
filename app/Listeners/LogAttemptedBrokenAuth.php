<?php

namespace App\Listeners;

use App\Events\AttemptedBrokenAuth;
use App\Models\Attempt;
use Illuminate\Support\Facades\Log;

class LogAttemptedBrokenAuth
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
     * @param  AttemptedBrokenAuth $event
     * @return void
     */
    public function handle(AttemptedBrokenAuth $event)
    {
        $name = $event->user ? $event->user->getOriginal('name') : 'guest';
        $attempt = Attempt::create($event->attempt);

        Log::info("$name AttemptedMassAssignment from IP $attempt->ip_address via URL $attempt->url with PAYLOAD $attempt->payload");
    }
}
