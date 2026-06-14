<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

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

        <a href="#" class="active">
            <span>🏠</span>
            <span class="text-menu">Dashboard</span>
        </a>

        <a href="{{ route('users.index') }}">
            <span>👤</span>
            <span class="text-menu">Comptes login</span>
        </a>

        <a href="{{ route('enseignants.index') }}">
            <span>👨‍🏫</span>
            <span class="text-menu">Enseignants</span>
        </a>

        <a href="{{ route('etudiants.index') }}">
            <span>🎓</span>
            <span class="text-menu">Étudiants</span>
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
                        Tableau de bord
                    </h5>
                    <small class="text-muted">
                        Gestion globale de la plateforme
                    </small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button class="btn btn-primary btn-sm">
                        Déconnexion
                    </button>
                </form>
                </form>

            </div>

        </div>

        <div class="container-fluid p-4">

            <div class="bg-white rounded-4 shadow-sm p-4 mb-4 border-start border-5 dashboard-hero">
                <h2 class="fw-bold mb-1 text-main">
                    Dashboard Admin
                </h2>

                <p class="text-muted mb-0">
                    Bienvenue {{ auth()->user()->name }} — Vous pouvez gérer les comptes, les filières, les groupes, les
                    modules, les enseignants et les étudiants.
                </p>
            </div>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Comptes login</h5>
                            <p class="text-muted">
                                Créer et gérer les comptes d'accès à la plateforme.
                            </p>
                            <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">Voir</a>
                            <a href="{{ route('users.create') }}" class="btn btn-outline-primary btn-sm">Créer
                                compte</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Filières</h5>
                            <p class="text-muted">
                                Créer et organiser les filières de formation.
                            </p>
                            <a href="{{ route('filieres.index') }}" class="btn btn-primary btn-sm">Voir</a>
                            <a href="{{ route('filieres.create') }}" class="btn btn-outline-primary btn-sm">Ajouter</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Groupes</h5>
                            <p class="text-muted">
                                Créer et gérer les groupes des étudiants.
                            </p>
                            <a href="{{ route('groupes.index') }}" class="btn btn-primary btn-sm">Voir</a>
                            <a href="{{ route('groupes.create') }}" class="btn btn-outline-primary btn-sm">Ajouter</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Modules</h5>
                            <p class="text-muted">
                                Créer et gérer les modules pédagogiques.
                            </p>
                            <a href="{{ route('modules.index') }}" class="btn btn-primary btn-sm">Voir</a>
                            <a href="{{ route('modules.create') }}" class="btn btn-outline-primary btn-sm">Ajouter</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Profils Enseignants</h5>
                            <p class="text-muted">
                                Créer les profils enseignants et les lier aux comptes.
                            </p>
                            <a href="{{ route('enseignants.index') }}" class="btn btn-primary btn-sm">Voir</a>
                            <a href="{{ route('enseignants.create') }}" class="btn btn-outline-primary btn-sm">Lier
                                compte</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Profils Étudiants</h5>
                            <p class="text-muted">
                                Créer les profils étudiants et les lier aux comptes.
                            </p>
                            <a href="{{ route('etudiants.index') }}" class="btn btn-primary btn-sm">Voir</a>
                            <a href="{{ route('etudiants.create') }}" class="btn btn-outline-primary btn-sm">Lier
                                compte</a>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">Tous les cours</h5>
                            <p class="text-muted">
                                Publier et gerer les ressources pedagogiques.
                            </p>
                            <a href="{{ route('cours.index') }}" class="btn btn-primary btn-sm">Voir</a>
                            <a href="{{ route('cours.create') }}" class="btn btn-outline-primary btn-sm">Ajouter</a>
                        </div>
                    </div>
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
