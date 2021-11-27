<?php

namespace App\Events;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChallengeAttempted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(User $user, Challenge $challenge)
    {
        $this->user = $user;
        $this->challenge = $challenge;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('stack');
    }
}
