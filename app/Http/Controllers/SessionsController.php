<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\RedirectResponse;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

    public function index()
    {
        $sessions = Session::all();

        return view('sessions.index')->with('sessions', $sessions);
    }

    public function delete($id): RedirectResponse
    {
        Session::find($id)->delete();

        return redirect()->back();
    }

    public function invalidateAllSessionsForUser($userId)
    {
        Session::where('user_id', $userId)->delete();
    }
}
