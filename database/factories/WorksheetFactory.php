<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worksheet>
 */
class WorksheetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Worksheet>
     */
    protected $model = Worksheet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'worksheet_number' => 'WS-' . str_pad((string)$this->faker->unique()->numberBetween(1, 999999), 6, '0', STR_PAD_LEFT),
            'product_name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'production_type' => $this->faker->randomElement(['internal', 'fob', null]),
            'created_by' => User::factory(),
            'approved_by' => null,
            'approved_at' => null,
            'approval_notes' => null,
        ];
    }

    /**
     * Indicate that the worksheet is approved.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
                'approved_by' => User::factory(),
                'approved_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
                'approval_notes' => $this->faker->sentence(),
                'production_type' => $this->faker->randomElement(['internal', 'fob']),
            ];
        });
    }

    /**
     * Indicate that the worksheet is pending.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'approval_notes' => null,
                'production_type' => null,
            ];
        });
    }
}