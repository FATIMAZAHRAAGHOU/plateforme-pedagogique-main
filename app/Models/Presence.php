<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'etudiant_id',
        'seance_id',
        'statut',
        'remarque',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }
}
