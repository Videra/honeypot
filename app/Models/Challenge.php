<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @method static where(string $string, int $int)
 * @property mixed $name
 */
class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'flag'
    ];

    protected $hidden = [
        'flag'
    ];

    public function successes(): HasMany
    {
        return $this->hasMany(Success::class);
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Success::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class);
    }
}
