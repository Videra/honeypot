<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void */
    public function run() {
        $users = [
            [
                'name' => env('ADMIN_NAME'),
                'password' => env('ADMIN_PASSWORD'),
                'is_admin' => true,
                'is_enabled' => true
            ],
            [
                'name' => env('ADMIN_HIDDEN_NAME'),
                'password' => env('ADMIN_HIDDEN_PASSWORD'),
                'is_admin' => true,
                'is_enabled' => true
            ]
        ];

        foreach($users as $user)
        {
            User::withoutEvents(function () use ($user) {
                User::create([
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'is_admin' => $user['is_admin'],
                    'is_enabled' => $user['is_enabled'],
                ]);
            });
        }

    }
}
