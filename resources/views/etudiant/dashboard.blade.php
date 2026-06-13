<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Étudiant</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="dashboard-shell role-etudiant">

@php
    $etudiant = \App\Models\Etudiant::with('groupe.modules.enseignant')
        ->where('user_id', auth()->id())
        ->first();

    $groupe = $etudiant ? $etudiant->groupe : null;

    $modules = $groupe ? $groupe->modules : collect();
@endphp

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">

    <div class="brand">
        <span>BTS</span>
        <span class="text-menu"> Guelmim</span>
    </div>

    <a href="#" class="active">
        <span>🏠</span>
        <span class="text-menu">Dashboard</span>
    </a>

    <a href="{{ route('cours.index') }}">
        <span>📚</span>
        <span class="text-menu">Mes cours</span>
    </a>


    <a href="{{ route('notes.index') }}">
        <span>📊</span>
        <span class="text-menu">Mes notes</span>
    </a>

    <a href="{{ route('presences.index') }}">
        <span>📌</span>
        <span class="text-menu">Mes absences</span>
    </a>

    <a href="{{ route('evaluations.index') }}">
        <span>📝</span>
        <span class="text-menu">Mes évaluations</span>
    </a>

</div>

{{-- Main content --}}
<div class="content" id="content">

    {{-- Topbar --}}
    <div class="topbar shadow-sm">

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-info btn-sm" onclick="toggleSidebar()">
                ☰
            </button>

            <div>
                <h5 class="mb-0 fw-bold text-main">
                    Tableau de bord
                </h5>
                <small class="text-muted">
                    Espace étudiant
                </small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                @csrf
                <button class="btn btn-info btn-sm text-white">
                    Déconnexion
                </button>
            </form>
        </div>

    </div>

    <div class="container-fluid p-4">

        <div class="bg-white rounded-4 shadow-sm p-4 mb-4 border-start border-5 dashboard-hero">
            <h2 class="fw-bold mb-1 text-main">
                Dashboard Étudiant
            </h2>

            <p class="text-muted mb-0">
                Bienvenue {{ auth()->user()->name }} — Vous pouvez consulter vos notes, vos absences et les évaluations de votre groupe.
            </p>
        </div>

        @if (!$etudiant)
            <div class="alert alert-warning">
                Aucun profil étudiant n’est lié à ce compte. Veuillez contacter l’administrateur.
            </div>
        @endif

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Mes notes</h5>
                        <p class="text-muted">
                            Consulter uniquement mes notes.
                        </p>

                        <a href="{{ route('notes.index') }}" class="btn btn-info btn-sm text-white">
                            Voir mes notes
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Mes absences</h5>
                        <p class="text-muted">
                            Consulter uniquement mes absences.
                        </p>

                        <a href="{{ route('presences.index') }}" class="btn btn-info btn-sm text-white">
                            Voir mes absences
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Mes évaluations</h5>
                        <p class="text-muted">
                            Consulter les évaluations de mon groupe.
                        </p>

                        <a href="{{ route('evaluations.index') }}" class="btn btn-info btn-sm text-white">
                            Voir évaluations
                        </a>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Mes cours</h5>
                        <p class="text-muted">
                            Consulter les ressources de mon groupe.
                        </p>

                        <a href="{{ route('cours.index') }}" class="btn btn-info btn-sm text-white">
                            Voir mes cours
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mon groupe, mes modules et mes enseignants --}}
        <div class="card table-card mt-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-3 text-main">
                    Mon groupe, mes modules et mes enseignants
                </h5>

                @if ($groupe)
                    <p class="text-muted">
                        Vous appartenez au groupe :
                        <strong>{{ $groupe->nom }}</strong>
                    </p>

                    @if ($modules->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Module</th>
                                        <th>Enseignant</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($modules as $module)
                                        <tr>
                                            <td class="fw-semibold">
                                                {{ $module->nom }}
                                            </td>

                                            <td>
                                                @if ($module->enseignant)
                                                    {{ $module->enseignant->nom }}
                                                    {{ $module->enseignant->prenom }}
                                                @else
                                                    <span class="text-muted">Non affecté</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            Aucun module n’est encore affecté à votre groupe.
                        </p>
                    @endif
                @else
                    <p class="text-muted mb-0">
                        Aucun groupe n’est encore lié à votre profil étudiant.
                    </p>
                @endif

            </div>
        </div>

    </div>

</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.getElementById('content').classList.toggle('expanded');
    }
</script>

</body>
</html>
