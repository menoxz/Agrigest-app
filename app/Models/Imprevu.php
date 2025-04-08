<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Imprevu extends Model
{
use HasFactory;

    protected $fillable = ['description', 'intervention_id', 'user_id'];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
}
