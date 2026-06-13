<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
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

        $filieres = Filiere::latest()->get();

        return view('filieres.index', compact('filieres'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('filieres.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Filiere::create($request->all());

        return redirect()->route('filieres.index')
            ->with('success', 'Filière ajoutée avec succès.');
    }

    public function edit(Filiere $filiere)
    {
        $this->ensureAdmin();

        return view('filieres.edit', compact('filiere'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $this->ensureAdmin();

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $filiere->update($request->all());

        return redirect()->route('filieres.index')
            ->with('success', 'Filière modifiée avec succès.');
    }

    public function destroy(Filiere $filiere)
    {
        $this->ensureAdmin();

        $filiere->delete();

        return redirect()->route('filieres.index')
            ->with('success', 'Filière supprimée avec succès.');
    }
}
