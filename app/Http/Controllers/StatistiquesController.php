<?php

namespace App\Http\Controllers;

use App\Models\Parcelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
class StatistiquesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function afficherStatistiques(Parcelle $parcelle)
    {
        // Vérifier si l'utilisateur a accès à cette parcelle
        if (Auth::user()->role->nom_role !== 'admin' || $parcelle->user_id !== Auth::id()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        // Récupérer les interventions de la parcelle
        $interventions = $parcelle->interventions;

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

        return response()->json([
            'parcelle' => $parcelle,
            'statistiques' => $statistiques
        ]);
    }
}
