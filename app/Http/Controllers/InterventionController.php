<?php

namespace App\Http\Controllers;

use App\Models\Imprevu;
use App\Models\Intervention;
use App\Models\Parcelle;
use App\Models\TypeIntervention;
use App\Models\User;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interventions = Intervention::with('user', 'parcelle', 'typeIntervention', 'imprevus')->get();
        return view('intervention.index', compact('interventions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $interventions = Intervention::all();
        $users = User::all();
        $parcelles = Parcelle::all();
        $typeInterventions = TypeIntervention::all();
        $imprevus = Imprevu::all();
        return view('intervention.create', compact('interventions', 'users', 'parcelles', 'typeInterventions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_intervention' => 'required|date',
            'description' => 'required|string',
            'qte_produit' => 'required|numeric',
            'date_fin' => 'nullable|date|after_or_equal:date_intervention',
            'statut_intervention' => 'required|string',
            'parcelle_id' => 'required|exists:parcelles,id',
            'type_intervention_id' => 'required|exists:type_interventions,id',
            'user_id' => 'required|exists:users,id',
            'imprevu_id' => 'required|exists:imprevus,id',
        ]);

        $intervention = new Intervention();
        $intervention->date_intervention = $validated['date_intervention'];
        $intervention->description = $validated['description'];
        $intervention->qte_produit = $validated['qte_produit'];
        $intervention->date_fin = $validated['date_fin'];
        $intervention->statut_intervention = $validated['statut_intervention'];
        $intervention->parcelle_id = $validated['parcelle_id'];
        $intervention->type_intervention_id = $validated['type_intervention_id'];
        $intervention->user_id = $validated['user_id'];
        $intervention->imprevu_id = $validated['imprevu_id'];
        $intervention->save();

        return redirect()->route('intervention.index')->with('success', 'Intervention ajoutée.');
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
    public function edit(Intervention $intervention)
    {
        $users = User::all();
        $parcelles = Parcelle::all();
        $typeInterventions = TypeIntervention::all();
        $imprevu = Imprevu::all();
        return view('intervention.edit', compact('intervention', 'users', 'parcelles', 'typeInterventions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intervention $intervention)
    {
        $validated = $request->validate([
            'date_intervention' => 'required|date',
            'description' => 'required|string',
            'qte_produit' => 'required|numeric',
            'date_fin' => 'nullable|date|after_or_equal:date_intervention',
            'statut_intervention' => 'required|string',
            'parcelle_id' => 'required|exists:parcelles,id',
            'type_intervention_id' => 'required|exists:type_interventions,id',
            'user_id' => 'required|exists:users,id',
            'imprevu_id' => 'required|exists:imprevus,id',
        ]);

        $intervention->update([
            'date_intervention' => $validated['date_intervention'],
            'description' => $validated['description'],
            'qte_produit' => $validated['qte_produit'],
            'date_fin' => $validated['date_fin'],
            'statut_intervention' => $validated['statut_intervention'],
            'parcelle_id' => $validated['parcelle_id'],
            'type_intervention_id' => $validated['type_intervention_id'],
            'user_id' => $validated['user_id'],
            'imprevu_id' => $validated['imprevu_id'],
        ]);

        return redirect()->route('intervention.index')->with('success', 'Intervention mise à jour.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intervention $intervention)
    {
        $intervention->delete();
        return redirect()->route('intervention.index')->with('success', 'Intervention supprimée.');
    }
}
