<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TypeIntervention extends Model
{
use HasFactory;
    protected $table='type_interventions';
    protected $fillable = ['libelle', 'user_id'];

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
    // TypeIntervention.php
public function user()
{
    return $this->belongsTo(User::class);
}

}
