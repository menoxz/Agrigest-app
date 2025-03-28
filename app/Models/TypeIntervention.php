<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeIntervention extends Model
{
use HasFactory;

    protected $fillable = ['libelle'];

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
}
