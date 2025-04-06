<?php

namespace App\Http\Controllers;

use App\Models\Parcelle;
use App\Models\Intervention;
use App\Models\Imprevu;
use App\Models\TypeIntervention;
use Carbon\Carbon;

class GlobalStatistiquesController extends Controller
{
    public function afficherStatistiquesGlobales()
    {
        // Précharger toutes les relations pour éviter les requêtes lentes
        $parcelles = Parcelle::with('interventions.imprevus', 'typeCulture')->get();
        $interventions = Intervention::with('imprevus')->get();
        $imprevus = Imprevu::all();
    
        // Statistiques globales
        $totalParcelles = $parcelles->count();
        $totalInterventions = $interventions->count();
        $totalImprevus = $imprevus->count();
    
        // Répartition par statut d’intervention
        $parStatuts = $interventions->groupBy('statut')->map->count();
    
        // Durée et coût totaux
        $dureeTotale = $interventions->sum('duree');
        $coutTotal = $interventions->sum('cout');
    
        // Moyenne d’interventions par parcelle
        $moyenneInterventions = $totalParcelles > 0 ? round($totalInterventions / $totalParcelles, 2) : 0;
    
        // Nombre de types de culture différents
        $typesCulture = $parcelles->pluck('type_culture_id')->unique()->count();
    
        // Top 3 types de culture les plus utilisés
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
    
        // Date
        $moisAnnee = Carbon::now()->locale('fr')->isoFormat('MMMM YYYY');
    
        // Retourne vers une vue avec toutes les données
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
