<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


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
        // Do not disable the Honeypot Admin
        if ($id == 1) {
            return redirect()->back()->with('error', "You can't disable the admin user");
        }

        // Do not disable yourself
        if (Auth::user()->id == $id) {
            return redirect()->back()->with('error', "You can't disable your current user");
        }

        // Disable a user
        $user = User::find($id);
        $user->sessions()->delete();
        $user->is_enabled = false;
        $user->save();

        return redirect()->back();
    }

    public function delete($id): RedirectResponse
    {
        // Do not delete the Honeypot Admin
        if ($id == 1) {
            return redirect()->back()->with('error', "You can't delete the admin user");
        }

        // Do not delete yourself
        if (Auth::user()->id == $id) {
            return redirect()->back()->with('error', "You can't delete your current user");
        }

        // Delete a user
        $user = User::find($id);
        $user->sessions()->delete();
        $user->delete();

        return redirect()->back();
    }
}
