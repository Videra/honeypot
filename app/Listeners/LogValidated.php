<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogValidated
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
     * @param Validated $event
     * @return void
     */
    public function handle(Validated $event)
    {
        Log::info("/{$event->user->name} from $this->ip visited $this->url and Validated");
    }
}
