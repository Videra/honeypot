<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    protected $maxAttempts = 50; // Default is 5
    protected $decayMinutes = 1; // Default is 1

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(): string
    {
        return 'name';
    }

    protected function authenticated(Request $request, $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return redirect()->route('users.index');
        }

        return redirect()->route('challenges.index');
    }
}
