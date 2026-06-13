<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\Note;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        Note::query()->delete();

        $etudiants = Etudiant::pluck('id')->toArray();
        $evaluations = Evaluation::pluck('id')->toArray();

        if (empty($etudiants) || empty($evaluations)) {
            return;
        }

        for ($i = 1; $i <= 30; $i++) {
            $note = 10 + ($i % 10);

            Note::create([
                'etudiant_id' => $etudiants[($i - 1) % count($etudiants)],
                'evaluation_id' => $evaluations[($i - 1) % count($evaluations)],
                'note' => $note,
                'appreciation' => $note >= 15 ? 'Très bien' : 'Assez bien',
            ]);
        }
    }
}
