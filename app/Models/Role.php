<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  use HasFactory;

    protected $fillable = ['nom_role', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }}
