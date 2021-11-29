<?php

namespace App\Listeners;

use App\Events\AchievedBrokenAccessControl;
use App\Events\AchievedImageUploadBypass;
use App\Events\AttemptedImageUploadBypass;
use App\Models\Attempt;
use App\Models\Challenge;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LogAttemptedImageUploadBypass
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
     * @param AttemptedImageUploadBypass $event
     * @return void
     * @throws AuthorizationException
     */
    public function handle(AttemptedImageUploadBypass $event)
    {
        $name = $event->user ? $event->user->getOriginal('name') : 'guest';
        $attempt = Attempt::create($event->attempt);

        Log::info("/$name from $attempt->ip_address visited $attempt->url and /AttemptedImageUploadBypass $attempt->payload");
    }
}
