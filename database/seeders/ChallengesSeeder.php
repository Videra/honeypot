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
                'description' => 'Login with the default administrator account using brute force and submit here the flag that you found.',
                'flag' => Str::random(10)
            ],
        ];

        foreach($challenges as $challenge)
        {
            Challenge::create([
                'name' => $challenge['name'],
                'description' => $challenge['description'],
                'flag' => $challenge['flag']
            ]);
        }

    }
}
