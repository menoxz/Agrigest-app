<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Imprevu extends Model
{
use HasFactory;

    protected $fillable = ['description'];

    public function imprevus()
    {
        return $this->hasMany(Intervention::class);
    }
}
