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

        Log::info("guest AchievedSQLi from IP $attempt->ip_address via URL $attempt->url with PAYLOAD $attempt->payload");

        $challenge = new Challenge();
        $flag = $challenge->sqlInjection()->flag;
        throw new AuthorizationException("SQL Injection achieved! Flag=$flag");
    }
}
