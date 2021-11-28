<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SessionClosedUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param User|null $user
     */
    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    /**
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('stack');
    }
}
