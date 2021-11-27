<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttemptedSQLi
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $attempt;
    /**
     * @var User|Authenticatable|null
     */
    public $user;

    /**
     * @param User|Authenticatable|null $user
     * @param string $payload
     */
    public function __construct($user, string $payload)
    {
        $this->user = $user;
        $this->attempt = [
            'challenge_id' => id_sql_injection(),
            'user_id' => $this->user->id,
            'payload' => $payload,
            'ip_address' => Request()->ip(),
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
