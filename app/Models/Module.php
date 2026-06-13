<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'enseignant_id',
        'groupe_id',
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}
