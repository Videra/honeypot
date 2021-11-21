<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin', 'enabled']);
    }

    public function show()
    {
        $users = User::paginate(5);

        return view('admin', compact('users'));
    }

    public function showActive()
    {
        $users = User::has('sessions')->paginate(5);

        return view('admin', compact('users'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('name', 'LIKE', "%{$search}%")->get();

        return view('admin', ['users' => $users]);
    }

    public function enable($id): RedirectResponse
    {
        $user = User::find($id);
        $user->is_enabled = true;
        $user->save();

        return redirect()->back();
    }

    public function disable($id): RedirectResponse
    {
        $user = User::find($id);
        $user->sessions()->delete();
        $user->is_enabled = false;
        $user->save();

        return redirect()->back();
    }

    public function delete($id): RedirectResponse
    {
        $user = User::find($id);
        $user->sessions()->delete();
        $user->delete();

        return redirect()->back();
    }
}
