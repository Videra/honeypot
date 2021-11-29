<?php

namespace App\Listeners;

use App\Events\SessionClosedUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogSessionClosedUser
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
     * @param SessionClosedUser $event
     * @return void
     */
    public function handle(SessionClosedUser $event)
    {
        $user = $event->user ? $event->user->name : 'guest';
        $authUser = auth()->user();
        Log::info("/$authUser from $this->ip visited $this->url and /SessionClosedUser $user");
    }
}
