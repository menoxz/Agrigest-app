<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Parcelle;
use App\Models\TypeCulture;

class ParcelleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parcelles = Parcelle::with('typeCulture')->get();
        return view('parcelle.index', compact('parcelles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parcelle = Parcelle::all();
        $typeCulture = TypeCulture::all();
        return view('parcelle.create', compact('parcelle', 'typeCulture'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'nom_parcelle' => 'required|string|max:255',
            'superficie' => 'required|numeric',
            'date_plantation' => 'nullable|date',
            'statut' => 'required',
            'type_culture_id' => 'required|exists:type_cultures,id',
        ]);
      //  dd($request->all());

        Parcelle::create([
            'nom_parcelle' => $request->nom_parcelle,
            'superficie' => $request->superficie,
            'type_culture_id' => $request->type_culture_id,
            'date_plantation' => $request->date_plantation,
            'statut' => $request->statut,
        ]);
      //  dd('ici',$request->all());
     return redirect()->route('parcelle.index')->with('success', 'Parcelle ajoutée avec succès.');
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parcelle $parcelle)
    {
        $typesCultures = TypeCulture::all();
        return view('parcelle.edit', compact('parcelle', 'typesCultures'));
    }

    public function update(Request $request, Parcelle $parcelle)
    {
        $request->validate([
            'nom_parcelle' => 'required|string|max:255',
            'superficie' => 'required|numeric',
            'date_plantation' => 'nullable|date',
            'statut' => 'required',
            'type_culture_id' => 'required|exists:type_cultures,id',
        ]);

        $parcelle->update($request->all());

        return redirect()->route('parcelle.index')->with('success', 'Parcelle mise à jour avec succès.');
    }

    public function destroy(Parcelle $parcelle)
    {
        $parcelle->delete();
        return redirect()->route('parcelle.index')->with('success', 'Parcelle supprimée avec succès.');
    }
}
