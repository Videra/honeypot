<?php

namespace App\Listeners;

use App\Events\UpdatedUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

/**
 * @property Agent $agent
 * @property string $userAgent
 * @property bool|string $device
 * @property bool|string $browser
 * @property string $url
 * @property string|null $ip
 */
class LogUpdatedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->agent = new Agent();
        $this->agent->setUserAgent(Request::userAgent());
        $this->browser = $this->agent->browser();
        $this->device = $this->agent->device();
        $this->ip = Request::ip();
        $this->url = Request::url();
    }

    /**
     * Handle the event.
     *
     * @param  UpdatedUser $event
     * @return void
     */
    public function handle(UpdatedUser $event)
    {
        if ($event->user->isDirty('name')) {
            Log::info("{$event->authUser->name} UpdatedUserName ({$event->user->getOriginal('name')} -> {$event->user->name}) from IP $this->ip via URL $this->url");
        }

        if ($event->user->isDirty('avatar')) {
            Log::info("{$event->authUser->name} UpdatedUserAvatar ({$event->user->getOriginal('name')} -> {$event->user->name}) from IP $this->ip via URL $this->url");
        }

        if ($event->user->isDirty('is_enabled')) {
            if ($event->user->is_enabled) {
                Log::info("{$event->authUser->name} EnabledUser ({$event->user->name}) from IP $this->ip via URL $this->url");
            } else {
                Log::info("{$event->authUser->name} DisabledUser ({$event->user->name}) from IP $this->ip via URL $this->url");
            }
        }

        if ($event->user->isDirty('is_admin')) {
            if ($event->user->is_admin) {
                Log::info("{$event->authUser->name} EnabledAdmin ({$event->user->name}) from IP $this->ip via URL $this->url");
            } else {
                Log::info("{$event->authUser->name} DisabledAdmin ({$event->user->name}) from IP $this->ip via URL $this->url");
            }
        }
    }
}
