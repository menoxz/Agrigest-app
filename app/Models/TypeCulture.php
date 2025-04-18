<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeCulture extends Model
{
use HasFactory;

    protected $table = 'type_cultures'; // Ensure the table name matches your database
    protected $fillable = ['libelle', 'user_id'];

    public function parcelles()
    {
        return $this->hasMany(Parcelle::class);
    }
    // TypeCulture.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
