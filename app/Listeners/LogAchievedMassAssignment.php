<?php

namespace App\Listeners;

use App\Events\AchievedMassAssignment;
use App\Events\AttemptedMassAssignment;
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

        Log::info("/$name /AchievedMassAssignment from IP $attempt->ip_address via URL $attempt->url with PAYLOAD $attempt->payload");

        $challenge = new Challenge();
        $flag = $challenge->massAssignment()->flag;
        throw new AuthorizationException("Mass Assignment achieved! Flag=$flag");
    }
}
