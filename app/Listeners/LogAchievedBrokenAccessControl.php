<?php

namespace App\Listeners;

use App\Events\AchievedBrokenAccessControl;
use App\Models\Attempt;
use App\Models\Challenge;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LogAchievedBrokenAccessControl
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
     * @param AchievedBrokenAccessControl $event
     * @return void
     * @throws AuthorizationException
     */
    public function handle(AchievedBrokenAccessControl $event)
    {
        $name = $event->user ? $event->user->getOriginal('name') : 'guest';
        $attempt = Attempt::create($event->attempt);

        Log::info("/$name from $attempt->ip_address visited $attempt->url and /AchievedBrokenAccessControl");

        Auth::logout();
        Session::flush();

        $challenge = new Challenge();
        $flag = $challenge->brokenAccessControl()->flag;
        throw new AuthorizationException("Broken Access Control achieved! Flag=$flag");
    }
}
