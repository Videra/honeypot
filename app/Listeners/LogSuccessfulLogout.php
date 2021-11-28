<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogout
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
     * @param Logout $event
     * @return void
     */
    public function handle(Logout $event)
    {
        Log::info("/{$event->user->name} from $this->ip visited $this->url and SuccessfulLogout");
    }
}
