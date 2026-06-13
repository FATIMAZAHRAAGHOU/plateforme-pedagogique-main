<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Groupe;
use Illuminate\Http\Request;

class GroupeController extends Controller
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

        $groupes = Groupe::with('filiere')->latest()->get();

        return view('groupes.index', compact('groupes'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $filieres = Filiere::all();

        return view('groupes.create', compact('filieres'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'nom' => 'required|string|max:255',
            'annee_scolaire' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        Groupe::create($request->all());

        return redirect()->route('groupes.index')
            ->with('success', 'Groupe ajouté avec succès.');
    }

    public function edit(Groupe $groupe)
    {
        $this->ensureAdmin();

        $filieres = Filiere::all();

        return view('groupes.edit', compact('groupe', 'filieres'));
    }

    public function update(Request $request, Groupe $groupe)
    {
        $this->ensureAdmin();

        $request->validate([
            'nom' => 'required|string|max:255',
            'annee_scolaire' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $groupe->update($request->all());

        return redirect()->route('groupes.index')
            ->with('success', 'Groupe modifié avec succès.');
    }

    public function destroy(Groupe $groupe)
    {
        $this->ensureAdmin();

        $groupe->delete();

        return redirect()->route('groupes.index')
            ->with('success', 'Groupe supprimé avec succès.');
    }
}
