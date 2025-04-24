<?php

namespace Database\Factories;

use App\Models\Parcelle;
use App\Models\TypeCulture;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParcelleFactory extends Factory
{
    protected $model = Parcelle::class;

    public function definition()
    {
        return [
            'nom_parcelle' => $this->faker->word,
            'superficie' => $this->faker->randomFloat(2, 1, 100),
            'date_plantation' => $this->faker->date(),
            'statut' => $this->faker->randomElement(['En culture', 'Récoltée', 'En jachère']),
            'type_culture_id' => TypeCulture::factory(),
            'user_id' => User::factory(),
        ];
    }
}
