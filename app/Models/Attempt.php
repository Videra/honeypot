<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Request;

/**
 * @method static all()
 * @method static where(string $string, $id)
 * @method static find($id)
 * @method static create(array $array)
 * @method static has(string $string)
 * @method static paginate(int $int)
 * @method static withCount(string $string)
 */
class Attempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'url'
    ];

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
