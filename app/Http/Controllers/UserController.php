<?php

namespace App\Http\Controllers;

use App\Events\XSSAttackDetected;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'enabled']);
    }

    public function show()
    {
        /** @var User $user */
        $user = Auth()->user();
        $user_ip_add = Request()->getClientIp();
        Log::info("The user $user->name at Home page from IP address $user_ip_add");
        return view('home');
    }

    /**
     * @throws AuthorizationException
     */
    public function save(Request $request)
    {
        /** @var User $user */
        $user = Auth()->user();

        if ($this->isXSS($request->name)) {
            $this->blockXSS($user);
        }

        $validated = $request->validate([
            'name' => 'required|min:4|unique:users,name,' . $user->id,
            'avatar' => 'image'
        ]);

        if ($validated) {

            DB::enableQueryLog();

            if ($request->name) {
                Log::Info("$user->name has changed his username to $request->name");
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

    /**
     * @param User $user
     * @throws AuthorizationException
     */
    private function blockXSS(User $user) {
        User::where('id', $user->id)->update(['is_enabled' => 0]);
        Auth::logout();
        event(new XSSAttackDetected($user, $user->name));
        throw new AuthorizationException('Hacking attempt detected!');
    }
}
