<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enseignant;

class EnseignantSeeder extends Seeder
{
    public function run(): void
    {
        Enseignant::query()->delete();

        $prenoms = ['Youssef', 'Hamza', 'Ayoub', 'Anas', 'Omar', 'Mehdi', 'Amine', 'Soufiane', 'Othmane', 'Yassine'];

        $noms = ['Alami', 'Idrissi', 'Benali', 'Amrani', 'Tahiri', 'Lahlou', 'Berrada', 'Naciri', 'Chraibi', 'Fassi'];

        $specialites = [
            'Développement Web',
            'Base de données',
            'Réseaux informatiques',
            'Systèmes informatiques',
            'Cybersécurité',
            'Laravel',
            'PHP',
            'JavaScript',
            'Analyse et conception',
            'Gestion de projet'
        ];

        for ($i = 1; $i <= 20; $i++) {
            $prenom = $prenoms[array_rand($prenoms)];
            $nom = $noms[array_rand($noms)];
            $specialite = $specialites[array_rand($specialites)];

            Enseignant::create([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => strtolower($prenom . '.' . $nom . $i . '@gmail.com'),
                'telephone' => '06' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'specialite' => $specialite,
            ]);
        }
    }
}