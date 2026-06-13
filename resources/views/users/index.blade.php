<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des comptes</title>

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

    <a href="{{ route('users.index') }}" class="active">
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
                    Gestion des comptes
                </h5>
                <small class="text-muted">
                    Administration des comptes utilisateurs
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
                        Gestion des comptes
                    </h2>

                    <p class="text-muted mb-0">
                        Créer, modifier et supprimer les comptes d'accès à la plateforme.
                    </p>
                </div>

                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    Créer un compte
                </a>

            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-card crud-table-card">
            <div class="card-body p-0">

                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $user->role }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        Modifier
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Voulez-vous vraiment supprimer ce compte ?')">
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

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.getElementById('content').classList.toggle('expanded');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>