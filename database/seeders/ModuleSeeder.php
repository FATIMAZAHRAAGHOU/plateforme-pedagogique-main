<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enseignant;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        Module::query()->delete();

        $enseignants = Enseignant::pluck('id')->toArray();

        if (empty($enseignants)) {
            return;
        }

        $modules = [
            'Laravel',
            'PHP',
            'JavaScript',
            'HTML/CSS',
            'Base de données',
            'MySQL',
            'Réseaux Informatiques',
            'Cybersécurité',
            'Développement Web',
            'Gestion de Projet',
            'UML',
            'Programmation Orientée Objet',
            'Python',
            'Django',
            'API REST'
        ];

        foreach ($modules as $index => $nom) {
            Module::create([
                'nom' => $nom,
                'description' => 'Module de ' . $nom,
                'enseignant_id' => $enseignants[$index % count($enseignants)],
            ]);
        }
    }
}
