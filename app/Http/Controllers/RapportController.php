<?php

namespace App\Http\Controllers;

use App\Models\Parcelle;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RapportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function rapportInterventions(Parcelle $parcelle, Request $request)
    {
        // Vérifier si l'utilisateur a accès à cette parcelle
        if (Auth::user()->role->nom_role !== 'admin' && $parcelle->user_id !== Auth::id()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        // Récupérer les paramètres de filtrage
        $dateDebut = $request->input('date_debut') ? Carbon::parse($request->input('date_debut')) : Carbon::now()->startOfMonth();
        $dateFin = $request->input('date_fin') ? Carbon::parse($request->input('date_fin')) : Carbon::now();

        // Récupérer les interventions avec leurs relations
        $interventions = $parcelle->interventions()
            ->with(['typeIntervention', 'imprevus'])
            ->whereBetween('date_intervention', [$dateDebut, $dateFin])
            ->orderBy('date_intervention', 'desc')
            ->get();

        // Calculer les statistiques
        $statistiques = [
            'total_interventions' => $interventions->count(),
            'interventions_planifiees' => $interventions->where('statut', 'planifiée')->count(),
            'interventions_terminees' => $interventions->where('statut', 'terminée')->count(),
            'interventions_annulees' => $interventions->where('statut', 'annulée')->count(),
            'total_imprevus' => $interventions->sum(function ($intervention) {
                return $intervention->imprevus->count();
            }),
            'cout_total' => $interventions->sum('cout'),
            'duree_totale' => $interventions->sum('duree')
        ];

        // Préparer le rapport détaillé
        $rapport = [
            'parcelle' => [
                'id' => $parcelle->id,
                'nom' => $parcelle->nom_parcelle,
                'surface' => $parcelle->superficie,
                'statut' => $parcelle->statut,
                'utilisateur' => $parcelle->user ? [
                    'id' => $parcelle->user->id,
                    'nom' => $parcelle->user->name,
                    'email' => $parcelle->user->email
                ] : null
            ],
            'periode' => [
                'debut' => $dateDebut->format('Y-m-d'),
                'fin' => $dateFin->format('Y-m-d')
            ],
            'statistiques' => $statistiques,
            'interventions' => $interventions->map(function ($intervention) {
                return [
                    'id' => $intervention->id,
                    'date' => $intervention->date_intervention,
                    'type' => $intervention->typeIntervention->nom_type_intervention,
                    'description' => $intervention->description,
                    'statut' => $intervention->statut,
                    'cout' => $intervention->cout,
                    'duree' => $intervention->duree,
                    'imprevus' => $intervention->imprevus->map(function ($imprevu) {
                        return [
                            'id' => $imprevu->id,
                            'description' => $imprevu->description,
                            'impact' => $imprevu->impact,
                            'solution' => $imprevu->solution
                        ];
                    })
                ];
            })
        ];

        return response()->json($rapport);
    }
}
