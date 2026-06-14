<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des modules</title>

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

    <a href="{{ route('filieres.index') }}">
        <span>📚</span>
        <span class="text-menu">Filières</span>
    </a>

    <a href="{{ route('groupes.index') }}">
        <span>👥</span>
        <span class="text-menu">Groupes</span>
    </a>

    <a href="{{ route('modules.index') }}" class="active">
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
                    Gestion des modules
                </h5>
                <small class="text-muted">
                    Administration des modules pédagogiques
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
                        Gestion des modules
                    </h2>

                    <p class="text-muted mb-0">
                        Associer chaque module à un enseignant et à un groupe.
                    </p>
                </div>

                <a href="{{ route('modules.create') }}" class="btn btn-primary">
                    Ajouter un module
                </a>

            </div>
        </div>

        <div class="relation-help mb-4">
            <strong>Logique du lien :</strong>
            un enseignant est lié aux étudiants à travers le module et le groupe.
            Exemple :
            <strong>Prof Ahmed → Laravel → Groupe DEV101</strong>.
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-card crud-table-card">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Module</th>
                                <th>Description</th>
                                <th>Enseignant</th>
                                <th>Groupe</th>
                                <th width="220">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($modules as $module)
                                <tr>
                                    <td>{{ $module->id }}</td>

                                    <td class="fw-semibold">
                                        {{ $module->nom }}
                                    </td>

                                    <td>
                                        {{ $module->description ?? '-' }}
                                    </td>

                                    <td>
                                        @if ($module->enseignant)
                                            {{ $module->enseignant->nom }}
                                            {{ $module->enseignant->prenom }}
                                        @else
                                            <span class="text-muted">Non affecté</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($module->groupe)
                                            <span class="badge badge-groupe">
                                                {{ $module->groupe->nom }}
                                            </span>
                                        @else
                                            <span class="text-muted">Non affecté</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-sm btn-warning">
                                            Modifier
                                        </a>

                                        <form action="{{ route('modules.destroy', $module->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Aucun module trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

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
            text: 'Ce module sera supprimé définitivement.',
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