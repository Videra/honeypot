<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
                'description' => 'Login with the default administrator account by brute-forcing the password.',
                'flag' => Str::random(10)
            ],
            [
                'name' => 'Persistent XSS',
                'description' => 'Persistent XSS occurs when a page outputs untrusted stored data without proper validation or escaping.',
                'flag' => Str::random(10)
            ],
            [
                'name' => 'Mass Assignment',
                'description' => 'Achieve a Mass Assignment vulnerability by passing an unexpected parameter in a form that will escalate the user to admin.',
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
