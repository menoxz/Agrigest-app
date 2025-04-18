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
