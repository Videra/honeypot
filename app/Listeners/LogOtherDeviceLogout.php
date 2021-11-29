<?php

namespace App\Listeners;

use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogOtherDeviceLogout
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
     * @param OtherDeviceLogout $event
     * @return void
     */
    public function handle(OtherDeviceLogout $event)
    {
        Log::info("/{$event->user->name} from $this->ip visited $this->url and /OtherDeviceLogout");
    }
}
