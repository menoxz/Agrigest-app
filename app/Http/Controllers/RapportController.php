<?php

namespace App\Http\Controllers;

use App\Models\Parcelle;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
class RapportController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function rapportInterventions(Parcelle $parcelle, Request $request)
    {
        // Vérifier si l'utilisateur a accès à cette parcelle
        if (Auth::user()->role->nom_role !== 'admin' || $parcelle->user_id !== Auth::id()) {
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

        // Préparer les données pour la vue
        $data = [
            'parcelle' => $parcelle,
            'periode' => [
                'debut' => $dateDebut->format('Y-m-d'),
                'fin' => $dateFin->format('Y-m-d')
            ],
            'statistiques' => $statistiques,
            'interventions' => $interventions
        ];

        // Générer le PDF
        $pdf = PDF::loadView('rapports.interventions', $data);

        // Configurer le PDF
        $pdf->setPaper('a4', 'portrait');

        // Retourner le PDF pour téléchargement
        return $pdf->download('rapport-interventions-' . $parcelle->nom_parcelle . '.pdf');
    }
}
