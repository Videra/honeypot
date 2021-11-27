<?php

namespace App\Rules;

use App\Events\AttemptedSQLi;
use App\Events\AttemptedXSS;
use Illuminate\Contracts\Validation\Rule;

class XSS implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user, $payload)
    {
        $this->user = $user;
        $this->payload = $payload;
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
        return !is_challenge_xss($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        event(new AttemptedXSS($this->user, $this->payload));

        return 'XSS attempt failed, a kitten died.';
    }
}
