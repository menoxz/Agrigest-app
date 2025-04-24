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
        // Création de l'utilisateur administrateur
        DB::table('users')->insert([
            'name' => 'Administrateur',
            'email' => 'admin@agrigest.com',
            'password' => Hash::make('admin123'),
            'role_id' => 2, // ID du rôle admin
            'created_at' => now(),
            'updated_at' => now(),
              ]);
        //création d'un agriculteur
        DB::table('users')->insert([
            'name' => 'Agriculteur',
            'email' => 'agriuser@agrigest.com',
            'password' => Hash::make('agriuser123'),
            'role_id' => 1, // ID du rôle agriculteur
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Appel des autres seeders
        //  $this->call([
        //     UserSeeder::class,
        //     ParcelleInterventionSeeder::class,
        // ]);
    }
}