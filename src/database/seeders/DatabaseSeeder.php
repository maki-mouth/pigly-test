<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $user = User::first() ?? User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'), 
        ]);

        WeightTarget::factory()
            ->count(1)
            ->for($user)
            ->create();

        WeightLog::factory()
            ->count(35)
            ->for($user)
            ->create();

    }
}
