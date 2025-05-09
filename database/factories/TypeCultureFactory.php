<?php

namespace Database\Factories;

use App\Models\TypeCulture;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeCultureFactory extends Factory
{
    protected $model = TypeCulture::class;

    public function definition()
    {
        return [
            'libelle' => $this->faker->unique()->word,
            'user_id' => User::factory(),
        ];
    }
}
