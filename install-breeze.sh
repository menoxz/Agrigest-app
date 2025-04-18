#!/bin/bash

# Script d'installation de Laravel Breeze et configuration de l'authentification
echo "Installation de Laravel Breeze et configuration de l'authentification..."

# Création du dossier Rules s'il n'existe pas
mkdir -p app/Rules

# Installation de Laravel Breeze
composer require laravel/breeze --dev

# Installation des fichiers de Breeze avec l'interface Blade
php artisan breeze:install blade --no-interaction

# Installation des dépendances NPM et compilation des assets
npm install
npm run build

# Création de la règle StrongPassword
cat > app/Rules/StrongPassword.php << 'EOF'
<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Vérification de la longueur minimale (8 caractères)
        if (strlen($value) < 8) {
            return false;
        }

        // Vérification qu'il y a au moins un chiffre
        if (!preg_match('/[0-9]/', $value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le mot de passe doit contenir au moins 8 caractères et au moins un chiffre.';
    }
}
EOF

# Modification des contrôleurs d'authentification pour utiliser la règle StrongPassword
echo "Configuration des contrôleurs d'authentification..."

# RegisteredUserController
sed -i "s/use Illuminate\\Validation\\Rules;/use Illuminate\\Validation\\Rules;\nuse App\\Rules\\StrongPassword;/g" app/Http/Controllers/Auth/RegisteredUserController.php
sed -i "s/'password' => \['required', 'confirmed', Rules\\Password::defaults()\],/'password' => \['required', 'confirmed', new StrongPassword\],/g" app/Http/Controllers/Auth/RegisteredUserController.php

# NewPasswordController
sed -i "s/use Illuminate\\Validation\\Rules;/use Illuminate\\Validation\\Rules;\nuse App\\Rules\\StrongPassword;/g" app/Http/Controllers/Auth/NewPasswordController.php
sed -i "s/'password' => \['required', 'confirmed', Rules\\Password::defaults()\],/'password' => \['required', 'confirmed', new StrongPassword\],/g" app/Http/Controllers/Auth/NewPasswordController.php

# PasswordController
sed -i "s/use Illuminate\\Validation\\Rules\\Password;/use Illuminate\\Validation\\Rules\\Password;\nuse App\\Rules\\StrongPassword;/g" app/Http/Controllers/Auth/PasswordController.php
sed -i "s/'password' => \['required', Password::defaults(), 'confirmed'\],/'password' => \['required', 'confirmed', new StrongPassword\],/g" app/Http/Controllers/Auth/PasswordController.php

# Création du dossier dashboard pour la vue
mkdir -p resources/views/dashboard

# Création de la vue dashboard
cat > resources/views/dashboard/index.blade.php << 'EOF'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Vous êtes connecté!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
EOF

# Exécution des migrations
php artisan migrate:fresh

# Nettoyage des caches
php artisan optimize:clear

echo "Installation terminée avec succès!"
echo "Vous pouvez maintenant accéder à l'application sur http://localhost:8000"
