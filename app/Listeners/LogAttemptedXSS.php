<?php

namespace App\Listeners;

use App\Events\AttemptedXSS;
use App\Models\Attempt;
use Illuminate\Support\Facades\Log;

class LogAttemptedXSS
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
     * @param AttemptedXSS $event
     * @return void
     */
    public function handle(AttemptedXSS $event)
    {
        $name = $event->user ? $event->user->getOriginal('name') : 'guest';
        $attempt = Attempt::create($event->attempt);

        Log::info("/$name from $attempt->ip_address visited $attempt->url and /AttemptedXSS [$attempt->payload]");
    }
}
