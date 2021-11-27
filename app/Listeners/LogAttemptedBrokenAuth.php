<?php

namespace App\Listeners;

use App\Events\AttemptedBrokenAuth;
use App\Models\Attempt;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

/**
 * @property Agent $agent
 * @property string $userAgent
 * @property bool|string $device
 * @property bool|string $browser
 * @property string $url
 * @property string|null $ip
 */
class LogAttemptedBrokenAuth
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
     * @param  AttemptedBrokenAuth $event
     * @return void
     */
    public function handle(AttemptedBrokenAuth $event)
    {
        $attempt = Attempt::create($event->attempt);

        Log::info("{$event->user->getOriginal('name')} AttemptedBrokenAuth from IP $attempt->ip_address via URL $attempt->url with PAYLOAD {$attempt->payload}");
    }
}
