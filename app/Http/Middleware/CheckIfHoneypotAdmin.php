<?php

namespace App\Http\Middleware;

use App\Events\HoneypotAdminRetrieved;
use App\Models\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckIfHoneypotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if ($user && $user->isHoneypotAdmin()) {
            Session::flush();
            Auth::logout();
            event(new HoneypotAdminRetrieved($user));
            throw new AuthorizationException('Hacking attempt detected!');
        }

        return $next($request);
    }
}
