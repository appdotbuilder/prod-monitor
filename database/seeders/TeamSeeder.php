<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Apparel Design Team',
                'type' => 'apparel',
                'description' => 'Specializes in clothing and textile production',
                'is_active' => true,
            ],
            [
                'name' => 'Apparel Production Team',
                'type' => 'apparel',
                'description' => 'Handles garment manufacturing and assembly',
                'is_active' => true,
            ],
            [
                'name' => 'Non-Apparel Manufacturing',
                'type' => 'non_apparel',
                'description' => 'Produces accessories, bags, and other non-clothing items',
                'is_active' => true,
            ],
            [
                'name' => 'Quality Assurance Team',
                'type' => 'non_apparel',
                'description' => 'Ensures quality standards across all products',
                'is_active' => true,
            ],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}