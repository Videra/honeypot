<?php

namespace App\Listeners;

use App\Events\AttemptedSQLi;
use App\Models\Attempt;
use Illuminate\Support\Facades\Log;

class LogAttemptedSQLi
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
     * @param AttemptedSQLi $event
     * @return void
     */
    public function handle(AttemptedSQLi $event)
    {
        $name = $event->user ? $event->user->getOriginal('name') : 'guest';
        $attempt = Attempt::create($event->attempt);

        Log::info("/$name from $attempt->ip_address visited $attempt->url and /AttemptedSQLi using [$attempt->payload]");
    }
}
