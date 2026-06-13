<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = [
        'titre',
        'date',
        'heure_debut',
        'heure_fin',
        'module_id',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}
