<?php
namespace App\Http\Controllers;

use App\Models\Parcelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RapportController extends Controller
{
    public function rapportInterventions(Parcelle $parcelle, Request $request)
    {
        // ✅ Contrôle d'accès
        if (Auth::user()->role->nom_role !== 'agriculteur' || $parcelle->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Accès refusé.');
        }

        // 📅 Récupération de la période
        $dateDebut = $request->input('date_debut') 
            ? Carbon::parse($request->input('date_debut')) 
            : Carbon::now()->startOfMonth();

        $dateFin = $request->input('date_fin') 
            ? Carbon::parse($request->input('date_fin')) 
            : Carbon::now();

        // 📦 Chargement des interventions liées à la parcelle
        $interventions = $parcelle->interventions()
            ->with(['typeIntervention', 'imprevus'])
            ->whereBetween('date_intervention', [$dateDebut, $dateFin])
            ->orderBy('date_intervention', 'desc')
            ->get();


        // 🔄 Récupérer toutes les parcelles avec interventions 
        // $parcelles = $user->parcelles()
        // ->with(['interventions' => function ($query) use ($dateDebut, $dateFin) {
        //     $query->with(['typeIntervention', 'imprevus'])
        //           ->whereBetween('date_intervention', [$dateDebut, $dateFin])
        //           ->orderBy('date_intervention', 'desc');
        // }])
        // ->get();

        // 📊 Statistiques
        $statistiques = [
            'total_interventions' => $interventions->count(),
            'interventions_planifiees' => $interventions->where('statut', 'planifiée')->count(),
            'interventions_terminees' => $interventions->where('statut', 'terminée')->count(),
            'interventions_annulees' => $interventions->where('statut', 'annulée')->count(),
            'total_imprevus' => $interventions->sum(fn($i) => $i->imprevus->count()),
            'cout_total' => $interventions->sum('cout'),
            'duree_totale' => $interventions->sum('duree')
        ];

        // 📄 Données à envoyer à la vue
        $data = [
            'parcelles' => $parcelles,
            'periode' => [
                'debut' => $dateDebut->format('Y-m-d'),
                'fin' => $dateFin->format('Y-m-d')
            ],
            'statistiques' => $statistiques,
            'interventions' => $interventions
        ];

        // 📥 Génération du PDF
        $pdf = PDF::loadView('rapports.interventions', $data)->setPaper('a4', 'portrait');

        // 📎 Téléchargement
        return $pdf->download('rapport-interventions-' . $parcelle->nom_parcelle . '.pdf');
    }
}
