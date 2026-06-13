<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Module;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    private function ensureCanManage(): void
    {
        if (auth()->user()->role == 'etudiant') {
            abort(403);
        }
    }

    private function ensureEvaluationBelongsToTeacher(Evaluation $evaluation): void
    {
        $user = auth()->user();

        if ($user->role == 'enseignant') {
            $enseignant = $user->enseignant;

            if (!$enseignant || $evaluation->module?->enseignant_id != $enseignant->id) {
                abort(403);
            }
        }
    }

    public function index()
    {
        $user = auth()->user();
        $evaluations = Evaluation::with('module')->latest();

        if ($user->role == 'enseignant') {
            $enseignant = $user->enseignant;

            if ($enseignant) {
                $evaluations->whereHas('module', function ($query) use ($enseignant) {
                    $query->where('enseignant_id', $enseignant->id);
                });
            } else {
                $evaluations->whereRaw('1 = 0');
            }
        }

        if ($user->role == 'etudiant') {
            $etudiant = $user->etudiant;

            if ($etudiant) {
                $evaluations->where(function ($query) use ($etudiant) {
                    $query->whereHas('module', function ($moduleQuery) use ($etudiant) {
                        $moduleQuery->where('groupe_id', $etudiant->groupe_id);
                    })->orWhereHas('notes', function ($noteQuery) use ($etudiant) {
                        $noteQuery->where('etudiant_id', $etudiant->id);
                    })->orWhereHas('module.seances.presences', function ($presenceQuery) use ($etudiant) {
                        $presenceQuery->where('etudiant_id', $etudiant->id);
                    });
                });
            } else {
                $evaluations->whereRaw('1 = 0');
            }
        }

        $evaluations = $evaluations->get();

        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $this->ensureCanManage();

        $modules = Module::query();

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant) {
                abort(403);
            }

            $modules->where('enseignant_id', $enseignant->id);
        }

        $modules = $modules->get();

        return view('evaluations.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $this->ensureCanManage();

        $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|in:controle,examen,tp,projet',
            'date' => 'required|date',
            'coefficient' => 'required|numeric|min:0',
            'module_id' => 'required|exists:modules,id',
        ]);

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant || !Module::where('id', $request->module_id)->where('enseignant_id', $enseignant->id)->exists()) {
                abort(403);
            }
        }

        Evaluation::create($request->all());

        return redirect()->route('evaluations.index')
                         ->with('success', 'Évaluation ajoutée avec succès.');
    }

    public function edit(Evaluation $evaluation)
    {
        $this->ensureCanManage();
        $evaluation->load('module');
        $this->ensureEvaluationBelongsToTeacher($evaluation);

        $modules = Module::query();

        if (auth()->user()->role == 'enseignant') {
            $modules->where('enseignant_id', auth()->user()->enseignant->id);
        }

        $modules = $modules->get();

        return view('evaluations.edit', compact('evaluation', 'modules'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $this->ensureCanManage();
        $evaluation->load('module');
        $this->ensureEvaluationBelongsToTeacher($evaluation);

        $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|in:controle,examen,tp,projet',
            'date' => 'required|date',
            'coefficient' => 'required|numeric|min:0',
            'module_id' => 'required|exists:modules,id',
        ]);

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant || !Module::where('id', $request->module_id)->where('enseignant_id', $enseignant->id)->exists()) {
                abort(403);
            }
        }

        $evaluation->update($request->all());

        return redirect()->route('evaluations.index')
                         ->with('success', 'Évaluation modifiée avec succès.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $this->ensureCanManage();
        $evaluation->load('module');
        $this->ensureEvaluationBelongsToTeacher($evaluation);

        $evaluation->delete();

        return redirect()->route('evaluations.index')
                         ->with('success', 'Évaluation supprimée avec succès.');
    }
}
