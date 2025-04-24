<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Parcelle;
use App\Models\TypeCulture;

class ParcelleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parcelles = Parcelle::with('typeCulture')
            ->where('user_id', Auth::user()->id) // 👈 Filtrage par user connecté
            ->get();

        return view('parcelle.index', compact('parcelles'));
    }

    /**
     * Show the map of all parcelles or a specific one.
     */
    public function map(Parcelle $parcelle = null)
    {
        // Si un ID de parcelle est fourni, afficher la carte de cette parcelle
        if ($parcelle) {
            $this->authorizeParcelle($parcelle); // 🔐 Check propriétaire
            return view('parcelle.map', compact('parcelle'));
        }

        // Sinon, afficher la carte de toutes les parcelles de l'utilisateur
        $parcelles = Parcelle::with('typeCulture')
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('parcelle.map', compact('parcelles'));
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
        $request->validate([
            'nom_parcelle' => 'required|string|max:255',
            'superficie' => 'required|numeric',
            'date_plantation' => 'nullable|date',
            'statut' => 'required',
            'type_culture_id' => 'required|exists:type_cultures,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        Parcelle::create([
            'nom_parcelle' => $request->nom_parcelle,
            'superficie' => $request->superficie,
            'type_culture_id' => $request->type_culture_id,
            'date_plantation' => $request->date_plantation,
            'statut' => $request->statut,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'user_id' => Auth::user()->id, // 👈 Associer à l'utilisateur connecté
        ]);

        return redirect()->route('parcelle.index')->with('success', 'Parcelle ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Parcelle $parcelle)
    {
        $this->authorizeParcelle($parcelle); // 🔐 Check propriétaire

        // Rediriger vers la carte de cette parcelle
        return redirect()->route('parcelle.map', $parcelle);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parcelle $parcelle)
    {
        $this->authorizeParcelle($parcelle); // 🔐 Check propriétaire
        $typeCulture = TypeCulture::all();

        return view('parcelle.edit', compact('parcelle', 'typeCulture'));
    }

    public function update(Request $request, Parcelle $parcelle)
    {
        $this->authorizeParcelle($parcelle); // 🔐 Check propriétaire

        $request->validate([
            'nom_parcelle' => 'required|string|max:255',
            'superficie' => 'required|numeric',
            'date_plantation' => 'nullable|date',
            'statut' => 'required',
            'type_culture_id' => 'required|exists:type_cultures,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $parcelle->update($request->all());

        return redirect()->route('parcelle.index')->with('success', 'Parcelle mise à jour avec succès.');
    }

    public function destroy(Parcelle $parcelle)
    {
        $this->authorizeParcelle($parcelle); // 🔐 Check propriétaire
        $parcelle->delete();

        return redirect()->route('parcelle.index')->with('success', 'Parcelle supprimée avec succès.');
    }

    protected function authorizeParcelle(Parcelle $parcelle)
    {
        if ($parcelle->user_id !== Auth::user()->id) {
            abort(403, 'Accès non autorisé à cette parcelle.');
        }
    }
}
