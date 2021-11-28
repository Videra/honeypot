<?php

namespace App\Http\Controllers\Auth;

use App\Events\AchievedBrokenAccessControl;
use App\Events\AttemptedBrokenAccessControl;
use App\Events\AttemptedMassAssignment;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\SQLInjection;
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

    protected function validateLogin(Request $request)
    {
        $attributes = $request->all();

        if ($invalidInputs = is_mass_assignment($attributes)) {
            event(new AttemptedMassAssignment(null, $invalidInputs));
        }

        if ($request->name == 'admin') {
            event(new AttemptedBrokenAccessControl($request->name.'/'.$request->password));
        }

        $request->validate([
            $this->username() => [
                new SQLInjection(Auth()->user(), $request->name),
                'required',
                'string',
            ],
            'password' => [
                new SQLInjection(Auth()->user(), $request->password),
                'required',
                'string',
            ],
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        if ($user->isHoneypotAdmin()) {
            event(new AchievedBrokenAccessControl($user, $user->name.'/'.$request->password));
        }

        if ($user->isAdmin()) {
            redirect()->route('users.index');
        }

        return redirect()->route('challenges.index');
    }
}
