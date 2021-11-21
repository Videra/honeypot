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
                'is_admin' => true,
                'is_enabled' => true
            ],
            [
                'name' => 'user',
                'password' => 'user1234',
                'is_admin' => false,
                'is_enabled' => true
            ],
            [
                'name' => 'client',
                'password' => 'client1234',
                'is_admin' => false,
                'is_enabled' => false
            ],
            [
                'name' => 'admin2',
                'password' => 'admin1234',
                'is_admin' => true,
                'is_enabled' => true
            ],
            [
                'name' => 'user2',
                'password' => 'user1234',
                'is_admin' => false,
                'is_enabled' => true
            ],
            [
                'name' => 'client2',
                'password' => 'client1234',
                'is_admin' => false,
                'is_enabled' => false
            ],
            [
                'name' => 'user3',
                'password' => 'user1234',
                'is_admin' => false,
                'is_enabled' => true
            ],
            [
                'name' => 'client3',
                'password' => 'client1234',
                'is_admin' => false,
                'is_enabled' => false
            ],
            [
                'name' => 'user4',
                'password' => 'user1234',
                'is_admin' => false,
                'is_enabled' => true
            ],
            [
                'name' => 'client4',
                'password' => 'client1234',
                'is_admin' => false,
                'is_enabled' => false
            ],
            [
                'name' => 'user5',
                'password' => 'user1234',
                'is_admin' => false,
                'is_enabled' => true
            ],
            [
                'name' => 'client5',
                'password' => 'client1234',
                'is_admin' => false,
                'is_enabled' => false
            ],
        ];

        foreach($users as $user)
        {
            User::create([
                'name' => $user['name'],
                'password' => Hash::make($user['password']),
                'is_admin' => $user['is_admin'],
                'is_enabled' => $user['is_enabled'],
            ]);
        }

    }
}
