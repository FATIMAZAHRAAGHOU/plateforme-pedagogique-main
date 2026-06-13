<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EtudiantController extends Controller
{
    private function ensureAdmin(): void
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $etudiants = Etudiant::with('groupe', 'user')->latest()->get();

        return view('etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $groupes = Groupe::all();
        $users = User::where('role', 'etudiant')
            ->whereDoesntHave('etudiant')
            ->get();

        return view('etudiants.create', compact('groupes', 'users'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'etudiant'),
                Rule::unique('etudiants', 'user_id'),
            ],
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'email' => 'required|email|max:255|unique:etudiants,email',
            'matricule' => 'required|string|max:255|unique:etudiants,matricule',
            'telephone' => 'nullable|string|max:255',
            'groupe_id' => 'required|exists:groupes,id',
        ]);

        Etudiant::create($request->all());

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant ajouté avec succès.');
    }

    public function edit(Etudiant $etudiant)
    {
        $this->ensureAdmin();

        $groupes = Groupe::all();
        $users = User::where('role', 'etudiant')
            ->where(function ($query) use ($etudiant) {
                $query->whereDoesntHave('etudiant')
                    ->orWhere('id', $etudiant->user_id);
            })
            ->get();

        return view('etudiants.edit', compact('etudiant', 'groupes', 'users'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $this->ensureAdmin();

        $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'etudiant'),
                Rule::unique('etudiants', 'user_id')->ignore($etudiant->id),
            ],
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'email' => ['required', 'email', 'max:255', Rule::unique('etudiants', 'email')->ignore($etudiant->id)],
            'matricule' => ['required', 'string', 'max:255', Rule::unique('etudiants', 'matricule')->ignore($etudiant->id)],
            'telephone' => 'nullable|string|max:255',
            'groupe_id' => 'required|exists:groupes,id',
        ]);

        $etudiant->update($request->all());

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant modifié avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        $this->ensureAdmin();

        $etudiant->delete();

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}
