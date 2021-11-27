<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * @property User $user
 */
class AttemptedBrokenAccessControl
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $attempt;

    /**
     * @param string|null $payload
     */
    public function __construct(?string $payload)
    {
        $this->attempt = [
            'challenge_id' => id_broken_access_control(),
            'user_id' => $this->user->id ?? null,
            'payload' => $payload,
            'ip_address' => Request()->getClientIp(),
            'user_agent' => Request()->userAgent(),
            'url' => Request()->url()
        ];
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
