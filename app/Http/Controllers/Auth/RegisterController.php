<?php

namespace App\Http\Controllers\Auth;

use App\Events\AttemptedMassAssignment;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        if ($invalidInputs = is_mass_assignment($data)) {
            event(new AttemptedMassAssignment(null, $invalidInputs));
        }

        return Validator::make($data, [
            'name' => ['required', 'alpha_num', 'min:4', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
