<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static all()
 * @method static where(string $string, $id)
 * @method static find($id)
 * @method static create(array $array)
 * @method static has(string $string)
 * @method static paginate(int $int)
 * @property mixed $is_enabled
 * @property mixed $is_admin
 * @property mixed $created_at
 * @property mixed $id
 * @property mixed $name
 * @property mixed|string $avatar
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

    public function isHoneypotAdmin(): bool
    {
        return $this->id == 1;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin == 1;
    }

    public function isEnabled(): bool
    {
        return $this->is_enabled == 1;
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function latestSession()
    {
        return $this->sessions()
            ->orderBy('last_activity', 'desc')
            ->first();
    }

    public function role(): string
    {
        return $this->isAdmin() ? 'Admin' : 'User';
    }

    public function status(): string
    {
        return $this->latestActivity() ? 'Logged in' : 'Logged out';
    }

    public function latestActivity(): string
    {
        if($this->latestSession()) {
            return Carbon::parse($this->latestSession()->last_activity)->diffForHumans();
        }
        return '';
    }

    public function registrationDate(): string
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function successes(): hasMany
    {
        return $this->hasMany(Success::class);
    }
}
