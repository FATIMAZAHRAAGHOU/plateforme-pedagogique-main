<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une présence</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>Modifier une présence</h1>
            <p>Modifier l’état de présence d’un étudiant.</p>
        </div>

        <div class="card-body p-4">

            <div class="help-box mb-4">
                Cette page permet de mettre à jour une présence déjà enregistrée.
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

            <form action="{{ route('presences.update', $presence->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Étudiant</label>
                    <select name="etudiant_id" class="form-select">
                        <option value="">-- Choisir un étudiant --</option>

                        @foreach($etudiants as $etudiant)
                            <option value="{{ $etudiant->id }}" {{ old('etudiant_id', $presence->etudiant_id) == $etudiant->id ? 'selected' : '' }}>
                                {{ $etudiant->nom }} {{ $etudiant->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Séance</label>
                    <select name="seance_id" class="form-select">
                        <option value="">-- Choisir une séance --</option>

                        @foreach($seances as $seance)
                            <option value="{{ $seance->id }}" {{ old('seance_id', $presence->seance_id) == $seance->id ? 'selected' : '' }}>
                                {{ $seance->titre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select">
                        <option value="">-- Choisir un statut --</option>
                        <option value="present" {{ old('statut', $presence->statut) == 'present' ? 'selected' : '' }}>Présent</option>
                        <option value="absent" {{ old('statut', $presence->statut) == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="retard" {{ old('statut', $presence->statut) == 'retard' ? 'selected' : '' }}>Retard</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Remarque</label>
                    <textarea name="remarque" class="form-control">{{ old('remarque', $presence->remarque) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('presences.index') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-main">Modifier</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
