<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des séances</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="dashboard-shell role-enseignant">

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">

    <div class="brand">
        <span>BTS</span>
        <span class="text-menu"> Guelmim</span>
    </div>

    <a href="/enseignant/dashboard">
        <span>🏠</span>
        <span class="text-menu">Dashboard</span>
    </a>

    <a href="{{ route('seances.index') }}" class="active">
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

{{-- Main content --}}
<div class="content" id="content">

    {{-- Topbar --}}
    <div class="topbar shadow-sm">

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-success btn-sm" onclick="toggleSidebar()">
                ☰
            </button>

            <div>
                <h5 class="mb-0 fw-bold text-main">
                    Gestion des séances
                </h5>
                <small class="text-muted">
                    Administration des séances pédagogiques
                </small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted user-name">
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

        <div class="page-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h2 class="fw-bold mb-1 text-main">
                        Gestion des séances
                    </h2>

                    <p class="text-muted mb-0">
                        Créer, modifier et supprimer les séances de formation.
                    </p>
                </div>

                <a href="{{ route('seances.create') }}" class="btn btn-success">
                    Ajouter une séance
                </a>

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
                            <th>Date</th>
                            <th>Heure début</th>
                            <th>Heure fin</th>
                            <th>Module</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($seances as $seance)
                            <tr>
                                <td>{{ $seance->id }}</td>

                                <td>{{ $seance->titre }}</td>

                                <td>{{ $seance->date }}</td>

                                <td>{{ $seance->heure_debut }}</td>

                                <td>{{ $seance->heure_fin }}</td>

                                <td>{{ $seance->module->nom ?? '' }}</td>

                                <td>
                                    <a href="{{ route('seances.edit', $seance->id) }}" class="btn btn-sm btn-warning">
                                        Modifier
                                    </a>

                                    <form action="{{ route('seances.destroy', $seance->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
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
            text: 'Cette séance sera supprimée définitivement.',
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