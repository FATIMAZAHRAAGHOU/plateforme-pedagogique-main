<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des cours</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $role = auth()->user()->role;
        $isAdmin = $role == 'admin';
        $isStudent = $role == 'etudiant';

        $dashboardLink = $isStudent
            ? '/etudiant/dashboard'
            : ($isAdmin ? '/admin/dashboard' : '/enseignant/dashboard');

        $buttonClass = $isStudent
            ? 'btn-info text-white'
            : ($isAdmin ? 'btn-primary' : 'btn-success');

        $outlineButtonClass = $isStudent
            ? 'btn-outline-info'
            : ($isAdmin ? 'btn-outline-primary' : 'btn-outline-success');
    @endphp

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="dashboard-shell role-{{ $role }} role-dynamic-index">

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
        <a href="{{ route('modules.index') }}">
            <span>📘</span>
            <span class="text-menu">Modules</span>
        </a>
    @endif
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

    <a href="{{ route('presences.index') }}">
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

<div class="content" id="content">

    <div class="topbar shadow-sm">

        <div class="d-flex align-items-center gap-3">
            <button class="btn {{ $outlineButtonClass }} btn-sm" onclick="toggleSidebar()">
                ☰
            </button>

            <div>
                <h5 class="mb-0 fw-bold text-main">
                    {{ $isAdmin ? 'Tous les cours' : 'Mes cours' }}
                </h5>
                <small class="text-muted">
                    {{ $isStudent ? 'Consultation des ressources de mon groupe' : 'Gestion des ressources pédagogiques' }}
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
                        {{ $isAdmin ? 'Liste des cours' : 'Mes cours' }}
                    </h2>

                    <p class="text-muted mb-0">
                        {{ $isStudent ? 'Consulter et télécharger les supports de mon groupe.' : 'Publier, modifier et suivre les supports pédagogiques.' }}
                    </p>
                </div>

                @if(!$isStudent)
                    <a href="{{ route('cours.create') }}" class="btn {{ $buttonClass }}">
                        Ajouter un cours
                    </a>
                @endif

            </div>
        </div>

        @if(session('success'))
            <div class="alert {{ $isAdmin ? 'alert-primary' : ($isStudent ? 'alert-info' : 'alert-success') }}">
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
                                <th>Titre</th>
                                <th>Module</th>
                                <th>Groupe</th>
                                <th>Enseignant</th>
                                <th>Fichier</th>
                                <th width="{{ $isStudent ? '120' : '260' }}">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($cours as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>

                                    <td class="fw-semibold">
                                        {{ $item->titre }}
                                    </td>

                                    <td>{{ $item->module->nom ?? '-' }}</td>

                                    <td>
                                        @if($item->groupe)
                                            <span class="badge badge-groupe">
                                                {{ $item->groupe->nom }}
                                            </span>
                                        @else
                                            <span class="text-muted">Non affecté</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->enseignant)
                                            {{ $item->enseignant->nom }} {{ $item->enseignant->prenom }}
                                        @else
                                            <span class="text-muted">Non affecté</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->fichier)
                                            <a href="{{ Storage::url($item->fichier) }}"
                                               class="btn btn-sm {{ $isStudent ? 'btn-info text-white' : ($isAdmin ? 'btn-outline-primary' : 'btn-outline-success') }}"
                                               target="_blank">
                                                Télécharger
                                            </a>
                                        @else
                                            <span class="text-muted">Aucun fichier</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('cours.show', $item->id) }}" class="btn btn-sm btn-secondary">
                                            Voir
                                        </a>

                                        @if(!$isStudent)
                                            <a href="{{ route('cours.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                Modifier
                                            </a>

                                            <form action="{{ route('cours.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)">
                                                    Supprimer
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Aucun cours trouvé.
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
            text: 'Ce cours sera supprimé définitivement.',
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