<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeletedUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param Authenticatable $authUser
     * @param User $user
     */
    public function __construct(Authenticatable $authUser, User $user)
    {
        $this->authUser = $authUser;
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
