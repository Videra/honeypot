<?php

namespace App\Listeners;

use App\Events\ChallengeAttempted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogChallengeAttempted
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
     * @param ChallengeAttempted $event
     * @return void
     */
    public function handle(ChallengeAttempted $event)
    {
        $challengeName = preg_replace('/\s+/', '_', $event->challenge->name);

        Log::info("/{$event->user->name} from $this->ip visited $this->url and [ChallengeAttempted] [$challengeName]");
    }
}
