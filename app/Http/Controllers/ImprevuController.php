<?php

namespace App\Http\Controllers;

use App\Models\Imprevu;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImprevuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imprevus = Imprevu::whereHas('intervention', function ($query) {
            $query->where('user_id', Auth::user()->id); // ✅ Seulement les interventions de l'utilisateur
        })->with('intervention')->get();

        return view('imprevu.index', compact('imprevus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $interventions = Intervention::where('user_id', Auth::user()->id)->get(); // ✅ Interventions de l'utilisateur
        return view('imprevu.create', compact('interventions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'intervention_id' => 'required|exists:interventions,id',
        ]);

        // ✅ Vérifier que l'intervention appartient à l'utilisateur connecté
        $intervention = Intervention::where('id', $validated['intervention_id'])
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$intervention) {
            abort(403, 'Vous ne pouvez pas ajouter un imprévu à une intervention qui ne vous appartient pas.');
        }

        Imprevu::create($validated);

        return redirect()->route('imprevu.index')->with('success', 'Imprévu ajouté.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imprevu $imprevu)
    {
        $this->authorizeImprevu($imprevu); // ✅ Vérification propriétaire

        $interventions = Intervention::where('user_id', Auth::user()->id)->get();
        return view('imprevu.edit', compact('imprevu', 'interventions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imprevu $imprevu)
    {
        $this->authorizeImprevu($imprevu); // ✅ Vérification

        $validated = $request->validate([
            'description' => 'required|string',
            'intervention_id' => 'required|exists:interventions,id',
        ]);

        // ✅ Vérifier que l'intervention appartient bien à l'utilisateur
        $intervention = Intervention::where('id', $validated['intervention_id'])
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$intervention) {
            abort(403, 'Vous ne pouvez pas lier cet imprévu à une intervention qui ne vous appartient pas.');
        }

        $imprevu->update($validated);

        return redirect()->route('imprevu.index')->with('success', 'Imprévu mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imprevu $imprevu)
    {
        $this->authorizeImprevu($imprevu); // ✅ Sécurité
        $imprevu->delete();

        return redirect()->route('imprevu.index')->with('success','Imprévu supprimé.');
    }

    /**
     * Vérifie que l'imprévu est bien lié à une intervention de l'utilisateur connecté.
     */
    protected function authorizeImprevu(Imprevu $imprevu)
    {
        if ($imprevu->intervention->user_id !== Auth::user()->id) {
            abort(403, 'Accès non autorisé à cet imprévu.');
        }
    }
}
