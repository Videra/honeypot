<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Agent\Agent;

/**
 * @method static where(string $string, $userId)
 * @method static find($id)
 * @property mixed $last_activity
 * @property mixed $user_agent
 */
class Session extends Model
{
    use HasFactory;

    private $agent;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->agent = new Agent();
    }

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user of the session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function browser()
    {
        $this->agent->setUserAgent($this->user_agent);

        return $this->agent->browser();
    }

    public function device()
    {
        $this->agent->setUserAgent($this->user_agent);

        return $this->agent->device();
    }

    public function lastActivity(): string
    {
        return Carbon::createFromTimestamp($this->last_activity);
    }
}
