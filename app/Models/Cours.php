<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'fichier',
        'module_id',
        'groupe_id',
        'enseignant_id',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
