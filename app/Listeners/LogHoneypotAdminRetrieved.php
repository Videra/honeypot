<?php

namespace App\Listeners;

use App\Events\HoneypotAdminRetrieved;
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
class LogHoneypotAdminRetrieved
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
     * @param  HoneypotAdminRetrieved $event
     * @return void
     */
    public function handle(HoneypotAdminRetrieved $event)
    {
        Log::info("{$event->user->name} HoneypotAdminRetrieved from IP $this->ip via URL $this->url");
    }
}
