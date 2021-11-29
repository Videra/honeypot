<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogPasswordReset
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
     * @param PasswordReset $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        Log::info("/{$event->user->name} from $this->ip visited $this->url and /PasswordReset");
    }
}
