<?php

namespace App\Listeners;

use App\Events\AttemptedBrokenAuth;
use App\Models\Attempt;
use App\Models\Challenge;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        $name = $event->user ? $event->user->getOriginal('name') : 'guest';
        $attempt = Attempt::create($event->attempt);

        Log::info("$name AttemptedBrokenAuth from IP $attempt->ip_address via URL $attempt->url with PAYLOAD $attempt->payload");

        Auth::logout();
        Session::flush();
        $challenge = Challenge::where('id', id_broken_access_control())->first();
        throw new AuthorizationException("Hacking attempt detected! Flag=$challenge->flag");
    }
}
