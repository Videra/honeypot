<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

    public function index()
    {
        if (Auth()->user()->isAdmin()) {
            $sessions = Session::paginate(5);
        } else {
            $sessions = Session::where('user_id', Auth()->user()->id)->paginate(5);
        }

        return view('sessions')->with(compact('sessions'));
    }

    public function show($user_id) {
        $sessions = Session::where('user_id', $user_id)->paginate(5);

        return view('sessions')->with(compact('sessions', 'user_id'));
    }

    public function delete($id): RedirectResponse
    {
        if (Auth()->user()->isAdmin()) {
            $session = Session::where('id', $id);
        } else {
            $session = Session::where('user_id', Auth()->user()->id)
                ->where('id', $id);
        }

        $session->delete();

        return redirect()->back();
    }

    public function invalidateAllSessionsForUser($userId)
    {
        Session::where('user_id', $userId)->delete();
    }
}
