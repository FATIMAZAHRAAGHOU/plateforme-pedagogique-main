<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluation;
use App\Models\Module;

class EvaluationSeeder extends Seeder
{
    public function run(): void
    {
        Evaluation::query()->delete();

        $modules = Module::pluck('id')->toArray();

        if (empty($modules)) {
            return;
        }

        $evaluations = [
            ['Contrôle Laravel', 'controle', '2026-06-15', 1.00],
            ['Examen PHP', 'examen', '2026-06-16', 2.00],
            ['TP JavaScript', 'tp', '2026-06-17', 1.00],
            ['Projet HTML/CSS', 'projet', '2026-06-18', 1.50],
            ['Contrôle Base de données', 'controle', '2026-06-19', 1.00],
            ['Examen MySQL', 'examen', '2026-06-20', 2.00],
            ['TP Réseaux', 'tp', '2026-06-21', 1.00],
            ['Projet Cybersécurité', 'projet', '2026-06-22', 1.50],
        ];

        foreach ($evaluations as $index => $evaluation) {
            Evaluation::create([
                'titre' => $evaluation[0],
                'type' => $evaluation[1],
                'date' => $evaluation[2],
                'coefficient' => $evaluation[3],
                'module_id' => $modules[$index % count($modules)],
            ]);
        }
    }
}
