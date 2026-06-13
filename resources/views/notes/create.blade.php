<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une note</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>Ajouter une note</h1>
            <p>Ajouter une note pour un étudiant.</p>
        </div>

        <div class="card-body p-4">

            <div class="help-box mb-4">
                Cette page permet d’ajouter une note liée à un étudiant et à une évaluation.
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

            <form action="{{ route('notes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Étudiant</label>
                    <select name="etudiant_id" class="form-select">
                        <option value="">-- Choisir un étudiant --</option>

                        @foreach($etudiants as $etudiant)
                            <option value="{{ $etudiant->id }}" {{ old('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
                                {{ $etudiant->nom }} {{ $etudiant->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Évaluation</label>
                    <select name="evaluation_id" class="form-select">
                        <option value="">-- Choisir une évaluation --</option>

                        @foreach($evaluations as $evaluation)
                            <option value="{{ $evaluation->id }}" {{ old('evaluation_id') == $evaluation->id ? 'selected' : '' }}>
                                {{ $evaluation->titre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Note</label>
                    <input type="number" step="0.01" name="note" class="form-control" value="{{ old('note') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Appréciation</label>
                    <textarea name="appreciation" class="form-control">{{ old('appreciation') }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('notes.index') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-main">Enregistrer</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
