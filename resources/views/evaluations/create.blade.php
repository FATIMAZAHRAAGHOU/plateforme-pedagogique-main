<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une évaluation</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>Ajouter une évaluation</h1>
            <p>Créer une évaluation liée à un module.</p>
        </div>

        <div class="card-body p-4">

            <div class="help-box mb-4">
                Cette page permet de créer une évaluation pour un module.
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

            <form action="{{ route('evaluations.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre" class="form-control" value="{{ old('titre') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="">-- Choisir un type --</option>
                        <option value="controle" {{ old('type') == 'controle' ? 'selected' : '' }}>Contrôle</option>
                        <option value="examen" {{ old('type') == 'examen' ? 'selected' : '' }}>Examen</option>
                        <option value="tp" {{ old('type') == 'tp' ? 'selected' : '' }}>TP</option>
                        <option value="projet" {{ old('type') == 'projet' ? 'selected' : '' }}>Projet</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Coefficient</label>
                    <input type="number" step="0.01" name="coefficient" class="form-control" value="{{ old('coefficient') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Module</label>
                    <select name="module_id" class="form-select">
                        <option value="">-- Choisir un module --</option>

                        @foreach($modules as $module)
                            <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                {{ $module->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-main">Enregistrer</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
