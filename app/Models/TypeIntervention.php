<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TypeIntervention extends Model
{
use HasFactory;
    protected $table='type_interventions';
    protected $fillable = ['libelle'];

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
}
