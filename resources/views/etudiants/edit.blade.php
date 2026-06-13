<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un étudiant</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>Modifier un étudiant</h1>
            <p>Modifier les informations de l’étudiant.</p>
        </div>

        <div class="card-body p-4">

            <div class="help-box mb-4">
                Cette page permet de mettre à jour le profil d’un étudiant.
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

            <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Compte utilisateur</label>
                    <select name="user_id" class="form-select">
                        <option value="">-- Choisir un compte étudiant --</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $etudiant->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $etudiant->nom) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $etudiant->prenom) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $etudiant->email) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $etudiant->telephone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Matricule</label>
                    <input type="text" name="matricule" class="form-control" value="{{ old('matricule', $etudiant->matricule) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance', $etudiant->date_naissance) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Groupe</label>
                    <select name="groupe_id" class="form-select">
                        <option value="">-- Choisir un groupe --</option>

                        @foreach ($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ old('groupe_id', $etudiant->groupe_id) == $groupe->id ? 'selected' : '' }}>
                                {{ $groupe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-main">Modifier</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
