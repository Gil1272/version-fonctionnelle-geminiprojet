@php
    $postes = [
        'dev_junior' => 'Développeur Junior',
        'dev_senior' => 'Développeur Senior',
        'lead_dev' => 'Lead Développeur',
        'frontend_dev' => 'Développeur Frontend',
        'backend_dev' => 'Développeur Backend',
        'fullstack_dev' => 'Développeur Fullstack',
        'mobile_dev' => 'Développeur Mobile',
        'devops' => 'DevOps Engineer',
    ];
@endphp

@extends('layout.template')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Employés </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Mes Employés</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Liste</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Ajout <code>employé</code></h4>
                            <a class="nav-link btn btn-success create-new-button" href="{{ route('employes.create') }}">+
                                Créer un nouvel employé</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Poste</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employes as $employe)
                                        <tr>
                                            <td>{{ $employe->nom }} {{ $employe->prenom }}</td>
                                            <td>{{ $postes[$employe->poste] ?? 'Non défini' }}</td>
                                            <td>{{ $employe->email }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modalEmploye{{ $employe->id }}">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                                <a href="{{ route('employes.edit', $employe->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <!-- Bouton pour ouvrir le modal de confirmation -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#confirmDeleteModal{{ $employe->id }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                                <!-- Modal de confirmation -->
                                                <div class="modal fade" id="confirmDeleteModal{{ $employe->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="confirmDeleteLabel{{ $employe->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title"
                                                                    id="confirmDeleteLabel{{ $employe->id }}">
                                                                    Confirmer la suppression
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Voulez-vous vraiment supprimer cet employé&nbsp;:
                                                                <strong>{{ $employe->nom }} {{ $employe->prenom }}</strong>
                                                                &nbsp;?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <form action="{{ route('employes.destroy', $employe->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">
                                                                        Supprimer
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Modals -->
                        @foreach ($employes as $employe)
                            <div class="modal fade" id="modalEmploye{{ $employe->id }}" tabindex="-1"
                                aria-labelledby="modalLabel{{ $employe->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="modalLabel{{ $employe->id }}">
                                                <i class="bi bi-person-badge-fill me-2"></i>
                                                {{ $employe->nom }} {{ $employe->prenom }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="border-bottom pb-2">
                                                        <i class="bi bi-info-circle-fill me-2"></i>
                                                        Informations générales
                                                    </h6>
                                                    <p><strong>Poste:</strong>
                                                        {{ $postes[$employe->poste] ?? 'Non défini' }}</p>
                                                    <p><strong>Contact:</strong> {{ $employe->contact }}</p>
                                                    <p><strong>Email:</strong> {{ $employe->email }}</p>
                                                    <p><strong>Genre:</strong> {{ $employe->genre }}</p>
                                                    <p><strong>Adresse:</strong> {{ $employe->adresse }}</p>
                                                </div>

                                                <div class="col-md-6">
                                                    @if ($employe->photo)
                                                        <div class="text-center">
                                                            <img src="{{ asset('storage/' . $employe->photo) }}"
                                                                alt="Photo de {{ $employe->nom }}"
                                                                class="img-fluid rounded-circle mb-3"
                                                                style="max-width: 150px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- End of Modals -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
