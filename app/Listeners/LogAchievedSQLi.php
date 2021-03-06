<?php

namespace App\Listeners;

use App\Events\AchievedSQLi;
use App\Models\Attempt;
use App\Models\Challenge;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class LogAchievedSQLi
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
     * @param AchievedSQLi $event
     * @return void
     * @throws AuthorizationException
     */
    public function handle(AchievedSQLi $event)
    {
        $attempt = Attempt::create($event->attempt);

        Log::info("/guest from $attempt->ip_address visited $attempt->url and [AchievedSQLi] $attempt->payload");

        $challenge = new Challenge();
        $flag = $challenge->sqlInjection()->flag;
        throw new AuthorizationException("SQL Injection achieved! Flag=$flag");
    }
}
