<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
use HasFactory;

    protected $fillable = ['date_intervention', 'description', 'qte_produit', 'date_fin', 'statut_intervention', 'parcelle_id', 'type_intervention_id'];

    public function parcelle()
    {
        return $this->belongsTo(Parcelle::class);
    }

    public function typeIntervention()
    {
        return $this->belongsTo(TypeIntervention::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
