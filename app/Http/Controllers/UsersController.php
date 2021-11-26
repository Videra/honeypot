<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'avatar' => 'image|max:2048'
            ], ['max' => 'The image exceeds max size of 2MB.']);

        if ($validated) {

            if ($request->name) {
                Auth()->user()->name = $request->name;
            }

            if ($request->file('avatar')) {
                $pathToFile = Storage::putFile('avatars', $request->file('avatar'));
                Auth()->user()->avatar = $pathToFile;
            }

            Auth()->user()->save();

            return redirect()->back();
        }

        return redirect()->back()
            ->withErrors($validated)
            ->withInput();
    }
}
