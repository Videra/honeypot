<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use function Symfony\Component\String\b;

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

    public function save(Request $request)
    {
        /** @var User $user */
        $user = Auth()->user();

        $validated = $request->validate([
            'name' => 'required|min:4|unique:users,name,' . $user->id,
            // @TODO Vulnerability File Upload:
            // 'avatar' => 'image'
        ]);

        if ($validated) {
            DB::enableQueryLog();

            if ($request->name) {
                $user->name = $request->name;
            }

            if ($request->file('avatar')) {

                 // @TODO Vulnerability File Upload:
                 // $filename = Storage::putFile('avatars', $request->file('avatar'));

                $filename = 'avatars/'. $request->avatar->getClientOriginalName();
                $request->avatar->storeAs('', $filename);
                $user->avatar = $filename;
            }

            $user->save();

            $sql = DB::getQueryLog();
            $sql = end($sql);

            return redirect('home')->with(compact('sql'));
        }

        return redirect('home')
            ->withErrors($validated)
            ->withInput();
    }
}
