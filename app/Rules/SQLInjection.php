<?php

namespace App\Rules;

use App\Events\SQLInjectionAttempt;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\Rule;

class SQLInjection implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @param User|Authenticatable $user
     * @return void
     */
    public function __construct($user, string $payload)
    {
        event(new SQLInjectionAttempt($user, $payload));
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !is_sql_injection($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'SQL Injection attempt failed, a kitten died.';
    }
}
