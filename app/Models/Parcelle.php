<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Parcelle extends Model
{
 use HasFactory;

    protected $fillable = ['nom_parcelle', 'superficie', 'date_plantation', 'statut', 'type_culture_id', 'user_id'];

    public function typeCulture()
{
    return $this->belongsTo(TypeCulture::class);
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }}
