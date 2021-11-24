<?php

namespace App\Http\Controllers\Auth;

use App\Events\XSSAttackDetected;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
     * test
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     * @throws AuthorizationException
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        if ($this->isXSS($data['name'])) {
            event(new XSSAttackDetected(new User(), $data['name']));
            throw new AuthorizationException('Hacking attempt detected!');
        }

        return Validator::make($data, [
            'name' => ['required', 'string', 'min:4', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        $user_ip_add = Request()->getClientIp();
        Log::info("The user $data[name] created account from IP address $user_ip_add");

        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ]);
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
