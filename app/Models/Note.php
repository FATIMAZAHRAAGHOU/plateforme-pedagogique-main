<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'etudiant_id',
        'evaluation_id',
        'note',
        'appreciation',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
