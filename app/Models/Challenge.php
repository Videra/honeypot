<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @method static where(string $string, int $int)
 * @property mixed $name
 * @property mixed $flag
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

    public function sqlInjection(): Challenge
    {
        return Challenge::where('id', id_sql_injection())->first();
    }

    public function brokenAccessControl(): Challenge
    {
        return Challenge::where('id', id_broken_access_control())->first();
    }

    public function massAssignment(): Challenge
    {
        return Challenge::where('id', id_mass_assignment())->first();
    }

    public function xss(): Challenge
    {
        return Challenge::where('id', id_persistent_xss())->first();
    }
}
