<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeCulture extends Model
{
use HasFactory;

    protected $fillable = ['libelle'];

    public function parcelles()
    {
        return $this->hasMany(Parcelle::class);
    }
}
