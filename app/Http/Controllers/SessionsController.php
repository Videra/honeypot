<?php

namespace App\Http\Controllers;

use App\Models\Session;

class SessionsController extends Controller
{
    public function index()
    {
        $sessions = Session::all();

        return view('sessions.index')->with('sessions', $sessions);
    }

    public function invalidateAllSessionsForUser($userId)
    {
        Session::where('user_id', $userId)->delete();
    }
}
