<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un enseignant</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>Modifier un enseignant</h1>
            <p>Modifier les informations de l’enseignant.</p>
        </div>

        <div class="card-body p-4">

            <div class="help-box mb-4">
                Cette page permet de mettre à jour le profil d’un enseignant.
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

            <form action="{{ route('enseignants.update', $enseignant->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Compte utilisateur</label>
                    <select name="user_id" class="form-select">
                        <option value="">-- Choisir un compte enseignant --</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $enseignant->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $enseignant->nom) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $enseignant->prenom) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $enseignant->email) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $enseignant->telephone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Spécialité</label>
                    <input type="text" name="specialite" class="form-control" value="{{ old('specialite', $enseignant->specialite) }}">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-main">Modifier</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
