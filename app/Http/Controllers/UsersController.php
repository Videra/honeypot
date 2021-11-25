<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|min:4|unique:users,name,' . Auth()->user()->id,
            'avatar' => 'image'
        ]);

        if ($validated) {

            if ($request->name) {
                Auth()->user()->name = $request->name;
            }

            if ($request->file('avatar')) {

                 // @TODO Vulnerability File Upload:
                 // $filename = Storage::putFile('avatars', $request->file('avatar'));

                $filename = 'avatars/'. $request->avatar->getClientOriginalName();
                $request->avatar->storeAs('', $filename);
                Auth()->user()->avatar = $filename;
            }

            Auth()->user()->save();

            return redirect()->back();
        }

        return redirect()->back()
            ->withErrors($validated)
            ->withInput();
    }
}
