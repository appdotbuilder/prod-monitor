<?php

namespace Database\Factories;

use App\Models\Costing;
use App\Models\Sample;
use App\Models\Team;
use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sample>
 */
class SampleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Sample>
     */
    protected $model = Sample::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'worksheet_id' => Worksheet::factory(),
            'costing_id' => Costing::factory(),
            'sample_code' => 'SMP-' . str_pad((string)$this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT) . '-01',
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed', 'qa_passed', 'qa_failed']),
            'assigned_team_id' => Team::factory(),
            'assigned_user_id' => null,
            'notes' => $this->faker->sentence(),
        ];
    }

    /**
     * Indicate that the sample is in progress.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inProgress()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'in_progress',
                'assigned_user_id' => User::factory(),
            ];
        });
    }

    /**
     * Indicate that the sample is completed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
                'assigned_user_id' => User::factory(),
            ];
        });
    }
}