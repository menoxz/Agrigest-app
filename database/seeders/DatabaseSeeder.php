<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ajout des rôles de base (si table vide)
        if (DB::table('roles')->count() === 0) {
            DB::table('roles')->insert([
                [
                    'nom_role' => 'agriculteur',
                    'description' => 'Utilisateur agriculteur',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nom_role' => 'admin',
                    'description' => 'Administrateur du système',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }

        // Appel du seeder avec données togolaises
        $this->call([
            TogoDataSeeder::class,
        ]);
    }
}
