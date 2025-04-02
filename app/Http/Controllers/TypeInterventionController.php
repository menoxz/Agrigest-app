<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TypeIntervention;

class TypeInterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interventions= TypeIntervention::all();
        return view('type-intervention.index', compact('interventions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type-intervention.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // dd("je suis ici", $request->all());
        $request->validate([
            'libelle' =>'required|unique:type_interventions|max:255',
        ]);
        TypeIntervention::create([
            'libelle' => $request->libelle,
        ]);
        return redirect()->route('type-intervention.index')->with('success','type intervention ajouté');
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeIntervention $typeIntervention)
    {
        return view('type-intervention.edit', compact('typeIntervention'));
    }

    public function update(Request $request, TypeIntervention $typeIntervention)
    {
        $request->validate([
            'libelle' => 'required|max:255|unique:type_interventions,libelle,' . $typeIntervention->id,
        ]);

        $typeIntervention->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('type-intervention.index')->with('success', 'Type de intervention mis à jour.');
    }

    public function destroy(TypeIntervention $typeIntervention)
    {
        $typeIntervention->delete();
        return redirect()->route('type-intervention.index')->with('success', 'Type de intervention supprimé.');
    }
}
