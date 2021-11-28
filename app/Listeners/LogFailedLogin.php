<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogFailedLogin
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
     * @param Failed $event
     * @return void
     */
    public function handle(Failed $event)
    {
        Log::info("/guest from $this->ip visited $this->url and FailedLogin using [{$event->credentials['name']}/{$event->credentials['password']}]");
    }
}
