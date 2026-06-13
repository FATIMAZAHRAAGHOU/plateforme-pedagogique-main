<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = [
        'nom',
        'annee_scolaire',
        'filiere_id',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere_id');
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}
