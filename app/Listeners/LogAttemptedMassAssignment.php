<?php

namespace App\Listeners;

use App\Events\AttemptedMassAssignment;
use App\Models\Attempt;
use Illuminate\Support\Facades\Log;

class LogAttemptedMassAssignment
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
     * @param  AttemptedMassAssignment $event
     * @return void
     */
    public function handle(AttemptedMassAssignment $event)
    {
        $name = $event->user ? $event->user->getOriginal('name') : 'guest';
        $attempt = Attempt::create($event->attempt);

        Log::info("/$name /AttemptedMassAssignment from IP $attempt->ip_address via URL $attempt->url with PAYLOAD $attempt->payload");
    }
}
