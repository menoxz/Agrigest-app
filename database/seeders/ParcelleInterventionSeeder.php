<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parcelle;
use App\Models\Intervention;
use App\Models\User;
use App\Models\TypeIntervention;
use App\Models\Imprevu;
use Carbon\Carbon;
use App\Models\TypeCulture;

class ParcelleInterventionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier et créer des utilisateurs de test
        $user1 = User::firstOrCreate(
            ['email' => 'jean@example.com'],
            [
                'name' => 'jean',
                'password' => bcrypt('jean')
            ]
        );
        $user2 = User::firstOrCreate(
            ['email' => 'bob@example.com'],
            [
                'name' => 'Bob',
                'password' => bcrypt('bob')
            ]
        );

        // Créer des types d'intervention
        $type1 = TypeIntervention::create(['libelle' => 'Traitement']);
        $type2 = TypeIntervention::create(['libelle' => 'Récolte']);

        // Créer un type de culture
        $typeCulture = TypeCulture::create(['libelle' => 'Blé']);

        // Créer des parcelles
        $parcelle1 = Parcelle::create(['nom_parcelle' => 'Parcelle A', 'superficie' => 100, 'statut' => 'En culture', 'date_plantation' => Carbon::now()->subMonths(3), 'type_culture_id' => $typeCulture->id, 'user_id' => $user1->id]);
        $parcelle2 = Parcelle::create(['nom_parcelle' => 'Parcelle B', 'superficie' => 150, 'statut' => 'En jachère', 'date_plantation' => Carbon::now()->subMonths(6), 'type_culture_id' => $typeCulture->id, 'user_id' => $user2->id]);

        // Créer des interventions pour la parcelle 1
        Intervention::create([
            'parcelle_id' => $parcelle1->id,
            'type_intervention_id' => $type1->id,
            'type_intervention' => 'Traitement',
            'date_intervention' => Carbon::now()->subDays(10),
            'description' => 'Traitement phytosanitaire',
            'user_id' => $user1->id
        ]);

        Intervention::create([
            'parcelle_id' => $parcelle1->id,
            'type_intervention_id' => $type2->id,
            'type_intervention' => 'Récolte',
            'date_intervention' => Carbon::now()->subDays(5),
            'description' => 'Récolte de pommes',
            'user_id' => $user1->id
        ]);

        // Créer des imprévus pour les interventions
        Imprevu::create([
            'intervention_id' => 1,
            'description' => 'Pluie inattendue'
        ]);
    }
}
