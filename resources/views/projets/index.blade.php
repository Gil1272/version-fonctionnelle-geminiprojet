@extends('layout.template')

@section('content')
    <div class="main-panel">
        @if (isset($success) || isset($error))
            <div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3"
                style="z-index: 1080; min-width: 300px;">
                <div class="toast align-items-center text-white border-0 shadow-lg" id="mainToast" role="alert"
                    aria-live="assertive" aria-atomic="true"
                    style="background: {{ isset($success) ? '#28a745' : '#dc3545' }}; border-radius: 12px;">
                    <div class="d-flex">
                        <div class="toast-body fw-bold" style="font-size: 1.1rem;">
                            {{ $success ?? $error }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Fermer" style="opacity: 0.9;"></button>
                    </div>
                </div>
            </div>
        @endif
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Projets </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Projets</a></li>
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
                                Créer un nouveau projet</a>
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
                                            <td>
                                                @if (Str::length($projet->description) > 80)
                                                    <span
                                                        class="short-desc">{{ Str::limit($projet->description, 20) }}</span>
                                                    <span class="full-desc d-none">{{ $projet->description }}</span>
                                                    <a href="#" class="voir-plus-link">Voir plus</a>
                                                @else
                                                    {{ $projet->description }}
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($projet->date_debut)->format('F j, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($projet->date_fin)->format('F j, Y') }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modalProjet{{ $projet->id }}">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                                <a href="{{ route('projets.edit', $projet->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <!-- Bouton qui ouvre le modal de confirmation -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#confirmDeleteModal{{ $projet->id }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
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

    <!-- Modals améliorés -->
    @foreach ($projets as $projet)
        <div class="modal fade" id="modalProjet{{ $projet->id }}" tabindex="-1"
            aria-labelledby="modalLabel{{ $projet->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Header avec statut du projet -->
                    <div class="modal-header bg-gradient-primary text-white position-relative">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="mdi mdi-folder-multiple-outline fs-3"></i>
                            </div>
                            <div>
                                <h4 class="modal-title mb-1" id="modalLabel{{ $projet->id }}">
                                    {{ $projet->nom }}
                                </h4>
                                <small class="opacity-75">
                                    Créé le {{ \Carbon\Carbon::parse($projet->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="position-absolute top-50 end-0 translate-middle-y me-5">
                            @php
                                $statusClass = 'bg-secondary';
                                $statusText = 'En cours';
                                $totalTaches = $projet->taches->count();
                                $tachesCompletes = $projet->taches->where('status', 'completed')->count();
                                $progression = $totalTaches > 0 ? round(($tachesCompletes / $totalTaches) * 100) : 0;
                                if ($progression == 100) {
                                    $statusClass = 'bg-success';
                                    $statusText = 'Terminé';
                                } elseif ($progression >= 75) {
                                    $statusClass = 'bg-info';
                                    $statusText = 'Presque fini';
                                } elseif ($progression >= 25) {
                                    $statusClass = 'bg-warning';
                                    $statusText = 'En cours';
                                } else {
                                    $statusClass = 'bg-danger';
                                    $statusText = 'Démarrage';
                                }
                            @endphp
                            <span class="badge {{ $statusClass }} px-3 py-2">
                                <i class="mdi mdi-clock-outline me-1"></i>{{ $statusText }}
                            </span>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-0">
                        <!-- Navigation tabs -->
                        <nav class="bg-light border-bottom">
                            <div class="nav nav-tabs border-0" id="nav-tab-{{ $projet->id }}" role="tablist">
                                <button class="nav-link active px-4 py-3" id="overview-tab-{{ $projet->id }}"
                                    data-bs-toggle="tab" data-bs-target="#overview-{{ $projet->id }}" type="button">
                                    <i class="mdi mdi-information-outline me-2"></i>Vue d'ensemble
                                </button>
                                <button class="nav-link px-4 py-3" id="tasks-tab-{{ $projet->id }}" data-bs-toggle="tab"
                                    data-bs-target="#tasks-{{ $projet->id }}" type="button">
                                    <i class="mdi mdi-format-list-checks me-2"></i>
                                    Tâches <span class="badge bg-primary ms-1">{{ $projet->taches->count() }}</span>
                                </button>
                                <button class="nav-link px-4 py-3" id="team-tab-{{ $projet->id }}" data-bs-toggle="tab"
                                    data-bs-target="#team-{{ $projet->id }}" type="button">
                                    <i class="mdi mdi-account-group me-2"></i>Équipe
                                </button>
                                <button class="nav-link px-4 py-3" id="comments-tab-{{ $projet->id }}"
                                    data-bs-toggle="tab" data-bs-target="#comments-{{ $projet->id }}" type="button">
                                    <i class="mdi mdi-message-text me-2"></i>
                                    Commentaires <span
                                        class="badge bg-info ms-1">{{ $projet->commentaires->count() }}</span>
                                </button>
                            </div>
                        </nav>

                        <!-- Contenu des tabs -->
                        <div class="tab-content p-4" id="nav-tabContent-{{ $projet->id }}">

                            <!-- Vue d'ensemble -->
                            <div class="tab-pane fade show active" id="overview-{{ $projet->id }}">
                                <div class="row g-4">
                                    <!-- Informations principales -->
                                    <div class="col-lg-8">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-header bg-transparent">
                                                <h5 class="card-title mb-0">
                                                    <i class="mdi mdi-file-document-outline text-primary me-2"></i>
                                                    Informations du projet
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold text-muted">Description</label>
                                                    <p class="mb-0">
                                                        {{ $projet->description ?: 'Aucune description disponible.' }}</p>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold text-muted">Date de début</label>
                                                        <div class="d-flex align-items-center">
                                                            <i class="mdi mdi-calendar-start text-success me-2"></i>
                                                            <span>{{ \Carbon\Carbon::parse($projet->date_debut)->format('d F Y') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold text-muted">Date limite</label>
                                                        <div class="d-flex align-items-center">
                                                            <i class="mdi mdi-calendar-end text-danger me-2"></i>
                                                            <span>{{ \Carbon\Carbon::parse($projet->date_fin)->format('d F Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                @php
                                                    $dateDebut = \Carbon\Carbon::parse($projet->date_debut);
                                                    $dateFin = \Carbon\Carbon::parse($projet->date_fin);
                                                    $aujourdhui = \Carbon\Carbon::now();
                                                    $dureeTotal = $dateDebut->diffInDays($dateFin);
                                                    $joursEcoules = $dateDebut->diffInDays($aujourdhui);
                                                    $joursRestants = $aujourdhui->diffInDays($dateFin);
                                                @endphp

                                                <div class="row text-center">
                                                    <div class="col-4">
                                                        <div class="bg-light rounded p-3">
                                                            <h4 class="text-primary mb-1">{{ $dureeTotal }}</h4>
                                                            <small class="text-muted">Jours total</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="bg-light rounded p-3">
                                                            <h4 class="text-warning mb-1">{{ $joursEcoules }}</h4>
                                                            <small class="text-muted">Jours écoulés</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="bg-light rounded p-3">
                                                            <h4 class="text-success mb-1">{{ $joursRestants }}</h4>
                                                            <small class="text-muted">Jours restants</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Progression et stats -->
                                    <div class="col-lg-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-header bg-transparent">
                                                <h5 class="card-title mb-0">
                                                    <i class="mdi mdi-chart-line text-success me-2"></i>
                                                    Progression
                                                </h5>
                                            </div>
                                            <div class="card-body text-center">
                                                <!-- Cercle de progression -->
                                                <div class="position-relative d-inline-block mb-3">
                                                    <svg width="120" height="120" viewBox="0 0 120 120">
                                                        <circle cx="60" cy="60" r="54" fill="none"
                                                            stroke="#e9ecef" stroke-width="12" />
                                                        <circle cx="60" cy="60" r="54" fill="none"
                                                            stroke="#28a745" stroke-width="12"
                                                            stroke-dasharray="{{ 2 * pi() * 54 }}"
                                                            stroke-dashoffset="{{ 2 * pi() * 54 * (1 - $progression / 100) }}"
                                                            stroke-linecap="round" transform="rotate(-90 60 60)" />
                                                    </svg>
                                                    <div class="position-absolute top-50 start-50 translate-middle">
                                                        <h3 class="mb-0 text-success">{{ $progression }}%</h3>
                                                    </div>
                                                </div>

                                                <!-- Statistiques des tâches -->
                                                @php
                                                    $tachesCompletes = $projet->taches
                                                        ->where('status', 'completed')
                                                        ->count();
                                                    $tachesEnCours = $projet->taches
                                                        ->where('status', 'in_progress')
                                                        ->count();
                                                    $tachesEnAttente = $projet->taches
                                                        ->where('status', 'pending')
                                                        ->count();
                                                    $totalTaches = $projet->taches->count();
                                                @endphp

                                                <div class="row text-center">
                                                    <div class="col-12 mb-2">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center bg-light rounded p-2">
                                                            <span class="text-success">
                                                                <i class="mdi mdi-check-circle"></i> Terminées
                                                            </span>
                                                            <strong class="text-success">{{ $tachesCompletes }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center bg-light rounded p-2">
                                                            <span class="text-warning">
                                                                <i class="mdi mdi-clock-outline"></i> En cours
                                                            </span>
                                                            <strong class="text-warning">{{ $tachesEnCours }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center bg-light rounded p-2">
                                                            <span class="text-danger">
                                                                <i class="mdi mdi-pause-circle"></i> En attente
                                                            </span>
                                                            <strong class="text-danger">{{ $tachesEnAttente }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tâches -->
                            <div class="tab-pane fade" id="tasks-{{ $projet->id }}">
                                @if ($projet->taches->isEmpty())
                                    <div class="text-center py-5">
                                        <i class="mdi mdi-clipboard-list-outline display-1 text-muted"></i>
                                        <h5 class="text-muted mt-3">Aucune tâche assignée</h5>
                                        <p class="text-muted">Ce projet n'a pas encore de tâches définies.</p>
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($projet->taches as $tache)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div
                                                    class="card h-100 shadow-sm border-start border-4
                                                    {{ $tache->status == 'completed' ? 'border-success' : ($tache->status == 'in_progress' ? 'border-warning' : 'border-danger') }}">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <h6 class="card-title mb-0">{{ $tache->title }}</h6>
                                                            <span
                                                                class="badge
                                                                {{ $tache->status == 'completed' ? 'bg-success' : ($tache->status == 'in_progress' ? 'bg-warning' : 'bg-danger') }}">
                                                                {{ $tache->status == 'completed' ? 'Terminé' : ($tache->status == 'in_progress' ? 'En cours' : 'En attente') }}
                                                            </span>
                                                        </div>

                                                        @if ($tache->description)
                                                            <p class="card-text text-muted small mb-2">
                                                                {{ Str::limit($tache->description, 80) }}</p>
                                                        @endif

                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="mdi mdi-account-circle text-muted me-2"></i>
                                                            <small class="text-muted">
                                                                {{ ($tache->employee?->nom ?? '') . ' ' . ($tache->employee?->prenom ?? '') ?: 'Non assigné' }}
                                                            </small>
                                                        </div>

                                                        <div class="d-flex align-items-center">
                                                            <i class="mdi mdi-calendar-clock text-muted me-2"></i>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($tache->date_limite)->format('d/m/Y') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Équipe -->
                            <div class="tab-pane fade" id="team-{{ $projet->id }}">
                                <div class="row">
                                    <!-- Superviseur -->
                                    <div class="col-lg-6 mb-4">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0">
                                                    <i class="mdi mdi-account-star me-2"></i>Superviseur
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        @if ($projet->superviseur->photo)
                                                            <img src="{{ asset('storage/' . $projet->superviseur->photo) }}"
                                                                alt="Photo de {{ $projet->superviseur->nom }}"
                                                                class="rounded-circle"
                                                                style="width: 64px; height: 64px; object-fit: cover;">
                                                        @else
                                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                                                style="width: 64px; height: 64px;">
                                                                <i class="mdi mdi-account text-white fs-3"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-1">
                                                            {{ ($projet->superviseur?->nom ?? '') . ' ' . ($projet->superviseur?->prenom ?? '') ?? 'Non attribué' }}
                                                        </h5>
                                                        <p class="text-muted mb-1">
                                                            {{ $projet->superviseur?->poste ?? 'Superviseur' }}</p>
                                                        @if ($projet->superviseur?->email)
                                                            <small class="text-muted">
                                                                <i
                                                                    class="mdi mdi-email me-1"></i>{{ $projet->superviseur->email }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Membres de l'équipe -->
                                    <div class="col-lg-6 mb-4">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-info text-white">
                                                <h5 class="mb-0">
                                                    <i class="mdi mdi-account-group me-2"></i>Membres de l'équipe
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                @php
                                                    $membres = $projet->taches
                                                        ->pluck('employee')
                                                        ->filter()
                                                        ->unique('id');
                                                @endphp

                                                @if ($membres->count() > 0)
                                                    @foreach ($membres as $membre)
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="me-3">
                                                                @if ($membre->photo)
                                                                    <img src="{{ asset('storage/' . $membre->photo) }}"
                                                                        alt="Photo de {{ $membre->nom }}"
                                                                        class="rounded-circle"
                                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                                @else
                                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                                        style="width: 40px; height: 40px;">
                                                                        <i class="mdi mdi-account text-white"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1">
                                                                    {{ $membre->nom . ' ' . $membre->prenom }}</h6>
                                                                <small
                                                                    class="text-muted">{{ $membre->poste ?? 'Développeur' }}</small>
                                                            </div>
                                                            <div class="text-end">
                                                                @php
                                                                    $tachesMembre = $projet->taches->where(
                                                                        'employee_id',
                                                                        $membre->id,
                                                                    );
                                                                    $tachesTerminees = $tachesMembre
                                                                        ->where('status', 'completed')
                                                                        ->count();
                                                                @endphp
                                                                <small class="text-muted">
                                                                    {{ $tachesTerminees }}/{{ $tachesMembre->count() }}
                                                                    tâches
                                                                </small>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="text-center py-3">
                                                        <i class="mdi mdi-account-plus display-4 text-muted"></i>
                                                        <p class="text-muted mt-2">Aucun membre assigné</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Commentaires -->
                            <div class="tab-pane fade" id="comments-{{ $projet->id }}">
                                <!-- Liste des commentaires -->
                                <div class="mb-4" style="max-height: 400px; overflow-y: auto;">
                                    <div id="comments-list-{{ $projet->id }}">
                                        @forelse ($projet->commentaires as $commentaire)
                                            <div class="card mb-3 shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-start">
                                                        <div class="me-3">
                                                            @if ($commentaire->commentable->photo ?? false)
                                                                <img src="{{ asset('storage/' . $commentaire->commentable->photo) }}"
                                                                    alt="Photo" class="rounded-circle"
                                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                            @else
                                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;">
                                                                    <i class="mdi mdi-account text-white"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <h6 class="mb-0">
                                                                    {{ $commentaire->commentable->nom ?? 'Anonyme' }}</h6>
                                                                <small
                                                                    class="text-muted">{{ $commentaire->created_at->diffForHumans() }}</small>
                                                            </div>
                                                            <p class="mb-0">{{ $commentaire->contenu }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-5">
                                                <i class="mdi mdi-message-outline display-1 text-muted"></i>
                                                <h5 class="text-muted mt-3">Aucun commentaire</h5>
                                                <p class="text-muted">Soyez le premier à commenter ce projet.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Formulaire d'ajout de commentaire -->
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="mdi mdi-message-plus me-2"></i>Ajouter un commentaire
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <form id="comment-form-{{ $projet->id }}"
                                            action="{{ route('commentaires.store', $projet->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <textarea name="contenu" rows="3" class="form-control" placeholder="Écrivez votre commentaire..." required></textarea>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="mdi mdi-send me-2"></i>Publier
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer avec actions -->
                    <div class="modal-footer bg-light">
                        <div class="d-flex justify-content-between w-100">
                            <div>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="mdi mdi-close me-2"></i>Fermer
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('projets.edit', $projet->id) }}" class="btn btn-warning me-2">
                                    <i class="mdi mdi-pencil me-2"></i>Modifier
                                </a>
                                @if ($progression < 100)
                                    <button type="button" class="btn btn-success">
                                        <i class="mdi mdi-check-circle me-2"></i>Marquer comme terminé
                                    </button>
                                @else
                                    <button type="button" class="btn btn-info">
                                        <i class="mdi mdi-file-download me-2"></i>Exporter rapport
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($projets as $projet)
        <div class="modal fade" id="confirmDeleteModal{{ $projet->id }}" tabindex="-1"
            aria-labelledby="confirmDeleteLabel{{ $projet->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-danger text-white rounded-top-4">
                        <h5 class="modal-title fw-bold" id="confirmDeleteLabel{{ $projet->id }}">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Suppression du projet
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body fs-5 text-muted">
                        Êtes-vous sûr de vouloir supprimer le projet
                        <strong class="text-white">{{ $projet->nom }}</strong> ?
                        <br>
                        <small class="text-danger fst-italic">Cette action est irréversible.</small>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">Annuler</button>
                        <form action="{{ route('projets.destroy', $projet->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold shadow-sm">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <style>
        .btn-outline-secondary {
            border: 1.5px solid #e2e6ea;
            color: #495057;
            background: #fff;
        }


        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .modal-xl {
            max-width: 1200px;
        }

        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
        }

        .nav-tabs .nav-link.active {
            border-bottom-color: #007bff;
            color: #007bff;
            background: transparent;
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .progress-circle {
            transform: rotate(-90deg);
        }

        .avatar,
        .rounded-circle {
            box-shadow: 0 2px 8px rgba(80, 112, 184, 0.10);
            border: 2.5px solid #fff;
            transition: transform 0.2s;
        }

        .avatar:hover,
        .rounded-circle:hover {
            transform: scale(1.07);
        }

        td .full-desc,
        td .short-desc {
            white-space: pre-line;
            word-break: break-word;
            /* Permet le retour à la ligne même sur les mots longs */
        }

        td {
            max-width: 350px;
            /* Ajuste la largeur max selon ton design */
            white-space: normal !important;
            /* Permet le retour à la ligne dans toutes les cellules */
        }

        .modal-content {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .modal.fade .modal-dialog {
            transform: translateY(-50px);
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            @foreach ($projets as $projet)
                $('#comment-form-{{ $projet->id }}').on('submit', function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var url = form.attr('action');
                    var data = form.serialize();
                    $.post(url, data)
                        .done(function(response) {
                            // Recharge la liste des commentaires via AJAX
                            $('#comments-list-{{ $projet->id }}').load(location.href +
                                ' #comments-list-{{ $projet->id }} > *');
                            form[0].reset();
                        })
                        .fail(function(xhr) {
                            alert('Erreur lors de l\'ajout du commentaire');
                        });
                });
            @endforeach
        });

        $(document).on('click', '.voir-plus-link', function(e) {
            e.preventDefault();
            var $td = $(this).closest('td');
            $td.find('.short-desc').addClass('d-none');
            $td.find('.full-desc').removeClass('d-none');
            $(this).remove();
        });

        $(function() {
            var toastEl = document.getElementById('mainToast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });
                toast.show();
            }
        });
    </script>
@endsection
