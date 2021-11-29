<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogLockout
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
     * @param Lockout $event
     * @return void
     */
    public function handle(Lockout $event)
    {
        Log::info("/{$event->request->user()->name} from $this->ip visited $this->url and /Lockout");
    }
}
