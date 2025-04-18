<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\TypeIntervention;

class TypeInterventionController extends Controller
{
    public function index()
    {
        $interventions = TypeIntervention::where('user_id', Auth::user()->id)->get();
        return view('type-intervention.index', compact('interventions'));
    }

    public function create()
    {
        return view('type-intervention.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|unique:type_interventions|max:255',
        ]);

        TypeIntervention::create([
            'libelle' => $request->libelle,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('type-intervention.index')->with('success', 'Type d’intervention ajouté.');
    }

    public function edit(TypeIntervention $typeIntervention)
    {
        $this->authorizeTypeIntervention($typeIntervention);
        return view('type-intervention.edit', compact('typeIntervention'));
    }

    public function update(Request $request, TypeIntervention $typeIntervention)
    {
        $this->authorizeTypeIntervention($typeIntervention);

        $request->validate([
            'libelle' => 'required|max:255|unique:type_interventions,libelle,' . $typeIntervention->id,
        ]);

        $typeIntervention->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('type-intervention.index')->with('success', 'Type d’intervention mis à jour.');
    }

    public function destroy(TypeIntervention $typeIntervention)
    {
        $this->authorizeTypeIntervention($typeIntervention);
        $typeIntervention->delete();

        return redirect()->route('type-intervention.index')->with('success', 'Type d’intervention supprimé.');
    }

    protected function authorizeTypeIntervention(TypeIntervention $typeIntervention)
    {
        if ($typeIntervention->user_id !== Auth::user()->id) {
            abort(403, 'Vous n\'avez pas accès à ce type d’intervention.');
        }
    }
}
