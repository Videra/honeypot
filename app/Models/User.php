<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static all()
 * @method static where(string $string, $id)
 * @method static find($id)
 * @method static create(array $array)
 * @property mixed $is_enabled
 * @property mixed $is_admin
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function isAdmin(): bool
    {
        return $this->is_admin == 1;
    }

    public function isEnabled(): bool
    {
        return $this->is_enabled == 1;
    }

    /**
     * Get the sessions for the user.
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get the latest session for the user.
     */
    public function latestSession()
    {
        return $this->sessions()
            ->orderBy('last_activity', 'desc')
            ->first();
    }
}
