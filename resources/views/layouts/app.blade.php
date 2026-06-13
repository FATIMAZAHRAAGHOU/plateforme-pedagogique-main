<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plateforme BTS Guelmim</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="app-layout-body">

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm site-navbar">
    <div class="container">

        <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
            <span class="site-brand-mark">BTS</span>
            <span class="ms-2 text-white-50">Guelmim</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link active" href="/">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#objectif">Objectif</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#formations">Formations</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>

                <li class="nav-item ms-lg-3">
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-4">
                        Se connecter
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="text-white mt-5 site-footer">
    <div class="container py-4">

        <div class="row align-items-center">

            <div class="col-md-6">
                <h6 class="fw-bold mb-1">
                    Centre BTS Guelmim
                </h6>

                <p class="mb-0 text-white-50">
                    Plateforme de Gestion de Formation
                </p>
            </div>

            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <p class="mb-0 text-white-50">
                    © 2026 Tous droits réservés
                </p>
            </div>

        </div>

    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>