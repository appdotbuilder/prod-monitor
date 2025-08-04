<?php

namespace Database\Seeders;

use App\Models\Costing;
use App\Models\Sample;
use App\Models\SampleStep;
use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users with different roles
        $productionManager = User::create([
            'name' => 'John Manager',
            'email' => 'manager@production.com',
            'password' => bcrypt('password'),
            'role' => 'production_manager',
            'team_id' => 1,
            'is_active' => true,
        ]);

        $financeManager = User::create([
            'name' => 'Sarah Finance',
            'email' => 'finance@production.com',
            'password' => bcrypt('password'),
            'role' => 'finance_manager',
            'is_active' => true,
        ]);

        $productionStaff = User::create([
            'name' => 'Mike Producer',
            'email' => 'staff@production.com',
            'password' => bcrypt('password'),
            'role' => 'production_staff',
            'team_id' => 2,
            'is_active' => true,
        ]);

        $teamMember = User::create([
            'name' => 'Lisa Worker',
            'email' => 'worker@production.com',
            'password' => bcrypt('password'),
            'role' => 'team_member',
            'team_id' => 1,
            'is_active' => true,
        ]);

        // Create sample worksheets
        $worksheets = [
            [
                'worksheet_number' => 'WS-000001',
                'product_name' => 'Summer T-Shirt Collection',
                'description' => 'Basic cotton t-shirts in various colors and sizes',
                'status' => 'approved',
                'production_type' => 'internal',
                'created_by' => $productionStaff->id,
                'approved_by' => $productionManager->id,
                'approved_at' => now()->subDays(5),
                'approval_notes' => 'Approved for internal production with cost estimation',
            ],
            [
                'worksheet_number' => 'WS-000002',
                'product_name' => 'Denim Jacket Line',
                'description' => 'Premium denim jackets with custom embroidery',
                'status' => 'approved',
                'production_type' => 'fob',
                'created_by' => $productionStaff->id,
                'approved_by' => $productionManager->id,
                'approved_at' => now()->subDays(3),
                'approval_notes' => 'Approved for FOB production due to complexity',
            ],
            [
                'worksheet_number' => 'WS-000003',
                'product_name' => 'Athletic Shorts',
                'description' => 'Moisture-wicking athletic shorts for sports teams',
                'status' => 'pending',
                'production_type' => null,
                'created_by' => $productionStaff->id,
            ],
            [
                'worksheet_number' => 'WS-000004',
                'product_name' => 'Corporate Polo Shirts',
                'description' => 'Professional polo shirts with logo embroidery',
                'status' => 'approved',
                'production_type' => 'internal',
                'created_by' => $productionStaff->id,
                'approved_by' => $productionManager->id,
                'approved_at' => now()->subDays(1),
                'approval_notes' => 'Standard internal production approved',
            ],
        ];

        foreach ($worksheets as $worksheetData) {
            $worksheet = Worksheet::create($worksheetData);

            // Create costings for approved worksheets
            if ($worksheet->status === 'approved') {
                $costing = Costing::create([
                    'worksheet_id' => $worksheet->id,
                    'material_cost' => random_int(50, 200),
                    'labor_cost' => random_int(30, 100),
                    'overhead_cost' => random_int(20, 80),
                    'total_cost' => 0, // Will be calculated
                    'approval_status' => random_int(1, 3) === 1 ? 'pending' : (random_int(1, 2) === 1 ? 'production_approved' : 'finance_approved'),
                    'created_by' => $productionStaff->id,
                    'production_approved_by' => random_int(1, 2) === 1 ? $productionManager->id : null,
                    'finance_approved_by' => random_int(1, 3) === 1 ? $financeManager->id : null,
                    'production_approved_at' => random_int(1, 2) === 1 ? now()->subDays(random_int(1, 3)) : null,
                    'finance_approved_at' => random_int(1, 3) === 1 ? now()->subDays(random_int(0, 2)) : null,
                    'revision_number' => 1,
                ]);

                // Update total cost
                $costing->update([
                    'total_cost' => $costing->material_cost + $costing->labor_cost + $costing->overhead_cost
                ]);

                // Create samples for finance-approved costings
                if ($costing->approval_status === 'finance_approved') {
                    $sample = Sample::create([
                        'worksheet_id' => $worksheet->id,
                        'costing_id' => $costing->id,
                        'sample_code' => 'SMP-' . str_pad((string)$worksheet->id, 4, '0', STR_PAD_LEFT) . '-01',
                        'status' => random_int(1, 2) === 1 ? 'in_progress' : 'pending',
                        'assigned_team_id' => $worksheet->production_type === 'internal' ? random_int(1, 2) : random_int(3, 4),
                        'assigned_user_id' => $worksheet->production_type === 'fob' ? $teamMember->id : null,
                        'notes' => 'Sample production initiated after costing approval',
                    ]);

                    // Create sample steps
                    $stepTypes = ['material_preparation', 'pattern_data', 'cutting', 'application', 'sewing', 'finishing', 'qa'];
                    $currentDate = now()->subDays(random_int(7, 14));

                    foreach ($stepTypes as $index => $stepType) {
                        $status = 'pending';
                        $assignedAt = null;
                        $startedAt = null;
                        $completedAt = null;

                        // Simulate progress through steps
                        if ($index < random_int(2, 5)) {
                            $status = 'completed';
                            $assignedAt = $currentDate->copy()->addHours(random_int(1, 4));
                            $startedAt = $assignedAt->copy()->addHours(random_int(1, 8));
                            $completedAt = $startedAt->copy()->addHours(random_int(4, 24));
                            $currentDate = $completedAt;
                        } elseif ($index === random_int(2, 5)) {
                            $status = 'in_progress';
                            $assignedAt = $currentDate->copy()->addHours(random_int(1, 4));
                            $startedAt = $assignedAt->copy()->addHours(random_int(1, 8));
                        } elseif ($index === random_int(2, 5) + 1) {
                            $status = 'assigned';
                            $assignedAt = $currentDate->copy()->addHours(random_int(1, 4));
                        }

                        SampleStep::create([
                            'sample_id' => $sample->id,
                            'step_type' => $stepType,
                            'status' => $status,
                            'assigned_to' => $status !== 'pending' ? $teamMember->id : null,
                            'assigned_at' => $assignedAt,
                            'started_at' => $startedAt,
                            'completed_at' => $completedAt,
                            'notes' => $status === 'completed' ? 'Step completed successfully' : ($status === 'in_progress' ? 'Currently in progress' : null),
                            'step_data' => $stepType === 'material_preparation' ? json_encode([
                                'materials_requested' => random_int(3, 8),
                                'materials_received' => random_int(0, 6),
                            ]) : null,
                        ]);
                    }
                }
            }
        }
    }
}