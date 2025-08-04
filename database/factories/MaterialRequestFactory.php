<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\MaterialRequest;
use App\Models\SampleStep;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaterialRequest>
 */
class MaterialRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\MaterialRequest>
     */
    protected $model = MaterialRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $requestedAt = $this->faker->dateTimeBetween('-1 month', 'now');
        
        return [
            'sample_step_id' => SampleStep::factory(),
            'material_id' => Material::factory(),
            'quantity' => $this->faker->randomFloat(2, 1, 100),
            'source' => $this->faker->randomElement(['warehouse', 'supplier', 'direct_purchase']),
            'status' => $this->faker->randomElement(['requested', 'sourcing', 'ordered', 'received']),
            'requested_by' => User::factory(),
            'requested_at' => $requestedAt,
            'received_at' => null,
            'notes' => $this->faker->sentence(),
        ];
    }

    /**
     * Indicate that the material request is received.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function received()
    {
        return $this->state(function (array $attributes) {
            $requestedAt = $this->faker->dateTimeBetween('-1 month', '-1 week');
            $receivedAt = $this->faker->dateTimeBetween($requestedAt, 'now');

            return [
                'status' => 'received',
                'requested_at' => $requestedAt,
                'received_at' => $receivedAt,
            ];
        });
    }

    /**
     * Indicate that the material request is pending.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => $this->faker->randomElement(['requested', 'sourcing', 'ordered']),
                'received_at' => null,
            ];
        });
    }
}