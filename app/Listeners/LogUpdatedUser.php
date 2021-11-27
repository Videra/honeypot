<?php

namespace App\Listeners;

use App\Events\UpdatedUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogUpdatedUser
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
     * @param UpdatedUser $event
     * @return void
     */
    public function handle(UpdatedUser $event)
    {
        if ($event->user->isDirty('name')) {
            Log::info("/{$event->authUser->name} from $this->ip visited $this->url and UpdatedUserName {$event->user->name}");
        }

        if ($event->user->isDirty('avatar')) {
            Log::info("/{$event->authUser->name} from $this->ip visited $this->url and UpdatedUserAvatar {$event->user->avatar}");
        }

        if ($event->user->isDirty('is_enabled')) {
            if ($event->user->is_enabled) {
                Log::info("/{$event->authUser->name} from $this->ip visited $this->url and EnabledUser {$event->user->name}");
            } else {
                Log::info("/{$event->authUser->name} from $this->ip visited $this->url and DisabledUser {$event->user->name}");
            }
        }

        if ($event->user->isDirty('is_admin')) {
            if ($event->user->is_admin) {
                Log::info("/{$event->authUser->name} from $this->ip visited $this->url and EnabledAdmin {$event->user->name}");
            } else {
                Log::info("/{$event->authUser->name} from $this->ip visited $this->url and DisabledAdmin {$event->user->name}");
            }
        }
    }
}
