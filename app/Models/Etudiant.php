<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable  = [
        'user_id',
        'nom',
        'prenom',
        'email',
        'matricule',
        'telephone',
        'date_naissance',
        'groupe_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe_id');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
