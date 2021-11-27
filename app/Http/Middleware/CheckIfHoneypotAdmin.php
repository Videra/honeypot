<?php

namespace App\Http\Middleware;

use App\Events\AttemptedBrokenAccessControl;
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
            event(new AttemptedBrokenAccessControl($request->getPassword()));
        }

        return $next($request);
    }
}
