<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

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
     */
    public function update(Request $request): RedirectResponse
    {
        // @TODO CRITICAL: This creates the "Persistent XSS" vulnerability
        $validation = Validator::make($request->all(), [
            'name' => [
                function ($attribute, $value, $fail) {
                    if (is_sql_injection($value)) {
                        $fail('SQL Injection failed, a kitten died.');
                    }
                },
                'string',
                'nullable',
                'min:4',
                'unique:users,name,' . Auth()->user()->id,
            ],
            'avatar' => 'image|max:2048'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if ($request->file('avatar')) {
            $request->avatar = Storage::putFile('avatars', $request->file('avatar'));
        }

        // @TODO CRITICAL: This creates the "Mass Assignment" vulnerability
        auth()->user()->update(array_filter($request->all()));

        return redirect()->back();
    }
}
