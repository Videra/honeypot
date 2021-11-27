<?php

namespace App\Http\Middleware;

use App\Events\AttemptedBrokenAuth;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckIfHoneypotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if ($user && $user->isHoneypotAdmin()) {
            event(new AttemptedBrokenAuth($user, 'Brute-force'));
        }

        return $next($request);
    }
}
