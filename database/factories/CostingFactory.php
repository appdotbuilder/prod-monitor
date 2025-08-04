<?php

namespace Database\Factories;

use App\Models\Costing;
use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Costing>
 */
class CostingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Costing>
     */
    protected $model = Costing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $materialCost = $this->faker->randomFloat(2, 50, 500);
        $laborCost = $this->faker->randomFloat(2, 30, 200);
        $overheadCost = $this->faker->randomFloat(2, 20, 100);

        return [
            'worksheet_id' => Worksheet::factory(),
            'material_cost' => $materialCost,
            'labor_cost' => $laborCost,
            'overhead_cost' => $overheadCost,
            'total_cost' => $materialCost + $laborCost + $overheadCost,
            'approval_status' => $this->faker->randomElement(['pending', 'production_approved', 'finance_approved', 'rejected']),
            'created_by' => User::factory(),
            'production_approved_by' => null,
            'finance_approved_by' => null,
            'production_approved_at' => null,
            'finance_approved_at' => null,
            'approval_notes' => null,
            'revision_number' => 1,
        ];
    }

    /**
     * Indicate that the costing is approved by production.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function productionApproved()
    {
        return $this->state(function (array $attributes) {
            return [
                'approval_status' => 'production_approved',
                'production_approved_by' => User::factory(),
                'production_approved_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            ];
        });
    }

    /**
     * Indicate that the costing is fully approved.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function financeApproved()
    {
        return $this->state(function (array $attributes) {
            return [
                'approval_status' => 'finance_approved',
                'production_approved_by' => User::factory(),
                'finance_approved_by' => User::factory(),
                'production_approved_at' => $this->faker->dateTimeBetween('-1 week', '-3 days'),
                'finance_approved_at' => $this->faker->dateTimeBetween('-3 days', 'now'),
            ];
        });
    }
}