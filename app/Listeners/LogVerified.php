<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogVerified
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
     * @param Verified $event
     * @return void
     */
    public function handle(Verified $event)
    {
        Log::info("/{$event->user->getEmailForVerification()} from $this->ip visited $this->url and /Verified");
    }
}
