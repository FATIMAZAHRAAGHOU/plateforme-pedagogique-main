<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un groupe</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>Modifier un groupe</h1>
            <p>Modifier le groupe et sa filière.</p>
        </div>

        <div class="card-body p-4">

            <div class="help-box mb-4">
                Cette page permet de mettre à jour les informations d’un groupe.
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

            <form action="{{ route('groupes.update', $groupe->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nom du groupe</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $groupe->nom) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Année scolaire</label>
                    <input type="text" name="annee_scolaire" class="form-control" value="{{ old('annee_scolaire', $groupe->annee_scolaire) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Filière</label>
                    <select name="filiere_id" class="form-select">
                        <option value="">-- Choisir une filière --</option>

                        @foreach ($filieres as $filiere)
                            <option value="{{ $filiere->id }}" {{ old('filiere_id', $groupe->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                {{ $filiere->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('groupes.index') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-main">Modifier</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
