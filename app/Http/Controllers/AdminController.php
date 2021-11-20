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
     * @return Application|Factory|View
     */
    public function show()
    {
        $users = User::all();

        return view('admin', ['users' => $users]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function enable($id): RedirectResponse
    {
        $user = User::find($id);
        $user->is_enabled = true;
        $user->save();

        return redirect()->back();
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function disable($id): RedirectResponse
    {
        $user = User::find($id);
        $user->sessions()->delete();
        $user->is_enabled = false;
        $user->save();

        return redirect()->back();
    }
}
