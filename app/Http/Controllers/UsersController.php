<?php

namespace App\Http\Controllers;

use App\Events\AttemptedMassAssignment;
use App\Models\User;
use App\Rules\SQLInjection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

    /**
     * Display the Ranking page
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = User::withCount('successes')
            ->whereNotIn('id', [1,2])
            ->orderBy('successes_count', 'desc')
            ->paginate(5);

        return view('app.honeypot')->with(compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('app.profile');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        if ($invalidInputs = is_mass_assignment($request->all())) {
            event(new AttemptedMassAssignment(Auth()->user(), $invalidInputs));
            return redirect()->back()->withErrors(['name' => 'Mass Assignment attempt failed, a kitten died.']);
        }

        // @TODO CRITICAL: This creates the "Persistent XSS" vulnerability
        Validator::make($request->all(), [
            'name' => [
                new SQLInjection(Auth()->user(), $request->name),
                'string',
                'nullable',
                'min:4',
                'unique:users,name,' . Auth()->user()->id,
            ],
            'avatar' => 'image|max:2048'
        ])->validate();

        if ($request->file('avatar')) {
            $request->avatar = Storage::putFile('avatars', $request->file('avatar'));
        }

        // @TODO CRITICAL: This creates the "Mass Assignment" vulnerability
        auth()->user()->update(array_filter($request->all()));

        return redirect()->back();
    }
}
