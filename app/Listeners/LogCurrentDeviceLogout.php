<?php

namespace App\Listeners;

use Illuminate\Auth\Events\CurrentDeviceLogout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogCurrentDeviceLogout
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
     * @param CurrentDeviceLogout $event
     * @return void
     */
    public function handle(CurrentDeviceLogout $event)
    {
        Log::info("/{$event->user->name} from $this->ip visited $this->url and CurrentDeviceLogout");
    }
}
