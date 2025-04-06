<?php

namespace App\Http\Controllers;

use App\Models\Imprevu;
use App\Models\Intervention;
use Illuminate\Http\Request;

class ImprevuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imprevus = Imprevu::all();
        return view('imprevu.index', compact('imprevus'));        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $interventions = Intervention::all();
        return view('imprevu.create', compact('interventions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'description' => 'required|string',
        ]);

        imprevu::create($validated);

        return redirect()->route('imprevu.index')->with('success', 'Imprevu ajoutée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imprevu $imprevu)
    {
        $interventions = Intervention::all();
        return view('imprevu.edit', compact('imprevu', 'interventions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imprevu $imprevu)
    {
        $validated=$request->validate([
            'description' => 'required|string',
        ]);

        $imprevu->update($validated);

        return redirect()->route('imprevu.index')->with('success', 'Imprevu mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imprevu $imprevu)
    {
        $imprevu->delete();
        return redirect()->route('imprevu.index')->with('succes','Imprevu supprimée.');
    }
}
