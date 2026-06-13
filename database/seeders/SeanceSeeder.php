<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Seance;

class SeanceSeeder extends Seeder
{
    public function run(): void
    {
        Seance::query()->delete();

        $modules = Module::pluck('id')->toArray();

        if (empty($modules)) {
            return;
        }

        $seances = [
            ['Laravel - Introduction', '2026-06-09', '09:00', '11:00'],
            ['PHP - Variables et conditions', '2026-06-09', '11:00', '13:00'],
            ['JavaScript - Bases', '2026-06-10', '09:00', '11:00'],
            ['HTML/CSS - Structure de page', '2026-06-10', '11:00', '13:00'],
            ['Base de données - Introduction', '2026-06-11', '09:00', '11:00'],
            ['MySQL - Requêtes SQL', '2026-06-11', '11:00', '13:00'],
            ['Réseaux - Adressage IP', '2026-06-12', '09:00', '11:00'],
            ['Cybersécurité - Notions de base', '2026-06-12', '11:00', '13:00'],
            ['Développement Web - Projet', '2026-06-13', '09:00', '11:00'],
            ['Gestion de Projet - Planning', '2026-06-13', '11:00', '13:00'],
        ];

        foreach ($seances as $index => $seance) {
            Seance::create([
                'titre' => $seance[0],
                'date' => $seance[1],
                'heure_debut' => $seance[2],
                'heure_fin' => $seance[3],
                'module_id' => $modules[$index % count($modules)],
            ]);
        }
    }
}
