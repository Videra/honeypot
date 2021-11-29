<?php

namespace App\Listeners;

use App\Events\AchievedBrokenAccessControl;
use App\Events\AchievedImageUploadBypass;
use App\Models\Attempt;
use App\Models\Challenge;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LogAchievedImageUploadBypass
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
     * @param AchievedImageUploadBypass $event
     * @return void
     * @throws AuthorizationException
     */
    public function handle(AchievedImageUploadBypass $event)
    {
        $name = $event->user ? $event->user->getOriginal('name') : 'guest';
        $attempt = Attempt::create($event->attempt);

        Log::info("/$name from $attempt->ip_address visited $attempt->url and [AchievedImageUploadBypass] $attempt->payload");

        $challenge = new Challenge();
        $flag = $challenge->imageUploadBypass()->flag;
        throw new AuthorizationException("Image Upload Bypass achieved! Flag=$flag");
    }
}
