<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

    public function show()
    {
        return view('admin', ['users' => User::all()]);
    }

    public function enable($id)
    {
        $user = User::find($id);
        $user->is_enabled = true;
        $user->save();

        return redirect()->back();
    }

    public function disable($id)
    {
        $user = User::find($id);
        $user->is_enabled = false;
        $user->save();

        return redirect()->back();
    }
}
