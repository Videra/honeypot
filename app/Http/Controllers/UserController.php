<?php

namespace App\Http\Controllers;

use App\Events\XSSDetected;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

    public function show()
    {
        return view('app.profile');
    }

    /**
     * @throws AuthorizationException
     */
    public function save(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth()->user();

        if ($this->isXSS($request->name)) {
            event(new XSSDetected($user, $request->name));
            $challenge = Challenge::where('id', 2)->first(); // 2 = 'Persistent XSS'
            throw new AuthorizationException("Hacking attempt detected! Flag=$challenge->flag");
        }

        $validated = $request->validate([
            'name' => 'nullable|min:4|unique:users,name,' . $user->id,
            'avatar' => 'image'
        ]);

        if ($validated) {

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

            return redirect()->back();
        }

        return redirect()->back()
            ->withErrors($validated)
            ->withInput();
    }

    /**
     * We detect XSS by asking the DOM engine if the loaded string loads children
     *
     * @param $string
     * @return bool
     */
    private function isXSS($string): bool
    {
        libxml_use_internal_errors(true);

        if ($xml = simplexml_load_string("<root>$string</root>")) {
            return $xml->children()->count() !== 0;
        }

        return false;
    }
}
