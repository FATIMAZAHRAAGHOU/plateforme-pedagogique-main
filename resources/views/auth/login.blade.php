<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #0b1f3a, #123c69); min-height: 100vh;">

<div class="container">
    <div class="row min-vh-100 align-items-center justify-content-center">

        <div class="col-lg-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <div class="row g-0">

                    <div class="col-md-6 d-none d-md-flex text-white p-5"
                         style="background: #0b1f3a;">
                        <div class="my-auto">
                            <h2 class="fw-bold mb-4">
                                Plateforme Pédagogique
                            </h2>

                            <p class="mb-4">
                                Gestion simple et sécurisée des étudiants,
                                enseignants, modules, absences, évaluations et notes.
                            </p>

                            <ul class="list-unstyled">
                                <li class="mb-2">✔ Espace Administrateur</li>
                                <li class="mb-2">✔ Espace Enseignant</li>
                                <li class="mb-2">✔ Espace Étudiant</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6 bg-white p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold" style="color: #123c69;">
                                Connexion
                            </h3>
                            <p class="text-muted">
                                Accédez à votre espace personnel
                            </p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                Email ou mot de passe incorrect.
                            </div>
                        @endif
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Email
                                </label>
                                <input type="email"
                                       name="email"
                                       class="form-control form-control-lg"
                                       placeholder="exemple@email.com"
                                       value="{{ old('email') }}"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Mot de passe
                                </label>
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-lg"
                                       placeholder="Votre mot de passe"
                                       required>
                            </div>

                            <button type="submit"
                                    class="btn btn-lg w-100 text-white"
                                    style="background: #123c69;">
                                Se connecter
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ url('/') }}" class="text-decoration-none">
                                Retour à l’accueil
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>