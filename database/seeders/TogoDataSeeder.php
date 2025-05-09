<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\TypeCulture;
use App\Models\TypeIntervention;
use App\Models\Parcelle;
use App\Models\Intervention;
use App\Models\Imprevu;
use Carbon\Carbon;

class TogoDataSeeder extends Seeder
{
    /**
     * Seed the database with Togo-specific data.
     */
    public function run(): void
    {
        // Assurons-nous que les rôles existent
        $roleAgriculteur = Role::firstOrCreate(
            ['nom_role' => 'agriculteur'],
            ['description' => 'Utilisateur agriculteur']
        );

        $roleAdmin = Role::firstOrCreate(
            ['nom_role' => 'admin'],
            ['description' => 'Administrateur du système']
        );

        // Création de l'administrateur si nécessaire
        $admin = User::firstOrCreate(
            ['email' => 'admin@agrigest.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'),
                'role_id' => $roleAdmin->id,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1,
            ]
        );

        // Création d'utilisateurs agriculteurs togolais
        $users = [
            [
                'name' => 'Kokou Mensah',
                'email' => 'kokou@agrigest.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Afi Adanou',
                'email' => 'afi@agrigest.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Kossi Amegbeto',
                'email' => 'kossi@agrigest.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Yawa Agbogbe',
                'email' => 'yawa@agrigest.com',
                'password' => 'password123',
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role_id' => $roleAgriculteur->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'status' => 1,
                ]
            );
        }

        // Création des types de cultures courants au Togo
        $typesCultures = [
            ['libelle' => 'Maïs', 'user_id' => $admin->id],
            ['libelle' => 'Manioc', 'user_id' => $admin->id],
            ['libelle' => 'Igname', 'user_id' => $admin->id],
            ['libelle' => 'Coton', 'user_id' => $admin->id],
            ['libelle' => 'Café', 'user_id' => $admin->id],
            ['libelle' => 'Cacao', 'user_id' => $admin->id],
            ['libelle' => 'Riz', 'user_id' => $admin->id],
            ['libelle' => 'Sorgho', 'user_id' => $admin->id],
            ['libelle' => 'Mil', 'user_id' => $admin->id],
            ['libelle' => 'Arachide', 'user_id' => $admin->id],
            ['libelle' => 'Soja', 'user_id' => $admin->id],
            ['libelle' => 'Haricot', 'user_id' => $admin->id],
            ['libelle' => 'Palmier à huile', 'user_id' => $admin->id],
            ['libelle' => 'Ananas', 'user_id' => $admin->id],
            ['libelle' => 'Banane', 'user_id' => $admin->id],
        ];

        foreach ($typesCultures as $typeCulture) {
            TypeCulture::firstOrCreate(
                ['libelle' => $typeCulture['libelle']],
                ['user_id' => $typeCulture['user_id']]
            );
        }

        // Création des types d'interventions
        $typesInterventions = [
            ['libelle' => 'Semis', 'user_id' => $admin->id],
            ['libelle' => 'Plantation', 'user_id' => $admin->id],
            ['libelle' => 'Désherbage', 'user_id' => $admin->id],
            ['libelle' => 'Fertilisation', 'user_id' => $admin->id],
            ['libelle' => 'Traitement phytosanitaire', 'user_id' => $admin->id],
            ['libelle' => 'Irrigation', 'user_id' => $admin->id],
            ['libelle' => 'Récolte', 'user_id' => $admin->id],
            ['libelle' => 'Taille', 'user_id' => $admin->id],
            ['libelle' => 'Labour', 'user_id' => $admin->id],
            ['libelle' => 'Sarclage', 'user_id' => $admin->id],
        ];

        foreach ($typesInterventions as $typeIntervention) {
            TypeIntervention::firstOrCreate(
                ['libelle' => $typeIntervention['libelle']],
                ['user_id' => $typeIntervention['user_id']]
            );
        }

        // Coordonnées de différentes régions du Togo
        $coordonnees = [
            // Région Maritime
            ['latitude' => 6.1750, 'longitude' => 1.2333], // Lomé
            ['latitude' => 6.2135, 'longitude' => 1.2437], // Environs de Lomé
            ['latitude' => 6.1987, 'longitude' => 1.3021], // Est de Lomé
            ['latitude' => 6.3329, 'longitude' => 1.1647], // Nord de Lomé

            // Région des Plateaux
            ['latitude' => 7.0114, 'longitude' => 1.1523], // Kpalimé
            ['latitude' => 7.3634, 'longitude' => 1.1901], // Atakpamé
            ['latitude' => 7.1271, 'longitude' => 1.2535], // Environs de Kpalimé
            ['latitude' => 7.5129, 'longitude' => 1.1368], // Environs d'Atakpamé

            // Région Centrale
            ['latitude' => 8.0472, 'longitude' => 1.1154], // Sokodé
            ['latitude' => 8.2333, 'longitude' => 0.7833], // Sotouboua

            // Région de la Kara
            ['latitude' => 9.5513, 'longitude' => 1.1702], // Kara
            ['latitude' => 9.7634, 'longitude' => 1.0953], // Environs de Kara

            // Région des Savanes
            ['latitude' => 10.8268, 'longitude' => 0.2064], // Dapaong
            ['latitude' => 10.9652, 'longitude' => 0.1985], // Environs de Dapaong
        ];

        // Récupérer tous les types de cultures et d'interventions
        $typesCultures = TypeCulture::all();
        $typesInterventions = TypeIntervention::all();
        $users = User::where('role_id', $roleAgriculteur->id)->get();

        // Création de parcelles avec des coordonnées au Togo
        foreach ($users as $user) {
            // Chaque utilisateur aura entre 2 et 5 parcelles
            $nombreParcelles = rand(2, 5);
            for ($i = 0; $i < $nombreParcelles; $i++) {
                // Sélectionner des coordonnées aléatoires
                $coord = $coordonnees[array_rand($coordonnees)];
                // Ajouter une petite variation pour que les parcelles ne soient pas exactement au même endroit
                $latVariation = (rand(-1000, 1000) / 10000);
                $lngVariation = (rand(-1000, 1000) / 10000);

                // Sélectionner un type de culture aléatoire
                $typeCulture = $typesCultures->random();

                // Créer la parcelle
                $parcelle = Parcelle::create([
                    'nom_parcelle' => 'Parcelle ' . chr(65 + $i) . ' de ' . $user->name,
                    'superficie' => rand(50, 500), // en m²
                    'date_plantation' => Carbon::now()->subDays(rand(30, 365)),
                    'statut' => ['En culture', 'En jachère', 'Récoltée'][rand(0, 2)],
                    'latitude' => $coord['latitude'] + $latVariation,
                    'longitude' => $coord['longitude'] + $lngVariation,
                    'type_culture_id' => $typeCulture->id,
                    'user_id' => $user->id,
                ]);

                // Créer 3 à 8 interventions pour chaque parcelle
                $nombreInterventions = rand(3, 8);
                for ($j = 0; $j < $nombreInterventions; $j++) {
                    $typeIntervention = $typesInterventions->random();
                    $dateIntervention = Carbon::now()->subDays(rand(1, 180));
                    $dateFin = (rand(0, 1) == 1) ? $dateIntervention->copy()->addDays(rand(1, 7)) : null;

                    $intervention = Intervention::create([
                        'parcelle_id' => $parcelle->id,
                        'type_intervention_id' => $typeIntervention->id,
                        'date_intervention' => $dateIntervention,
                        'date_fin' => $dateFin,
                        'description' => $this->getRandomDescription($typeIntervention->libelle),
                        'qte_produit' => (in_array($typeIntervention->libelle, ['Fertilisation', 'Traitement phytosanitaire', 'Irrigation'])) ? rand(10, 100) : null,
                        'statut_intervention' => ['Planifié', 'En cours', 'Terminé', 'Annulé'][rand(0, 3)],
                        'user_id' => $user->id,
                    ]);

                    // Ajouter des imprévus à certaines interventions (30% de chance)
                    if (rand(1, 100) <= 30) {
                        Imprevu::create([
                            'intervention_id' => $intervention->id,
                            'description' => $this->getRandomImprevu(),
                            'created_at' => $dateIntervention,
                            'updated_at' => $dateIntervention,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Get a random description for an intervention based on its type
     */
    private function getRandomDescription($typeIntervention)
    {
        $descriptions = [
            'Semis' => [
                'Semis à la volée',
                'Semis en ligne',
                'Semis direct',
                'Semis avec espacement optimal',
                'Semis manuel'
            ],
            'Plantation' => [
                'Plantation en quinconce',
                'Plantation en ligne',
                'Transplantation des jeunes plants',
                'Plantation des boutures',
                'Plantation des tubercules'
            ],
            'Désherbage' => [
                'Désherbage manuel',
                'Désherbage mécanique',
                'Désherbage chimique',
                'Désherbage sélectif',
                'Désherbage préventif'
            ],
            'Fertilisation' => [
                'Application d\'engrais organique',
                'Application d\'engrais NPK',
                'Épandage de fumier',
                'Application d\'urée',
                'Fertilisation foliaire'
            ],
            'Traitement phytosanitaire' => [
                'Traitement fongicide',
                'Traitement insecticide',
                'Traitement herbicide',
                'Traitement biologique',
                'Pulvérisation préventive'
            ],
            'Irrigation' => [
                'Irrigation par aspersion',
                'Irrigation goutte à goutte',
                'Irrigation par inondation',
                'Irrigation manuelle',
                'Irrigation localisée'
            ],
            'Récolte' => [
                'Récolte manuelle',
                'Récolte mécanique',
                'Récolte sélective',
                'Récolte totale',
                'Récolte partielle'
            ],
            'Taille' => [
                'Taille de formation',
                'Taille d\'entretien',
                'Taille de fructification',
                'Élagage',
                'Taille sanitaire'
            ],
            'Labour' => [
                'Labour profond',
                'Labour superficiel',
                'Labour à la charrue',
                'Labour manuel',
                'Labour à la houe'
            ],
            'Sarclage' => [
                'Sarclage manuel',
                'Sarclage mécanique',
                'Sarclage sélectif',
                'Binage',
                'Sarclage de finition'
            ]
        ];

        $defaultDescriptions = [
            'Intervention standard',
            'Intervention régulière',
            'Intervention planifiée',
            'Intervention périodique',
            'Intervention nécessaire'
        ];

        $typeDescriptions = $descriptions[$typeIntervention] ?? $defaultDescriptions;
        return $typeDescriptions[array_rand($typeDescriptions)];
    }

    /**
     * Get a random description for an unexpected event
     */
    private function getRandomImprevu()
    {
        $imprevus = [
            'Pluie abondante inattendue',
            'Sécheresse prolongée',
            'Attaque de parasites',
            'Maladie fongique',
            'Panne de matériel',
            'Absence de main d\'œuvre',
            'Manque d\'intrants',
            'Inondation partielle',
            'Vents violents',
            'Dégâts causés par des animaux',
            'Problème d\'irrigation',
            'Retard de livraison des intrants',
            'Températures extrêmes',
            'Conflit foncier temporaire',
            'Problème logistique'
        ];

        return $imprevus[array_rand($imprevus)];
    }
}
