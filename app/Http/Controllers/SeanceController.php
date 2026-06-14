<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Seance;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    private function ensureAdmin(): void
    {
        if (!in_array(auth()->user()->role ,['admin' , 'enseignant'])) {
            abort(403);
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $seances = Seance::with('module')->latest()->get();

        return view('seances.index', compact('seances'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $modules = Module::all();

        return view('seances.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'module_id' => 'required|exists:modules,id',
        ]);

        Seance::create($request->all());

        return redirect()->route('seances.index')
            ->with('success', 'Séance ajoutée avec succès.');
    }

    public function edit(Seance $seance)
    {
        $this->ensureAdmin();

        $modules = Module::all();

        return view('seances.edit', compact('seance', 'modules'));
    }

    public function update(Request $request, Seance $seance)
    {
        $this->ensureAdmin();

        $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'module_id' => 'required|exists:modules,id',
        ]);

        $seance->update($request->all());

        return redirect()->route('seances.index')
            ->with('success', 'Séance modifiée avec succès.');
    }

    public function destroy(Seance $seance)
    {
        $this->ensureAdmin();

        $seance->delete();

        return redirect()->route('seances.index')
            ->with('success', 'Séance supprimée avec succès.');
    }
}
