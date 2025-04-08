<?php

namespace App\Http\Controllers;

use App\Models\Parcelle;
use App\Models\Intervention;
use App\Models\Imprevu;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    public function afficherStatistique()
    {
        $userId = Auth::id();

        // ⚠️ On charge uniquement les parcelles de l'utilisateur connecté
        $parcelles = Parcelle::with('interventions.imprevus', 'typeCulture')
            ->where('user_id', $userId)
            ->get();

        // On extrait les interventions à partir des parcelles
        $interventions = $parcelles->flatMap->interventions;

        // Les imprevus sont déjà chargés avec les interventions
        $imprevus = $interventions->flatMap->imprevus;

        // Statistiques
        $totalParcelles = $parcelles->count();
        $totalInterventions = $interventions->count();
        $totalImprevus = $imprevus->count();

        $parStatuts = $interventions->groupBy('statut')->map->count();

        $dureeTotale = $interventions->sum('duree');
        $coutTotal = $interventions->sum('cout');

        $moyenneInterventions = $totalParcelles > 0 ? round($totalInterventions / $totalParcelles, 2) : 0;

        $typesCulture = $parcelles->pluck('type_culture_id')->unique()->count();

        $topTypesCulture = $parcelles->groupBy('type_culture_id')
            ->sortByDesc(fn($group) => count($group))
            ->take(3)
            ->map(function ($group, $typeCultureId) {
                $nom = optional($group->first()->typeCulture)->libelle ?? 'Inconnu';
                return [
                    'type_culture_id' => $typeCultureId,
                    'libelle' => $nom,
                    'nombre_parcelles' => count($group)
                ];
            })->values();

        $moisAnnee = Carbon::now()->locale('fr')->isoFormat('MMMM YYYY');

        return view('statistiques.globales', [
            'periode' => "Données du mois de $moisAnnee",
            'statistiques' => [
                'total_parcelles' => $totalParcelles,
                'total_interventions' => $totalInterventions,
                'total_imprevus' => $totalImprevus,
                'interventions_par_statut' => $parStatuts,
                'duree_totale' => $dureeTotale,
                'cout_total' => $coutTotal,
                'moyenne_interventions_par_parcelle' => $moyenneInterventions,
                'types_culture_total' => $typesCulture,
                'top_types_culture' => $topTypesCulture
            ]
        ]);
    }
}
