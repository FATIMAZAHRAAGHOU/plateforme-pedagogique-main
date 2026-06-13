<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Detail du cours</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $role = auth()->user()->role;
        $isStudent = $role == 'etudiant';
    @endphp

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="form-page-body">

<div class="container">
    <div class="card page-card">

        <div class="page-header">
            <h1>{{ $cours->titre }}</h1>
            <p>Ressource pedagogique</p>
        </div>

        <div class="card-body p-4">

            <div class="mb-4">
                <h5 class="fw-bold text-main">Description</h5>
                <p class="text-muted mb-0">
                    {{ $cours->description ?? 'Aucune description.' }}
                </p>
            </div>

            <div class="table-responsive mb-4">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <th width="180">Module</th>
                            <td>{{ $cours->module->nom ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Groupe</th>
                            <td>{{ $cours->groupe->nom ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Enseignant</th>
                            <td>
                                @if($cours->enseignant)
                                    {{ $cours->enseignant->nom }} {{ $cours->enseignant->prenom }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Fichier</th>
                            <td>
                                @if($cours->fichier)
                                    <a href="{{ Storage::url($cours->fichier) }}" class="btn {{ $isStudent ? 'btn-info text-white' : 'btn-primary' }} btn-sm" target="_blank">
                                        Telecharger
                                    </a>
                                @else
                                    <span class="text-muted">Aucun fichier</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('cours.index') }}" class="btn btn-secondary">Retour</a>

                @if(!$isStudent)
                    <a href="{{ route('cours.edit', $cours->id) }}" class="btn btn-main">Modifier</a>
                @endif
            </div>

        </div>
    </div>
</div>

</body>
</html>
