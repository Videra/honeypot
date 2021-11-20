<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin', 'enabled']);
    }

    public function show()
    {
        $users = User::all();

        return view('admin', ['users' => $users]);
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
