<?php

namespace App\Listeners;

use App\Events\AchievedMassAssignment;
use App\Models\Attempt;
use App\Models\Challenge;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class LogAchievedMassAssignment
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
     * @param AchievedMassAssignment $event
     * @return void
     * @throws AuthorizationException
     */
    public function handle(AchievedMassAssignment $event)
    {
        $name = $event->user ? $event->user->getOriginal('name') : 'guest';
        $attempt = Attempt::create($event->attempt);

        Log::info("/$name from $attempt->ip_address visited $attempt->url and [AchievedMassAssignment] $attempt->payload");

        $challenge = new Challenge();
        $flag = $challenge->massAssignment()->flag;
        throw new AuthorizationException("Mass Assignment achieved! Flag=$flag");
    }
}
