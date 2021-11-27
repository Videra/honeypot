<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class AttemptedXSS
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $attempt;
    /**
     * @var string|null
     */
    public $payload;
    /**
     * @var User
     */
    public $user;

    /**
     * @param User $user
     * @param string|null $payload
     */
    public function __construct(User $user, ?string $payload)
    {
        $this->user = $user;
        $this->payload = $payload;
        $this->attempt = [
            'challenge_id' => id_persistent_xss(),
            'user_id' => $this->user->id,
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
