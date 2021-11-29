<?php

namespace App\Http\Controllers;

use App\Events\SessionClosedUser;
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
        if (Auth()->user()->isAdmin()) {
            $sessions = Session::whereNotIn('user_id', [1,2])
                ->paginate(5);
        } else {
            $sessions = Session::where('user_id', Auth()->user()->id)
                ->paginate(5);
        }

        return view('app.sessions')->with(compact('sessions'));
    }

    public function show($user_id) {
        $sessions = Session::where('user_id', $user_id)->paginate(5);

        return view('app.sessions')->with(compact('sessions', 'user_id'));
    }

    /**
     *
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        if (Auth()->user()->isAdmin()) {
            $session = Session::with('user')
                ->where('id', $id)
                ->first();
        } else {
            $session = Session::with('user')
                ->where('id', $id)
                ->where('user_id', Auth()->user()->id)
                ->first();
        }

        event(new SessionClosedUser($session->user));

        $session->delete();

        return redirect()->back();
    }
}
