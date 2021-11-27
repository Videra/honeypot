<?php

namespace App\Listeners;

use App\Events\CreatedUser;
use App\Events\UpdatedUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogCreatedUser
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
     * @param CreatedUser $event
     * @return void
     */
    public function handle(CreatedUser $event)
    {
        Log::info("/{$event->user->name} from $this->ip visited $this->url and CreatedUser");
    }
}
