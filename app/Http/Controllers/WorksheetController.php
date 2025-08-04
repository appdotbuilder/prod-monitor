<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorksheetRequest;
use App\Http\Requests\UpdateWorksheetRequest;
use App\Models\Worksheet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $worksheets = Worksheet::with(['creator', 'approver', 'costings', 'samples'])
            ->latest()
            ->paginate(10);
        
        return Inertia::render('worksheets/index', [
            'worksheets' => $worksheets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('worksheets/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorksheetRequest $request)
    {
        $worksheet = Worksheet::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
            'worksheet_number' => 'WS-' . str_pad((string)(Worksheet::count() + 1), 6, '0', STR_PAD_LEFT),
        ]);

        return redirect()->route('worksheets.show', $worksheet)
            ->with('success', 'Worksheet created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Worksheet $worksheet)
    {
        $worksheet->load(['creator', 'approver', 'costings.creator', 'samples.assignedTeam']);
        
        return Inertia::render('worksheets/show', [
            'worksheet' => $worksheet
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Worksheet $worksheet)
    {
        return Inertia::render('worksheets/edit', [
            'worksheet' => $worksheet
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorksheetRequest $request, Worksheet $worksheet)
    {
        $worksheet->update($request->validated());

        return redirect()->route('worksheets.show', $worksheet)
            ->with('success', 'Worksheet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worksheet $worksheet)
    {
        $worksheet->delete();

        return redirect()->route('worksheets.index')
            ->with('success', 'Worksheet deleted successfully.');
    }
}