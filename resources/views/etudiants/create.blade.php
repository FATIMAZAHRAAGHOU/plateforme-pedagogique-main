<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un étudiant</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>Ajouter un étudiant</h1>
            <p>Créer un profil étudiant.</p>
        </div>

        <div class="card-body p-4">

            <div class="help-box mb-4">
                Cette page permet d’ajouter un étudiant et de l’associer à un groupe.
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    Vérifiez les champs saisis.

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('etudiants.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Compte utilisateur</label>
                    <select name="user_id" class="form-select">
                        <option value="">-- Choisir un compte étudiant --</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Matricule</label>
                    <input type="text" name="matricule" class="form-control" value="{{ old('matricule') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Groupe</label>
                    <select name="groupe_id" class="form-select">
                        <option value="">-- Choisir un groupe --</option>

                        @foreach ($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ old('groupe_id') == $groupe->id ? 'selected' : '' }}>
                                {{ $groupe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-main">Enregistrer</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
