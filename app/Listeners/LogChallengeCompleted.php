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
     * @param  ChallengeCompleted $event
     * @return void
     */
    public function handle(ChallengeCompleted $event)
    {
        Log::info("{$event->user->name} ChallengeCompleted ({$event->challenge->name}) from IP $this->ip via URL $this->url");
    }
}
