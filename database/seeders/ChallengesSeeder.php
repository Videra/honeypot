<?php

namespace Database\Seeders;

use App\Models\Challenge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChallengesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void */
    public function run() {
        $challenges = [
            [
                'name' => 'Broken Access Control',
                'description' => 'Login by guessing the default administrator account and brute-forcing its password.',
                'flag' => Str::random(10)
            ],
            [
                'name' => 'Persistent XSS',
                'description' => 'Supply untrusted input that, when loaded without proper validation or escaping, will execute a malicious action.',
                'flag' => Str::random(10)
            ],
            [
                'name' => 'Mass Assignment',
                'description' => 'Discover a vulnerability that allows passing an unexpected parameter that will escalate the user to admin.',
                'flag' => Str::random(10)
            ],
            [
                'name' => 'SQL Injection',
                'description' => 'Interfere with the queries that the web makes to its database to login with the default administrator account.',
                'flag' => Str::random(10)
            ],
            [
                'name' => 'Image Upload Bypass',
                'description' => 'Bypass the validation in the avatar uploader to send a file that is not an image.',
                'flag' => Str::random(10)
            ],
        ];

        foreach($challenges as $challenge)
        {
            Challenge::withoutEvents(function () use ($challenge) {
                Challenge::create([
                    'name' => $challenge['name'],
                    'description' => $challenge['description'],
                    'flag' => $challenge['flag']
                ]);
            });
        }

    }
}
