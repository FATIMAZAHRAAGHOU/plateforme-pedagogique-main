<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Enseignant</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $role = auth()->user()->role;
        $isStudent = $role == 'etudiant';

        $enseignant = \App\Models\Enseignant::with('modules.groupe.etudiants')
            ->where('user_id', auth()->id())
            ->first();

        $modules = $enseignant ? $enseignant->modules : collect();
    @endphp

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="dashboard-shell role-enseignant">

<div class="sidebar" id="sidebar">

    <div class="brand">
        <span>BTS</span>
        <span class="text-menu"> Guelmim</span>
    </div>

    <a href="/enseignant/dashboard" class="active">
        <span>🏠</span>
        <span class="text-menu">Dashboard</span>
    </a>

    <a href="{{ route('cours.index') }}">
        <span>📚</span>
        <span class="text-menu">Mes cours</span>
    </a>

    <a href="{{ route('seances.index') }}">
        <span>📅</span>
        <span class="text-menu">Séances</span>
    </a>

    <a href="{{ route('presences.index') }}">
        <span>✓</span>
        <span class="text-menu">Présences</span>
    </a>

    <a href="{{ route('evaluations.index') }}">
        <span>📝</span>
        <span class="text-menu">Évaluations</span>
    </a>

    <a href="{{ route('notes.index') }}">
        <span>📊</span>
        <span class="text-menu">Notes</span>
    </a>

</div>

<div class="content" id="content">

    <div class="topbar shadow-sm">

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-success btn-sm" onclick="toggleSidebar()">
                ☰
            </button>

            <div>
                <h5 class="mb-0 fw-bold text-main">
                    Tableau de bord
                </h5>
                <small class="text-muted">
                    Espace enseignant
                </small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                @csrf
                <button class="btn btn-success btn-sm">
                    Déconnexion
                </button>
            </form>
        </div>

    </div>

    <div class="container-fluid p-4">

        <div class="bg-white rounded-4 shadow-sm p-4 mb-4 border-start border-5 dashboard-hero">
            <h2 class="fw-bold mb-1 text-main">
                Dashboard Enseignant
            </h2>

            <p class="text-muted mb-0">
                Bienvenue {{ auth()->user()->name }} — Vous pouvez gérer les séances, les présences, les évaluations, les notes et vos cours.
            </p>
        </div>

        @if (!$enseignant)
            <div class="alert alert-warning">
                Aucun profil enseignant n’est lié à ce compte. Veuillez contacter l’administrateur.
            </div>
        @endif

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Séances</h5>
                        <p class="text-muted">
                            Créer et gérer les séances pédagogiques.
                        </p>
                        <a href="{{ route('seances.index') }}" class="btn btn-success btn-sm">
                            Voir
                        </a>
                        <a href="{{ route('seances.create') }}" class="btn btn-outline-success btn-sm">
                            Ajouter
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Présences</h5>
                        <p class="text-muted">
                            Gérer les présences des étudiants.
                        </p>
                        <a href="{{ route('presences.index') }}" class="btn btn-success btn-sm">
                            Voir
                        </a>
                        <a href="{{ route('presences.create') }}" class="btn btn-outline-success btn-sm">
                            Ajouter
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Évaluations</h5>
                        <p class="text-muted">
                            Créer et gérer les évaluations.
                        </p>
                        <a href="{{ route('evaluations.index') }}" class="btn btn-success btn-sm">
                            Voir
                        </a>
                        <a href="{{ route('evaluations.create') }}" class="btn btn-outline-success btn-sm">
                            Ajouter
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Notes</h5>
                        <p class="text-muted">
                            Ajouter et consulter les notes.
                        </p>
                        <a href="{{ route('notes.index') }}" class="btn btn-success btn-sm">
                            Voir
                        </a>
                        <a href="{{ route('notes.create') }}" class="btn btn-outline-success btn-sm">
                            Ajouter
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Mes cours</h5>
                        <p class="text-muted">
                            Publier et gérer mes ressources pédagogiques.
                        </p>
                        <a href="{{ route('cours.index') }}" class="btn btn-success btn-sm">
                            Voir
                        </a>
                        <a href="{{ route('cours.create') }}" class="btn btn-outline-success btn-sm">
                            Ajouter
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="card table-card mt-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-3 text-main">
                    Mes modules et groupes
                </h5>

                <p class="text-muted">
                    Ici, l’enseignant voit les modules qu’il enseigne, les groupes concernés et le nombre d’étudiants dans chaque groupe.
                </p>

                @if ($modules->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Groupe</th>
                                    <th>Nombre d’étudiants</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($modules as $module)
                                    <tr>
                                        <td class="fw-semibold">
                                            {{ $module->nom }}
                                        </td>

                                        <td>
                                            @if ($module->groupe)
                                                {{ $module->groupe->nom }}
                                            @else
                                                <span class="text-muted">Non affecté</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($module->groupe)
                                                {{ $module->groupe->etudiants->count() }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">
                        Aucun module n’est encore affecté à votre profil.
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