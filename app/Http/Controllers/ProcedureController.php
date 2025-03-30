<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $query = Procedure::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $procedures = $query->latest()->paginate(10);
        
        return view('procedures.index', compact('procedures', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('procedures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);
        
        $procedure = Procedure::create($request->all());
        
        return redirect()->route('procedures.index')
            ->with('success', 'Procedure created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Procedure $procedure)
    {
        return view('procedures.show', compact('procedure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Procedure $procedure)
    {
        return view('procedures.edit', compact('procedure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Procedure $procedure)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);
        
        $procedure->update($request->all());
        
        return redirect()->route('procedures.index')
            ->with('success', 'Procedure updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procedure $procedure)
    {
        // Check if procedure is associated with any appointments
        if ($procedure->appointments()->count() > 0) {
            return redirect()->route('procedures.index')
                ->with('error', 'Cannot delete procedure as it is associated with appointments.');
        }
        
        $procedure->delete();
        
        return redirect()->route('procedures.index')
            ->with('success', 'Procedure deleted successfully.');
    }
}
