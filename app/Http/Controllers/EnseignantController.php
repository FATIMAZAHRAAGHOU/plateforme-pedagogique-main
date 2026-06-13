<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnseignantController extends Controller
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

        $enseignants = Enseignant::with('user')->latest()->get();

        return view('enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $users = User::where('role', 'enseignant')
            ->whereDoesntHave('enseignant')
            ->get();

        return view('enseignants.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'enseignant'),
                Rule::unique('enseignants', 'user_id'),
            ],
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:enseignants,email',
            'telephone' => 'nullable',
            'specialite' => 'required',
        ]);

        Enseignant::create($request->all());

        return redirect()->route('enseignants.index')
                         ->with('success', 'Enseignant ajouté avec succès.');
    }

    public function edit(Enseignant $enseignant)
    {
        $this->ensureAdmin();

        $users = User::where('role', 'enseignant')
            ->where(function ($query) use ($enseignant) {
                $query->whereDoesntHave('enseignant')
                    ->orWhere('id', $enseignant->user_id);
            })
            ->get();

        return view('enseignants.edit', compact('enseignant', 'users'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $this->ensureAdmin();

        $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'enseignant'),
                Rule::unique('enseignants', 'user_id')->ignore($enseignant->id),
            ],
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:enseignants,email,' . $enseignant->id,
            'telephone' => 'nullable',
            'specialite' => 'required',
        ]);

        $enseignant->update($request->all());

        return redirect()->route('enseignants.index')
                         ->with('success', 'Enseignant modifié avec succès.');
    }

    public function destroy(Enseignant $enseignant)
    {
        $this->ensureAdmin();

        $enseignant->delete();

        return redirect()->route('enseignants.index')
                         ->with('success', 'Enseignant supprimé avec succès.');
    }
}
