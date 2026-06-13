<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Presence;
use App\Models\Seance;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    private function ensureCanManage(): void
    {
        if (auth()->user()->role == 'etudiant') {
            abort(403);
        }
    }

    private function ensurePresenceBelongsToTeacher(Presence $presence): void
    {
        $user = auth()->user();

        if ($user->role == 'enseignant') {
            $enseignant = $user->enseignant;

            if (!$enseignant || $presence->seance?->module?->enseignant_id != $enseignant->id) {
                abort(403);
            }
        }
    }

    private function ensureStudentBelongsToSeanceGroup(int $etudiantId, int $seanceId): void
    {
        $seance = Seance::with('module')->findOrFail($seanceId);

        if ($seance->module?->groupe_id) {
            $belongsToGroup = Etudiant::where('id', $etudiantId)
                ->where('groupe_id', $seance->module->groupe_id)
                ->exists();

            if (!$belongsToGroup) {
                abort(403);
            }
        }
    }

    public function index()
    {
        $user = auth()->user();
        $presences = Presence::with('etudiant', 'seance.module')->latest();

        if ($user->role == 'etudiant') {
            $etudiant = $user->etudiant;

            if ($etudiant) {
                $presences->where('etudiant_id', $etudiant->id);
            } else {
                $presences->whereRaw('1 = 0');
            }
        }

        if ($user->role == 'enseignant') {
            $enseignant = $user->enseignant;

            if ($enseignant) {
                $presences->whereHas('seance.module', function ($query) use ($enseignant) {
                    $query->where('enseignant_id', $enseignant->id);
                });
            } else {
                $presences->whereRaw('1 = 0');
            }
        }

        $presences = $presences->get();

        return view('presences.index', compact('presences'));
    }

    public function create()
    {
        $this->ensureCanManage();

        $etudiants = Etudiant::query();
        $seances = Seance::with('module');

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant) {
                abort(403);
            }

            $seances->whereHas('module', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            });

            $etudiants->whereHas('groupe.modules', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            });
        }

        $seances = $seances->get();
        $etudiants = $etudiants->get();

        return view('presences.create', compact('etudiants', 'seances'));
    }

    public function store(Request $request)
    {
        $this->ensureCanManage();

        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'seance_id' => 'required|exists:seances,id',
            'statut' => 'required|in:present,absent,retard',
            'remarque' => 'nullable|string',
        ]);

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant || !Seance::where('id', $request->seance_id)->whereHas('module', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })->exists()) {
                abort(403);
            }
        }

        $this->ensureStudentBelongsToSeanceGroup($request->etudiant_id, $request->seance_id);

        Presence::create($request->all());

        return redirect()->route('presences.index')
                         ->with('success', 'Présence ajoutée avec succès.');
    }

    public function edit(Presence $presence)
    {
        $this->ensureCanManage();
        $presence->load('seance.module');
        $this->ensurePresenceBelongsToTeacher($presence);

        $etudiants = Etudiant::query();
        $seances = Seance::with('module');

        if (auth()->user()->role == 'enseignant') {
            $seances->whereHas('module', function ($query) {
                $query->where('enseignant_id', auth()->user()->enseignant->id);
            });

            $etudiants->whereHas('groupe.modules', function ($query) {
                $query->where('enseignant_id', auth()->user()->enseignant->id);
            });
        }

        $seances = $seances->get();
        $etudiants = $etudiants->get();

        return view('presences.edit', compact('presence', 'etudiants', 'seances'));
    }

    public function update(Request $request, Presence $presence)
    {
        $this->ensureCanManage();
        $presence->load('seance.module');
        $this->ensurePresenceBelongsToTeacher($presence);

        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'seance_id' => 'required|exists:seances,id',
            'statut' => 'required|in:present,absent,retard',
            'remarque' => 'nullable|string',
        ]);

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant || !Seance::where('id', $request->seance_id)->whereHas('module', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })->exists()) {
                abort(403);
            }
        }

        $this->ensureStudentBelongsToSeanceGroup($request->etudiant_id, $request->seance_id);

        $presence->update($request->all());

        return redirect()->route('presences.index')
                         ->with('success', 'Présence modifiée avec succès.');
    }

    public function destroy(Presence $presence)
    {
        $this->ensureCanManage();
        $presence->load('seance.module');
        $this->ensurePresenceBelongsToTeacher($presence);

        $presence->delete();

        return redirect()->route('presences.index')
                         ->with('success', 'Présence supprimée avec succès.');
    }
}
