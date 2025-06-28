@extends('layout.template')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Mes projets </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Mes Projets</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Liste</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Ajout <code>projet</code></h4>
                            <a class="nav-link btn btn-success create-new-button" href="{{ route('projets.create') }}">+
                                Créer un nouveau
                                projet</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom du projet</th>
                                        <th>Description</th>
                                        <th>Date de début</th>
                                        <th>Date limite</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projets as $projet)
                                        <tr>
                                            <td>{{ $projet->nom }}</td>
                                            <td>{{ $projet->description }}</td>
                                            <td>{{ \Carbon\Carbon::parse($projet->date_debut)->format('F j, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($projet->date_fin)->format('F j, Y') }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modalProjet{{ $projet->id }}"><i
                                                        class="mdi mdi-eye"></i></button>
                                                <a href="{{ route('projets.edit', $projet->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="mdi mdi-pencil"></i></a>
                                                <form action="{{ route('projets.destroy', $projet->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="mdi mdi-delete"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @foreach ($projets as $projet)
        <div class="modal fade" id="modalProjet{{ $projet->id }}" tabindex="-1"
            aria-labelledby="modalLabel{{ $projet->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalLabel{{ $projet->id }}">
                            <i class="bi bi-briefcase-fill me-2"></i>
                            {{ $projet->nom }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2">Informations générales</h6>
                                <p><strong>Description:</strong> {{ $projet->description }}</p>
                                <p><strong>Date de début:</strong>
                                    {{ \Carbon\Carbon::parse($projet->date_debut)->format('F j, Y') }}</p>
                                <p><strong>Date limite:</strong>
                                    {{ \Carbon\Carbon::parse($projet->date_fin)->format('F j, Y') }}</p>
                                <div class="progress mt-3">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $projet->progression ?? 0 }}%;"
                                        aria-valuenow="{{ $projet->progression ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ $projet->progression ?? 0 }}%</div>
                                </div>
                            </div>

                            <!-- Équipe -->
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2">Équipe</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px; background-color: #007bff;">
                                                @if ($projet->superviseur->photo)
                                                    <img src="{{ asset('storage/' . $projet->superviseur->photo) }}"
                                                        alt="Photo de {{ $projet->superviseur->nom }}"
                                                        class="rounded-circle" style="width: 32px; height: 32px;">
                                                @else
                                                    <i class="bi bi-person-fill text-white"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <strong>{{ ($projet->superviseur?->nom ?? '') . ' ' . ($projet->superviseur?->prenom ?? '') ?? 'Non attribué' }}</strong><br>
                                                <small class="text-muted">Superviseur</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Tâches -->
                        <div class="mt-4">
                            <h6 class="border-bottom pb-2">Tâches</h6>
                            @if ($projet->taches->isEmpty())
                                <p>Aucune tâche assignée à ce projet.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Statut</th>
                                                <th>Tâche</th>
                                                <th>Assigné à</th>
                                                <th>Date limite</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projet->taches as $tache)
                                                <tr>
                                                    <td><span
                                                            class="badge {{ $tache->status == 'completed' ? 'bg-success' : ($tache->status == 'in_progress' ? 'bg-warning' : 'bg-danger') }}">
                                                            {{ $tache->status == 'completed' ? 'Terminé' : ($tache->status == 'in_progress' ? 'En cours' : 'En attente') }}
                                                        </span>
                                                    </td>

                                                    <td>{{ $tache->title }}</td>
                                                    <td>{{ ($tache->employee?->nom ?? '') . ' ' . ($tache->employee?->prenom ?? '') ?: 'Non assigné' }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($tache->date_limite)->format('F j, Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>


                        <!-- Commentaires -->
                        <div class="mt-4">
                            <h6 class="border-bottom pb-2">Commentaires</h6>

                            <!-- Liste des commentaires -->
                            @foreach ($projet->commentaires as $commentaire)
                                <div class="mb-2 p-2 border rounded">
                                    <strong>{{ $commentaire->commentable->nom ?? 'Anonyme' }}</strong>
                                    <p class="mb-1">{{ $commentaire->contenu }}</p>
                                    <small class="text-muted">{{ $commentaire->created_at->diffForHumans() }}</small>
                                </div>
                            @endforeach


                            <!-- Formulaire pour ajouter un commentaire -->
                            <form action="{{ route('commentaires.store', $projet->id) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="mb-2">
                                    <label for="contenu{{ $projet->id }}" class="form-label">Ajouter un
                                        commentaire</label>
                                    <textarea name="contenu" id="contenu{{ $projet->id }}" rows="2" class="form-control" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="mdi mdi-message-plus"></i> Publier
                                </button>
                            </form>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Fermer
                        </button>
                        <button type="button" class="btn btn-primary">
                            Marquer la fin du projet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
