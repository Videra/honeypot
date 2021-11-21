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

    public function show()
    {
        if (Auth()->user()->isAdmin()) {
            $sessions = Session::paginate(5);
        } else {
            $sessions = Session::where('user_id', Auth()->user()->id)->paginate(5);
        }

        return view('sessions')->with(compact('sessions'));
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
