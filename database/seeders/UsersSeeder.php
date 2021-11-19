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
        User::truncate();
        $users = [
            [
                'name' => 'admin',
                'password' => 'admin1234',
                'is_admin' => '1',
            ],
            [
                'name' => 'user',
                'password' => 'user1234',
                'is_admin' => null,
            ],
            [
                'name' => 'client',
                'password' => 'client1234',
                'is_admin' => null,
            ]
        ];

        foreach($users as $user)
        {
            User::create([
                'name' => $user['name'],
                'password' => Hash::make($user['password']),
                'is_admin' => $user['is_admin']
            ]);
        }

    }
}
