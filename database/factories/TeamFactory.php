<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Team>
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Team',
            'type' => $this->faker->randomElement(['apparel', 'non_apparel']),
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the team is apparel type.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function apparel()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'apparel',
                'name' => $this->faker->words(2, true) . ' Apparel Team',
            ];
        });
    }

    /**
     * Indicate that the team is non-apparel type.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function nonApparel()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'non_apparel',
                'name' => $this->faker->words(2, true) . ' Manufacturing Team',
            ];
        });
    }
}