<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un module</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>Modifier un module</h1>
            <p>Modifier l’enseignant ou le groupe associé à ce module.</p>
        </div>

        <div class="card-body p-4">

            <div class="help-box mb-4">
                Cette page permet de modifier le lien entre le module, l’enseignant et le groupe.
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

            <form action="{{ route('modules.update', $module->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nom du module</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $module->nom) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control">{{ old('description', $module->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Enseignant</label>
                    <select name="enseignant_id" class="form-select">
                        <option value="">-- Choisir un enseignant --</option>

                        @foreach ($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}" {{ old('enseignant_id', $module->enseignant_id) == $enseignant->id ? 'selected' : '' }}>
                                {{ $enseignant->nom }} {{ $enseignant->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Groupe</label>
                    <select name="groupe_id" class="form-select">
                        <option value="">-- Non affecté --</option>

                        @foreach ($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ old('groupe_id', $module->groupe_id) == $groupe->id ? 'selected' : '' }}>
                                {{ $groupe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('modules.index') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-main">Modifier</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
