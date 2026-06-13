<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un cours</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $isAdmin = auth()->user()->role == 'admin';
    @endphp

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>Ajouter un cours</h1>
            <p>Publier une ressource pedagogique pour un module et un groupe.</p>
        </div>

        <div class="card-body p-4">

            <div class="help-box mb-4">
                Les fichiers acceptes sont PDF, DOC, DOCX, JPG, JPEG et PNG.
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    Verifiez les champs saisis.

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cours.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre" class="form-control" value="{{ old('titre') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Module</label>
                    <select name="module_id" class="form-select">
                        <option value="">-- Choisir un module --</option>

                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                {{ $module->nom }}
                            </option>
                        @endforeach
                    </select>
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

                @if($isAdmin)
                    <div class="mb-3">
                        <label class="form-label">Enseignant</label>
                        <select name="enseignant_id" class="form-select">
                            <option value="">-- Choisir un enseignant --</option>

                            @foreach ($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}" {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                    {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Fichier</label>
                    <input type="file" name="fichier" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('cours.index') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-main">Enregistrer</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
