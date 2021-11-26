<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin', 'enabled']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = User::paginate(5);

        return view('app.users', compact('users'));
    }

    public function indexAdmins()
    {
        $users = User::where('is_admin', true)->paginate(5);

        return view('app.users', compact('users'));
    }

    public function indexUsers()
    {
        $users = User::where('is_admin', false)->paginate(5);

        return view('app.users', compact('users'));
    }

    public function indexLoggedIn()
    {
        $users = User::has('sessions')->paginate(5);

        return view('app.users', compact('users'));
    }

    public function indexEnabled()
    {
        $users = User::where('is_enabled', true)->paginate(5);

        return view('app.users', compact('users'));
    }

    public function indexDisabled()
    {
        $users = User::where('is_enabled', false)->paginate(5);

        return view('app.users', compact('users'));
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
        $user->is_enabled = false;
        $user->save();
        $user->sessions()->delete();

        return redirect()->back();
    }

    public function delete($id): RedirectResponse
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back();
    }
}
