<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCostingRequest;
use App\Http\Requests\UpdateCostingRequest;
use App\Models\Costing;
use App\Models\Worksheet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costings = Costing::with(['worksheet', 'creator', 'productionApprover', 'financeApprover'])
            ->latest()
            ->paginate(10);
        
        return Inertia::render('costings/index', [
            'costings' => $costings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $worksheet = null;
        if ($request->has('worksheet_id')) {
            $worksheet = Worksheet::findOrFail($request->worksheet_id);
        }
        
        $worksheets = Worksheet::where('status', 'approved')
            ->where('production_type', '!=', null)
            ->get();
        
        return Inertia::render('costings/create', [
            'worksheet' => $worksheet,
            'worksheets' => $worksheets
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCostingRequest $request)
    {
        $validated = $request->validated();
        
        // Calculate total cost
        $validated['total_cost'] = $validated['material_cost'] + $validated['labor_cost'] + $validated['overhead_cost'];
        $validated['created_by'] = auth()->id();
        
        // Get the next revision number for this worksheet
        $latestRevision = Costing::where('worksheet_id', $validated['worksheet_id'])
            ->max('revision_number') ?? 0;
        $validated['revision_number'] = $latestRevision + 1;

        $costing = Costing::create($validated);

        return redirect()->route('costings.show', $costing)
            ->with('success', 'Costing created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Costing $costing)
    {
        $costing->load(['worksheet', 'creator', 'productionApprover', 'financeApprover', 'samples']);
        
        return Inertia::render('costings/show', [
            'costing' => $costing
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Costing $costing)
    {
        return Inertia::render('costings/edit', [
            'costing' => $costing
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCostingRequest $request, Costing $costing)
    {
        $validated = $request->validated();
        $validated['total_cost'] = $validated['material_cost'] + $validated['labor_cost'] + $validated['overhead_cost'];
        
        $costing->update($validated);

        return redirect()->route('costings.show', $costing)
            ->with('success', 'Costing updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Costing $costing)
    {
        $costing->delete();

        return redirect()->route('costings.index')
            ->with('success', 'Costing deleted successfully.');
    }
}