<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class SQLInjectionAttempt
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param User|Authenticatable $user
     * @param string $payload
     */
    public function __construct($user, string $payload)
    {
        $this->user = $user;
        $this->payload = $payload;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('stack');
    }
}
