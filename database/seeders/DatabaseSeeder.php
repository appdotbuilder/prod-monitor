<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed teams first
        $this->call([
            TeamSeeder::class,
            MaterialSeeder::class,
            ProductionSeeder::class,
        ]);

        // Create a default admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
