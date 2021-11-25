<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @method static where(string $string, int $int)
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

    public function success(): HasMany
    {
        return $this->hasMany(Success::class);
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Success::class);
    }
}
