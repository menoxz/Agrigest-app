<?php

namespace App\Http\Controllers;

use App\Models\Imprevu;
use App\Models\Intervention;
use App\Models\Parcelle;
use Illuminate\Support\Facades\Auth;
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
        $interventions = Intervention::with('user', 'parcelle', 'typeIntervention', 'imprevus')
        ->where('user_id', Auth::user()->id) // 👈 Filtrage par user connecté
        ->get();
        return view('intervention.index', compact('interventions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parcelles = Parcelle::where('user_id',Auth::user()->id)->get(); // ✅ Parcelles de l'utilisateur
        $typeInterventions = TypeIntervention::all(); // ❓ Tu peux aussi filtrer ici si nécessaire
    
        return view('intervention.create', compact('parcelles', 'typeInterventions'));
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
    ]);

    // ✅ Vérifier que la parcelle appartient bien à l'utilisateur
    $parcelle = Parcelle::where('id', $validated['parcelle_id'])
        ->where('user_id', Auth::user()->id)
        ->first();

    if (!$parcelle) {
        abort(403, 'Cette parcelle ne vous appartient pas.');
    }

    $intervention = new Intervention();
    $intervention->fill($validated);
    $intervention->user_id = Auth::user()->id; // ✅ Lier à l'utilisateur connecté
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
    $this->authorizeIntervention($intervention); // ✅ Sécurité

    $parcelles = Parcelle::where('user_id', Auth::user()->id)->get();
    $typeInterventions = TypeIntervention::all();

    return view('intervention.edit', compact('intervention', 'parcelles', 'typeInterventions'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intervention $intervention)
{
    $this->authorizeIntervention($intervention); // ✅ Check propriétaire

    $validated = $request->validate([
        'date_intervention' => 'required|date',
        'description' => 'required|string',
        'qte_produit' => 'required|numeric',
        'date_fin' => 'nullable|date|after_or_equal:date_intervention',
        'statut_intervention' => 'required|string',
        'parcelle_id' => 'required|exists:parcelles,id',
        'type_intervention_id' => 'required|exists:type_interventions,id',
    ]);

    // ✅ Vérification que la parcelle appartient bien à l’utilisateur
    $parcelle = Parcelle::where('id', $validated['parcelle_id'])
        ->where('user_id', Auth::user()->id)
        ->first();

    if (!$parcelle) {
        abort(403, 'Vous ne pouvez pas affecter cette intervention à une parcelle qui ne vous appartient pas.');
    }

    $intervention->update($validated);

    return redirect()->route('intervention.index')->with('success', 'Intervention mise à jour.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intervention $intervention)
{
    $this->authorizeIntervention($intervention); // ✅ Check
    $intervention->delete();

    return redirect()->route('intervention.index')->with('success', 'Intervention supprimée.');
}


    protected function authorizeIntervention(Intervention $intervention)
    {
        if ($intervention->user_id !== Auth::user()->id) {
            abort(403, 'Accès non autorisé à cette parcelle.');
        }
    }
}
