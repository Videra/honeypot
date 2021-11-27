<?php

namespace App\Listeners;

use App\Events\ChallengeCompleted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogChallengeCompleted
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
     * @param ChallengeCompleted $event
     * @return void
     */
    public function handle(ChallengeCompleted $event)
    {
        Log::info("/{$event->user->name} from $this->ip visited $this->url and ChallengeCompleted {$event->challenge->name}");
    }
}
