<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des filières</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="dashboard-shell role-admin">

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">

    <div class="brand">
        <span>BTS</span>
        <span class="text-menu"> Guelmim</span>
    </div>

    <a href="/admin/dashboard">
        <span>🏠</span>
        <span class="text-menu">Dashboard</span>
    </a>

    <a href="{{ route('users.index') }}">
        <span>👤</span>
        <span class="text-menu">Comptes login</span>
    </a>

    <a href="{{ route('filieres.index') }}" class="active">
        <span>📚</span>
        <span class="text-menu">Filières</span>
    </a>

    <a href="{{ route('groupes.index') }}">
        <span>👥</span>
        <span class="text-menu">Groupes</span>
    </a>

    <a href="{{ route('modules.index') }}">
        <span>📘</span>
        <span class="text-menu">Modules</span>
    </a>

    <a href="{{ route('enseignants.index') }}">
        <span>👨‍🏫</span>
        <span class="text-menu">Enseignants</span>
    </a>

    <a href="{{ route('etudiants.index') }}">
        <span>🎓</span>
        <span class="text-menu">Étudiants</span>
    </a>

    <a href="{{ route('cours.index') }}">
            <span>📚</span>
            <span class="text-menu">Tous les cours</span>
    </a>


</div>

{{-- Main content --}}
<div class="content" id="content">

    {{-- Topbar --}}
    <div class="topbar shadow-sm">

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-primary btn-sm" onclick="toggleSidebar()">
                ☰
            </button>

            <div>
                <h5 class="mb-0 fw-bold text-main">
                    Gestion des filières
                </h5>
                <small class="text-muted">
                    Administration des filières de formation
                </small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted user-name">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                @csrf
                <button class="btn btn-primary btn-sm">
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
                        Gestion des filières
                    </h2>

                    <p class="text-muted mb-0">
                        Créer, modifier et supprimer les filières de formation.
                    </p>
                </div>

                <a href="{{ route('filieres.create') }}" class="btn btn-primary">
                    Ajouter une filière
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
                            <th>Nom</th>
                            <th>Description</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($filieres as $filiere)
                            <tr>
                                <td>{{ $filiere->id }}</td>

                                <td>{{ $filiere->nom }}</td>

                                <td>{{ $filiere->description }}</td>

                                <td>
                                    <a href="{{ route('filieres.edit', $filiere->id) }}" class="btn btn-sm btn-warning">
                                        Modifier
                                    </a>

                                    <form action="{{ route('filieres.destroy', $filiere->id) }}" method="POST" class="d-inline">
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
            text: 'Cette filière sera supprimée définitivement.',
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

</body>
</html>