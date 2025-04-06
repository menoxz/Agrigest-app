<?php

namespace App\Http\Controllers;

use App\Models\Parcelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class GlobalStatistiquesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function afficherStatistiquesGlobales()
    {
        $userId = Auth::id();
        $cacheKey = 'global_stats_user_' . $userId;

        // Vérifier si les statistiques sont en cache
        $statistiques = Cache::remember($cacheKey, 60, function () use ($userId) {
            $parcelles = Parcelle::where('user_id', $userId)->get();

            $totalParcelles = $parcelles->count();
            $totalInterventions = $parcelles->sum(function ($parcelle) {
                return $parcelle->interventions->count();
            });
            $totalImprevus = $parcelles->sum(function ($parcelle) {
                return $parcelle->interventions->sum(function ($intervention) {
                    return $intervention->imprevus->count();
                });
            });
            $typesCulture = $parcelles->groupBy('type_culture_id')->count();

            return [
                'total_parcelles' => $totalParcelles,
                'total_interventions' => $totalInterventions,
                'total_imprevus' => $totalImprevus,
                'types_culture' => $typesCulture
            ];
        });

        $moisAnnee = Carbon::now()->format('F Y');

        return view('statistiques.globales', [
            'statistiques' => $statistiques,
            'periode' => "Données en cours de mois - $moisAnnee"
        ]);
    }
}
