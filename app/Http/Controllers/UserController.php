<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

    public function show()
    {
        return view('home');
    }

    public function sessions()
    {
        $sessions = Session::where('user_id', Auth::user()->id)
            ->paginate(5);

        return view('sessions')->with(compact('sessions'));
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'avatar' => ['required', 'image']
        ]);

        if ($validated) {
            $filename = Storage::putFile('avatars', $request->file('avatar'));

            // In case that we need to create a vulnerability
            // $filename = $request->image->getClientOriginalName();
            // $request->image->storeAs('avatars', $filename, 'public');

            Auth()->user()->update(['avatar' => $filename]);
        }

        return redirect()->back()->with('success', "Avatar successfully uploaded.");
    }
}
