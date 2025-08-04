<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Material>
     */
    protected $model = Material::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['fabric', 'trim', 'other']);
        
        return [
            'name' => $this->faker->words(2, true) . ' ' . ucfirst($type),
            'description' => $this->faker->sentence(),
            'unit' => $this->faker->randomElement(['yard', 'meter', 'piece', 'spool', 'roll']),
            'unit_cost' => $this->faker->randomFloat(2, 1, 50),
            'type' => $type,
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the material is fabric.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function fabric()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'fabric',
                'name' => $this->faker->randomElement(['Cotton', 'Polyester', 'Silk', 'Wool', 'Linen']) . ' Fabric',
                'unit' => $this->faker->randomElement(['yard', 'meter']),
                'unit_cost' => $this->faker->randomFloat(2, 5, 30),
            ];
        });
    }

    /**
     * Indicate that the material is trim.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function trim()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'trim',
                'name' => $this->faker->randomElement(['Button', 'Zipper', 'Elastic', 'Ribbon', 'Lace']),
                'unit' => $this->faker->randomElement(['piece', 'yard', 'meter']),
                'unit_cost' => $this->faker->randomFloat(2, 0.5, 10),
            ];
        });
    }
}