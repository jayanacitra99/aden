<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Create Super Admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@aden.com'], // Check if exists by email
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // Change this in production!
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Create a Site Manager (Example User)
        DB::table('users')->updateOrInsert(
            ['email' => 'manager_berau@aden.com'],
            [
                'name' => 'Manager Berau',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->call([DummyDataSeeder::class]);
    }
}
