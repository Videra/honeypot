<?php

namespace App\Http\Middleware;

use App\Events\AttemptedBrokenAuth;
use App\Models\Challenge;
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
        $user = $request->user();

        if ($user && $user->isHoneypotAdmin()) {
            Auth::logout();
            Session::flush();

            event(new AttemptedBrokenAuth($user));

            $challenge = Challenge::where('id', 1)->first(); // 1 = 'Broken Access Control'
            throw new AuthorizationException("Hacking attempt detected! Flag=$challenge->flag");
        }

        return $next($request);
    }
}
