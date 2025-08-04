<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            // Fabrics
            [
                'name' => 'Cotton Fabric - Plain',
                'description' => '100% cotton plain weave fabric',
                'unit' => 'yard',
                'unit_cost' => 12.50,
                'type' => 'fabric',
                'is_active' => true,
            ],
            [
                'name' => 'Polyester Blend',
                'description' => '65% polyester, 35% cotton blend',
                'unit' => 'yard',
                'unit_cost' => 8.75,
                'type' => 'fabric',
                'is_active' => true,
            ],
            [
                'name' => 'Denim Fabric',
                'description' => 'Heavy-weight denim for jeans and jackets',
                'unit' => 'yard',
                'unit_cost' => 15.00,
                'type' => 'fabric',
                'is_active' => true,
            ],
            
            // Trims
            [
                'name' => 'Plastic Buttons - 15mm',
                'description' => 'Standard 4-hole plastic buttons',
                'unit' => 'piece',
                'unit_cost' => 0.25,
                'type' => 'trim',
                'is_active' => true,
            ],
            [
                'name' => 'Metal Zipper - 12 inch',
                'description' => 'Heavy-duty metal zipper',
                'unit' => 'piece',
                'unit_cost' => 3.50,
                'type' => 'trim',
                'is_active' => true,
            ],
            [
                'name' => 'Elastic Band - 1 inch',
                'description' => 'Stretch elastic band for waistbands',
                'unit' => 'yard',
                'unit_cost' => 1.20,
                'type' => 'trim',
                'is_active' => true,
            ],
            
            // Other materials
            [
                'name' => 'Thread - Polyester',
                'description' => 'All-purpose polyester thread',
                'unit' => 'spool',
                'unit_cost' => 2.00,
                'type' => 'other',
                'is_active' => true,
            ],
            [
                'name' => 'Interfacing - Fusible',
                'description' => 'Iron-on interfacing for structure',
                'unit' => 'yard',
                'unit_cost' => 4.25,
                'type' => 'other',
                'is_active' => true,
            ],
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}