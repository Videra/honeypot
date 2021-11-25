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
            Log::info("{$event->user->getOriginal('name')} UpdatedUserName (to {$event->user->name}) from IP $this->ip via URL $this->url");
        }

        if ($event->user->isDirty('avatar')) {
            Log::info("{$event->user->getOriginal('name')} UpdatedUserAvatar (to {$event->user->avatar}) from IP $this->ip via URL $this->url");
        }
    }
}
