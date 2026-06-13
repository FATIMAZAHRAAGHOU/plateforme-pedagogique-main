<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Groupe;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $modules = Module::with(['enseignant', 'groupe'])
            ->latest()
            ->get();

        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $enseignants = Enseignant::orderBy('nom')->get();
        $groupes = Groupe::orderBy('nom')->get();

        return view('modules.create', compact('enseignants', 'groupes'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'enseignant_id' => 'required|exists:enseignants,id',
            'groupe_id' => 'nullable|exists:groupes,id',
        ]);

        Module::create($validated);

        return redirect()->route('modules.index')
            ->with('success', 'Module ajouté avec succès.');
    }

    public function edit(Module $module)
    {
        $this->ensureAdmin();

        $enseignants = Enseignant::orderBy('nom')->get();
        $groupes = Groupe::orderBy('nom')->get();

        return view('modules.edit', compact('module', 'enseignants', 'groupes'));
    }

    public function update(Request $request, Module $module)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'enseignant_id' => 'required|exists:enseignants,id',
            'groupe_id' => 'nullable|exists:groupes,id',
        ]);

        $module->update($validated);

        return redirect()->route('modules.index')
            ->with('success', 'Module modifié avec succès.');
    }

    public function destroy(Module $module)
    {
        $this->ensureAdmin();

        $module->delete();

        return redirect()->route('modules.index')
            ->with('success', 'Module supprimé avec succès.');
    }
}