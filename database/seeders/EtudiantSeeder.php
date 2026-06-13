<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etudiant;
use App\Models\Groupe;

class EtudiantSeeder extends Seeder
{
    public function run(): void
    {
        Etudiant::query()->delete();

        $groupes = Groupe::pluck('id')->toArray();

        if (empty($groupes)) {
            return;
        }

        $prenoms = ['Youssef','Hamza','Ayoub','Anas','Omar','Mehdi','Amine','Soufiane','Othmane','Yassine','Sara','Imane','Salma','Mariam','Fatima','Hajar','Khadija','Nour','Aya','Ikram'];

        $noms = ['Alami','Idrissi','Benali','Amrani','Tahiri','Lahlou','Berrada','Naciri','Chraibi','Fassi','Lahcen','Mansouri','Bouazza','Sabiri','Raji','Zerhouni','Tazi','Ouahbi','Khattabi','Alaoui'];

        for ($i = 1; $i <= 100; $i++) {
            $prenom = $prenoms[array_rand($prenoms)];
            $nom = $noms[array_rand($noms)];
            $groupe_id = $groupes[($i - 1) % count($groupes)];

            Etudiant::create([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => strtolower($prenom.'.'.$nom.$i.'@gmail.com'),
                'telephone' => '06'.str_pad($i, 8, '0', STR_PAD_LEFT),
                'matricule' => 'ETU'.str_pad($i, 3, '0', STR_PAD_LEFT),
                'date_naissance' => '2002-01-01',
                'groupe_id' => $groupe_id,
            ]);
        }
    }
}
