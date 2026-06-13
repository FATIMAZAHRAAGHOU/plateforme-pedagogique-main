<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    private function ensureCanManage(): void
    {
        if (auth()->user()->role == 'etudiant') {
            abort(403);
        }
    }

    private function ensureNoteBelongsToTeacher(Note $note): void
    {
        $user = auth()->user();

        if ($user->role == 'enseignant') {
            $enseignant = $user->enseignant;

            if (!$enseignant || $note->evaluation?->module?->enseignant_id != $enseignant->id) {
                abort(403);
            }
        }
    }

    private function ensureStudentBelongsToEvaluationGroup(int $etudiantId, int $evaluationId): void
    {
        $evaluation = Evaluation::with('module')->findOrFail($evaluationId);

        if ($evaluation->module?->groupe_id) {
            $belongsToGroup = Etudiant::where('id', $etudiantId)
                ->where('groupe_id', $evaluation->module->groupe_id)
                ->exists();

            if (!$belongsToGroup) {
                abort(403);
            }
        }
    }

    public function index()
    {
        $user = auth()->user();
        $notes = Note::with('etudiant', 'evaluation.module')->latest();

        if ($user->role == 'etudiant') {
            $etudiant = $user->etudiant;

            if ($etudiant) {
                $notes->where('etudiant_id', $etudiant->id);
            } else {
                $notes->whereRaw('1 = 0');
            }
        }

        if ($user->role == 'enseignant') {
            $enseignant = $user->enseignant;

            if ($enseignant) {
                $notes->whereHas('evaluation.module', function ($query) use ($enseignant) {
                    $query->where('enseignant_id', $enseignant->id);
                });
            } else {
                $notes->whereRaw('1 = 0');
            }
        }

        $notes = $notes->get();

        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        $this->ensureCanManage();

        $evaluations = Evaluation::with('module');
        $etudiants = Etudiant::query();

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant) {
                abort(403);
            }

            $evaluations->whereHas('module', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            });

            $etudiants->whereHas('groupe.modules', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            });
        }

        $evaluations = $evaluations->get();
        $etudiants = $etudiants->get();

        return view('notes.create', compact('etudiants', 'evaluations'));
    }

    public function store(Request $request)
    {
        $this->ensureCanManage();

        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'evaluation_id' => 'required|exists:evaluations,id',
            'note' => 'required|numeric|min:0|max:20',
            'appreciation' => 'nullable|string',
        ]);

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant || !Evaluation::where('id', $request->evaluation_id)->whereHas('module', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })->exists()) {
                abort(403);
            }
        }

        $this->ensureStudentBelongsToEvaluationGroup($request->etudiant_id, $request->evaluation_id);

        Note::create($request->all());

        return redirect()->route('notes.index')
                         ->with('success', 'Note ajoutée avec succès.');
    }

    public function edit(Note $note)
    {
        $this->ensureCanManage();
        $note->load('evaluation.module');
        $this->ensureNoteBelongsToTeacher($note);

        $evaluations = Evaluation::with('module');
        $etudiants = Etudiant::query();

        if (auth()->user()->role == 'enseignant') {
            $evaluations->whereHas('module', function ($query) {
                $query->where('enseignant_id', auth()->user()->enseignant->id);
            });

            $etudiants->whereHas('groupe.modules', function ($query) {
                $query->where('enseignant_id', auth()->user()->enseignant->id);
            });
        }

        $evaluations = $evaluations->get();
        $etudiants = $etudiants->get();

        return view('notes.edit', compact('note', 'etudiants', 'evaluations'));
    }

    public function update(Request $request, Note $note)
    {
        $this->ensureCanManage();
        $note->load('evaluation.module');
        $this->ensureNoteBelongsToTeacher($note);

        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'evaluation_id' => 'required|exists:evaluations,id',
            'note' => 'required|numeric|min:0|max:20',
            'appreciation' => 'nullable|string',
        ]);

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant || !Evaluation::where('id', $request->evaluation_id)->whereHas('module', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })->exists()) {
                abort(403);
            }
        }

        $this->ensureStudentBelongsToEvaluationGroup($request->etudiant_id, $request->evaluation_id);

        $note->update($request->all());

        return redirect()->route('notes.index')
                         ->with('success', 'Note modifiée avec succès.');
    }

    public function destroy(Note $note)
    {
        $this->ensureCanManage();
        $note->load('evaluation.module');
        $this->ensureNoteBelongsToTeacher($note);

        $note->delete();

        return redirect()->route('notes.index')
                         ->with('success', 'Note supprimée avec succès.');
    }
}
