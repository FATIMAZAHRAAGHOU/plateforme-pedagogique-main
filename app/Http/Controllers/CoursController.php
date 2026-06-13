<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\Groupe;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoursController extends Controller
{
    private function ensureCanManage(): void
    {
        if (auth()->user()->role == 'etudiant') {
            abort(403);
        }
    }

    private function ensureCoursVisible(Cours $cours): void
    {
        $user = auth()->user();

        if ($user->role == 'enseignant') {
            $enseignant = $user->enseignant;

            if (!$enseignant || $cours->enseignant_id != $enseignant->id) {
                abort(403);
            }
        }

        if ($user->role == 'etudiant') {
            $etudiant = $user->etudiant;

            if (!$etudiant || $cours->groupe_id != $etudiant->groupe_id) {
                abort(403);
            }
        }
    }

    private function ensureTeacherCanUseModuleAndGroup(int $moduleId, int $groupeId): void
    {
        if (auth()->user()->role != 'enseignant') {
            return;
        }

        $enseignant = auth()->user()->enseignant;

        if (!$enseignant) {
            abort(403);
        }

        $moduleIsAllowed = Module::where('id', $moduleId)
            ->where('enseignant_id', $enseignant->id)
            ->exists();

        $groupIsAllowed = Groupe::where('id', $groupeId)
            ->whereHas('modules', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })
            ->exists();

        if (!$moduleIsAllowed || !$groupIsAllowed) {
            abort(403);
        }
    }

    public function index()
    {
        $user = auth()->user();
        $cours = Cours::with(['module', 'groupe', 'enseignant'])->latest();

        if ($user->role == 'enseignant') {
            $enseignant = $user->enseignant;

            if ($enseignant) {
                $cours->where('enseignant_id', $enseignant->id);
            } else {
                $cours->whereRaw('1 = 0');
            }
        }

        if ($user->role == 'etudiant') {
            $etudiant = $user->etudiant;

            if ($etudiant) {
                $cours->where('groupe_id', $etudiant->groupe_id);
            } else {
                $cours->whereRaw('1 = 0');
            }
        }

        $cours = $cours->get();

        return view('cours.index', compact('cours'));
    }

    public function create()
    {
        $this->ensureCanManage();

        $modules = Module::query();
        $groupes = Groupe::query();
        $enseignants = Enseignant::orderBy('nom')->get();

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant) {
                abort(403);
            }

            $modules->where('enseignant_id', $enseignant->id);
            $groupes->whereHas('modules', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            });
        }

        $modules = $modules->orderBy('nom')->get();
        $groupes = $groupes->orderBy('nom')->get();

        return view('cours.create', compact('modules', 'groupes', 'enseignants'));
    }

    public function store(Request $request)
    {
        $this->ensureCanManage();

        $rules = [
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'module_id' => 'required|exists:modules,id',
            'groupe_id' => 'required|exists:groupes,id',
        ];

        if (auth()->user()->role == 'admin') {
            $rules['enseignant_id'] = 'required|exists:enseignants,id';
        }

        $validated = $request->validate($rules);
        $this->ensureTeacherCanUseModuleAndGroup($validated['module_id'], $validated['groupe_id']);

        if (auth()->user()->role == 'enseignant') {
            $validated['enseignant_id'] = auth()->user()->enseignant->id;
        }

        if ($request->hasFile('fichier')) {
            $validated['fichier'] = $request->file('fichier')->store('cours', 'public');
        }

        Cours::create($validated);

        return redirect()->route('cours.index')
            ->with('success', 'Cours ajoute avec succes.');
    }

    public function show(Cours $cour)
    {
        $cour->load(['module', 'groupe', 'enseignant']);
        $this->ensureCoursVisible($cour);

        return view('cours.show', ['cours' => $cour]);
    }

    public function edit(Cours $cour)
    {
        $this->ensureCanManage();
        $this->ensureCoursVisible($cour);

        $modules = Module::query();
        $groupes = Groupe::query();
        $enseignants = Enseignant::orderBy('nom')->get();

        if (auth()->user()->role == 'enseignant') {
            $enseignant = auth()->user()->enseignant;

            if (!$enseignant) {
                abort(403);
            }

            $modules->where('enseignant_id', $enseignant->id);
            $groupes->whereHas('modules', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            });
        }

        $modules = $modules->orderBy('nom')->get();
        $groupes = $groupes->orderBy('nom')->get();

        return view('cours.edit', compact('cour', 'modules', 'groupes', 'enseignants'));
    }

    public function update(Request $request, Cours $cour)
    {
        $this->ensureCanManage();
        $this->ensureCoursVisible($cour);

        $rules = [
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'module_id' => 'required|exists:modules,id',
            'groupe_id' => 'required|exists:groupes,id',
        ];

        if (auth()->user()->role == 'admin') {
            $rules['enseignant_id'] = 'required|exists:enseignants,id';
        }

        $validated = $request->validate($rules);
        $this->ensureTeacherCanUseModuleAndGroup($validated['module_id'], $validated['groupe_id']);

        if (auth()->user()->role == 'enseignant') {
            $validated['enseignant_id'] = auth()->user()->enseignant->id;
        }

        if ($request->hasFile('fichier')) {
            if ($cour->fichier) {
                Storage::disk('public')->delete($cour->fichier);
            }

            $validated['fichier'] = $request->file('fichier')->store('cours', 'public');
        }

        $cour->update($validated);

        return redirect()->route('cours.index')
            ->with('success', 'Cours modifie avec succes.');
    }

    public function destroy(Cours $cour)
    {
        $this->ensureCanManage();
        $this->ensureCoursVisible($cour);

        if ($cour->fichier) {
            Storage::disk('public')->delete($cour->fichier);
        }

        $cour->delete();

        return redirect()->route('cours.index')
            ->with('success', 'Cours supprime avec succes.');
    }
}
