<?php

namespace App\Listeners;

use App\Models\Challenge;
use Illuminate\Auth\Access\AuthorizationException;
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
     * @param  Attempting $event
     * @return void
     */
    public function handle(Attempting $event)
    {
        if (is_challenge_sqlinjection($event->credentials['name'])) {
            Log::info("{$event->credentials['name']} SQLInjectionAttempt from IP $this->ip via URL $this->url");
            $challenge = Challenge::where('id', 4)->first(); // 4 = 'SQL Injection'
            throw new AuthorizationException("Hacking attempt detected! Flag=$challenge->flag");
        }

        Log::info("{$event->credentials['name']} AuthenticationAttempt from IP $this->ip via URL $this->url");
    }
}
