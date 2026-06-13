<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une séance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="form-page-body">

<div class="container mt-5">
    <h1>Modifier une séance</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            Vérifiez les champs saisis.
        </div>
    @endif

    <form action="{{ route('seances.update', $seance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" value="{{ old('titre', $seance->titre) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', $seance->date) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Heure début</label>
            <input type="time" name="heure_debut" class="form-control" value="{{ old('heure_debut', $seance->heure_debut) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Heure fin</label>
            <input type="time" name="heure_fin" class="form-control" value="{{ old('heure_fin', $seance->heure_fin) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Module</label>
            <select name="module_id" class="form-control">
                <option value="">-- Choisir un module --</option>

                @foreach($modules as $module)
                    <option value="{{ $module->id }}" {{ old('module_id', $seance->module_id) == $module->id ? 'selected' : '' }}>
                        {{ $module->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>

        <a href="{{ route('seances.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </form>
</div>

</body>
</html>