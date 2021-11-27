<?php

namespace App\Listeners;

use App\Events\AchievedSQLi;
use App\Events\AttemptedSQLi;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogAuthenticationAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->ip = Request::ip();
        $this->url = Request::url();
    }

    /**
     * Handle the event.
     *
     * @param Attempting $event
     * @return void
     */
    public function handle(Attempting $event)
    {
        Log::info("/guest from $this->ip visited $this->url and AuthenticationAttempt");

        if (is_sql_injection($event->credentials['name'])) {

            event(new AttemptedSQLi(null, $event->credentials['name']));

        } elseif (is_challenge_sql_injection($event->credentials['name'])) {

            event(new AchievedSQLi(null, $event->credentials['name']));

        }
    }
}
