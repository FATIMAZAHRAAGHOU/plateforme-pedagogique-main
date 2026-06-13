<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des présences</title>

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

    @if($isAdmin)
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
                    {{ $isStudent ? 'Mes absences' : 'Gestion des présences' }}
                </h5>
                <small class="text-muted">
                    {{ $isStudent ? 'Consultation de mes absences' : 'Suivi des présences et absences' }}
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
                        {{ $isStudent ? 'Mes absences' : 'Liste des présences' }}
                    </h2>

                    <p class="text-muted mb-0">
                        {{ $isStudent ? 'Consulter mes présences et absences.' : 'Consulter et gérer les présences des étudiants.' }}
                    </p>
                </div>

                @if(!$isStudent)
                    <a href="{{ route('presences.create') }}" class="btn btn-success">
                        Ajouter une présence
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
                            <th>Étudiant</th>
                            <th>Séance</th>
                            <th>Statut</th>
                            <th>Remarque</th>

                            @if(!$isStudent)
                                <th width="220">Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($presences as $presence)
                            <tr>
                                <td>{{ $presence->id }}</td>

                                <td>
                                    {{ $presence->etudiant->nom ?? '' }}
                                    {{ $presence->etudiant->prenom ?? '' }}
                                </td>

                                <td>{{ $presence->seance->titre ?? '' }}</td>

                                <td>
                                    @if($presence->statut == 'present')
                                        <span class="badge bg-success">Présent</span>
                                    @elseif($presence->statut == 'absent')
                                        <span class="badge bg-danger">Absent</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $presence->statut }}</span>
                                    @endif
                                </td>

                                <td>{{ $presence->remarque }}</td>

                                @if(!$isStudent)
                                    <td>
                                        <a href="{{ route('presences.edit', $presence->id) }}" class="btn btn-sm btn-warning">
                                            Modifier
                                        </a>

                                        <form action="{{ route('presences.destroy', $presence->id) }}" method="POST" class="d-inline">
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
            text: 'Cette présence sera supprimée définitivement.',
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
