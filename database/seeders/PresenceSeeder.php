<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etudiant;
use App\Models\Presence;
use App\Models\Seance;

class PresenceSeeder extends Seeder
{
    public function run(): void
    {
        Presence::query()->delete();

        $etudiants = Etudiant::pluck('id')->toArray();
        $seances = Seance::pluck('id')->toArray();
        $statuts = ['present', 'absent', 'retard'];

        if (empty($etudiants) || empty($seances)) {
            return;
        }

        for ($i = 1; $i <= 30; $i++) {
            Presence::create([
                'etudiant_id' => $etudiants[($i - 1) % count($etudiants)],
                'seance_id' => $seances[($i - 1) % count($seances)],
                'statut' => $statuts[$i % 3],
                'remarque' => $i % 3 === 0 ? 'Retard justifié' : null,
            ]);
        }
    }
}
