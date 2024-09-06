<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $pasword = env('USERS_DEFAULT_PASWORD');
        User::factory(2)->create([
            'type' => 'admin',
            'password' => $pasword
        ]);

        User::factory(8)->create([
            'type' => 'normal',
            'password' => $pasword
        ]);
    }
}
