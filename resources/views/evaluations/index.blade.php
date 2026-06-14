<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des évaluations</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $role = auth()->user()->role;
        $isAdmin = $role == 'admin';
        $isStudent = $role == 'etudiant';
        $dashboardLink = $isStudent ? '/etudiant/dashboard' : ($isAdmin ? '/admin/dashboard' : '/enseignant/dashboard');
        $buttonClass = $isStudent ? 'btn-info text-white' : ($isAdmin ? 'btn-primary' : 'btn-success');
        $outlineButtonClass = $isStudent ? 'btn-outline-info' : ($isAdmin ? 'btn-outline-primary' : 'btn-outline-success');
    @endphp

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="dashboard-shell role-{{ $role }} role-dynamic-index">

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">

    <div class="brand">
        <span>BTS</span>
        <span class="text-menu"> Guelmim</span>
        </div>

    <a href="{{ $dashboardLink }}">
        <span>🏠</span>
        <span class="text-menu">Dashboard</span>
    </a>

    <a href="{{ route('cours.index') }}" class="active">
        <span>📚</span>
        <span class="text-menu">
            {{ $isAdmin ? 'Tous les cours' : 'Mes cours' }}
        </span>
    </a>

    @if(!$isStudent)
        <a href="{{ route('seances.index') }}">
            <span>📅</span>
            <span class="text-menu">Séances</span>
        </a>
    @endif

    <a href="{{ route('presences.index') }}" class="active">
        <span>✓</span>
        <span class="text-menu">
            {{ $isStudent ? 'Mes absences' : 'Présences' }}
        </span>
    </a>

    <a href="{{ route('evaluations.index') }}">
        <span>📝</span>
        <span class="text-menu">
            {{ $isStudent ? 'Mes évaluations' : 'Évaluations' }}
        </span>
    </a>

    <a href="{{ route('notes.index') }}">
        <span>📊</span>
        <span class="text-menu">
            {{ $isStudent ? 'Mes notes' : 'Notes' }}
        </span>
    </a>

</div>

{{-- Main content --}}
<div class="content" id="content">

    {{-- Topbar --}}
    <div class="topbar shadow-sm">

        <div class="d-flex align-items-center gap-3">
            <button class="btn {{ $outlineButtonClass }} btn-sm" onclick="toggleSidebar()">
                ☰
            </button>

            <div>
                <h5 class="mb-0 fw-bold text-main">
                    {{ $isStudent ? 'Mes évaluations' : 'Gestion des évaluations' }}
                </h5>
                <small class="text-muted">
                    {{ $isStudent ? 'Consultation des évaluations de mon groupe' : 'Suivi des évaluations pédagogiques' }}
                </small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted user-name">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                @csrf
                <button class="btn {{ $buttonClass }} btn-sm">
                    Déconnexion
                </button>
            </form>
        </div>

    </div>

    <div class="container-fluid p-4">

        <div class="page-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h2 class="fw-bold mb-1 text-main">
                        {{ $isStudent ? 'Mes évaluations' : 'Liste des évaluations' }}
                    </h2>

                    <p class="text-muted mb-0">
                        {{ $isStudent ? 'Consulter les évaluations de mon groupe.' : 'Consulter les évaluations, leurs types, dates, coefficients et modules.' }}
                    </p>
                </div>

                @if(!$isStudent)
                    <a href="{{ route('evaluations.create') }}" class="btn btn-success">
                        Ajouter une évaluation
                    </a>
                @endif

            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-card crud-table-card">
            <div class="card-body p-0">

                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Coefficient</th>
                            <th>Module</th>

                            @if(!$isStudent)
                                <th width="220">Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($evaluations as $evaluation)
                            <tr>
                                <td>{{ $evaluation->id }}</td>

                                <td>{{ $evaluation->titre }}</td>

                                <td>{{ $evaluation->type }}</td>

                                <td>{{ $evaluation->date }}</td>

                                <td>{{ $evaluation->coefficient }}</td>

                                <td>{{ $evaluation->module->nom ?? '' }}</td>

                                @if(!$isStudent)
                                    <td>
                                        <a href="{{ route('evaluations.edit', $evaluation->id) }}" class="btn btn-sm btn-warning">
                                            Modifier
                                        </a>

                                        <form action="{{ route('evaluations.destroy', $evaluation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.getElementById('content').classList.toggle('expanded');
    }

    function confirmDelete(button) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: 'Cette évaluation sera supprimée définitivement.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
