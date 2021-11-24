<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class XSSAttackDetected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param User $user
     * @param string $payload
     */
    public function __construct(User $user, string $payload)
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
