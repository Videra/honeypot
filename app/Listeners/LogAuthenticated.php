<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogAuthenticated
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
     * @param Authenticated $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        Log::info("/{$event->user->name} from $this->ip visited $this->url and /Authenticated");
    }
}
