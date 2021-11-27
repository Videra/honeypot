<?php

namespace App\Listeners;

use App\Events\AttemptedSQLi;
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
class LogAttemptedSQLi
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
     * @param  AttemptedSQLi $event
     * @return void
     */
    public function handle(AttemptedSQLi $event)
    {
        $attempt = Attempt::create($event->attempt);

        Log::info("{$event->user->getOriginal('name')} AttemptedSQLi from IP $attempt->ip_address via URL $attempt->url with PAYLOAD {$attempt->payload}");
    }
}
