<?php

namespace App\Listeners;

use App\Events\AchievedSQLi;
use App\Events\AttemptedSQLi;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

/**
 * @property Agent $agent
 * @property string $userAgent
 * @property bool|string $device
 * @property bool|string $browser
 * @property string $url
 * @property string|null $ip
 */
class LogAuthenticationAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->agent = new Agent();
        $this->agent->setUserAgent(Request::userAgent());
        $this->browser = $this->agent->browser();
        $this->device = $this->agent->device();
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
        Log::info("/guest /AuthenticationAttempt from IP $this->ip via URL $this->url");

        if (is_sql_injection($event->credentials['name'])) {

            event(new AttemptedSQLi(null, $event->credentials['name']));

        } elseif (is_challenge_sql_injection($event->credentials['name'])) {

            event(new AchievedSQLi(null, $event->credentials['name']));

        }
    }
}
