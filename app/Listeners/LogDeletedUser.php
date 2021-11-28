<?php

namespace App\Listeners;

use App\Events\DeletedUser;
use App\Events\UpdatedUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogDeletedUser
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
     * @param DeletedUser $event
     * @return void
     */
    public function handle(DeletedUser $event)
    {
        Log::info("/{$event->authUser->name} from $this->ip visited $this->url and DeletedUser {$event->user->name}");
    }
}
