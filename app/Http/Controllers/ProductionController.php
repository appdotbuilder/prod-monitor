<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Costing;
use App\Models\Sample;
use App\Models\SampleStep;
use App\Models\Worksheet;
use Inertia\Inertia;

class ProductionController extends Controller
{
    /**
     * Display the production monitoring dashboard.
     */
    public function index()
    {
        // Get summary statistics
        $stats = [
            'pending_worksheets' => Worksheet::where('status', 'pending')->count(),
            'approved_worksheets' => Worksheet::where('status', 'approved')->count(),
            'pending_costings' => Costing::where('approval_status', 'pending')->count(),
            'active_samples' => Sample::where('status', 'in_progress')->count(),
            'pending_steps' => SampleStep::where('status', 'assigned')->count(),
        ];

        // Get recent worksheets
        $recentWorksheets = Worksheet::with(['creator', 'approver'])
            ->latest()
            ->take(5)
            ->get();

        // Get active samples with their progress
        $activeSamples = Sample::with(['worksheet', 'costing', 'assignedTeam', 'steps'])
            ->where('status', 'in_progress')
            ->take(10)
            ->get()
            ->map(function ($sample) {
                $totalSteps = $sample->steps->count();
                $completedSteps = $sample->steps->where('status', 'completed')->count();
                $progress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
                
                return [
                    'id' => $sample->id,
                    'sample_code' => $sample->sample_code,
                    'status' => $sample->status,
                    'progress' => $progress,
                    'worksheet' => $sample->worksheet,
                    'assigned_team' => $sample->assignedTeam,
                ];
            });

        // Get pending approvals based on user role
        $pendingApprovals = collect();
        $user = auth()->user();
        
        if ($user->role === 'production_manager') {
            $pendingApprovals = Worksheet::where('status', 'pending')
                ->with('creator')
                ->get()
                ->concat(
                    Costing::where('approval_status', 'pending')
                        ->with(['worksheet', 'creator'])
                        ->get()
                );
        } elseif ($user->role === 'finance_manager') {
            $pendingApprovals = Costing::where('approval_status', 'production_approved')
                ->with(['worksheet', 'creator'])
                ->get();
        }

        return Inertia::render('production/dashboard', [
            'stats' => $stats,
            'recentWorksheets' => $recentWorksheets,
            'activeSamples' => $activeSamples,
            'pendingApprovals' => $pendingApprovals,
        ]);
    }
}