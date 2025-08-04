<?php

namespace Database\Factories;

use App\Models\Sample;
use App\Models\SampleStep;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SampleStep>
 */
class SampleStepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\SampleStep>
     */
    protected $model = SampleStep::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sample_id' => Sample::factory(),
            'step_type' => $this->faker->randomElement(['material_preparation', 'pattern_data', 'cutting', 'application', 'sewing', 'finishing', 'qa']),
            'status' => $this->faker->randomElement(['pending', 'assigned', 'in_progress', 'completed']),
            'assigned_to' => null,
            'assigned_at' => null,
            'started_at' => null,
            'completed_at' => null,
            'notes' => $this->faker->sentence(),
            'step_data' => null,
        ];
    }

    /**
     * Indicate that the step is assigned.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assigned()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'assigned',
                'assigned_to' => User::factory(),
                'assigned_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            ];
        });
    }

    /**
     * Indicate that the step is completed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function completed()
    {
        return $this->state(function (array $attributes) {
            $assignedAt = $this->faker->dateTimeBetween('-2 weeks', '-1 week');
            $startedAt = $this->faker->dateTimeBetween($assignedAt, '-3 days');
            $completedAt = $this->faker->dateTimeBetween($startedAt, 'now');

            return [
                'status' => 'completed',
                'assigned_to' => User::factory(),
                'assigned_at' => $assignedAt,
                'started_at' => $startedAt,
                'completed_at' => $completedAt,
            ];
        });
    }
}