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
                'name' => 'admin',
                'password' => '1234567890',
                'is_admin' => true,
                'is_enabled' => true
            ],
            [
                'name' => 'Hacker',
                'password' => 'myverysafelaravelpassword',
                'is_admin' => true,
                'is_enabled' => true
            ],
            [
                'name' => 'Natalia',
                'password' => 'user1234',
                'is_admin' => false,
                'is_enabled' => true
            ],
            [
                'name' => 'Carlos',
                'password' => 'user1234',
                'is_admin' => false,
                'is_enabled' => true
            ],
            [
                'name' => 'John',
                'password' => 'user1234',
                'is_admin' => false,
                'is_enabled' => false
            ],
            [
                'name' => 'Laura',
                'password' => 'user1234',
                'is_admin' => false,
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
