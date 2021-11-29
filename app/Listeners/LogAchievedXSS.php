<?php

namespace App\Listeners;

use App\Events\AchievedSQLi;
use App\Events\AchievedXSS;
use App\Models\Attempt;
use App\Models\Challenge;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class LogAchievedXSS
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
     * @param AchievedXSS $event
     * @return void
     * @throws AuthorizationException
     */
    public function handle(AchievedXSS $event)
    {
        $attempt = Attempt::create($event->attempt);

        Log::info("/guest from $attempt->ip_address visited $attempt->url and [AchievedXSS] $attempt->payload");

        $challenge = new Challenge();
        $flag = $challenge->xss()->flag;
        throw new AuthorizationException("XSS achieved! Flag=$flag");
    }
}
