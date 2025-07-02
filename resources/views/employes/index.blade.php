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
    <style>
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            background: #2a2d3a;
        }

        .modal-header {
            background: linear-gradient(135deg, #4c63d2 0%, #5a67d8 100%);
            border: none;
            padding: 25px 30px;
            position: relative;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23pattern)"/></svg>');
            opacity: 0.5;
        }

        .modal-title {
            position: relative;
            z-index: 1;
            font-weight: 600;
            font-size: 1.4rem;
            color: white;
        }

        .btn-close-white {
            position: relative;
            z-index: 1;
        }

        .modal-body {
            padding: 35px 30px;
            background: linear-gradient(145deg, #2a2d3a 0%, #323543 100%);
        }

        .info-section {
            background: #353849;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(76, 99, 210, 0.2);
        }

        .info-section h6 {
            color: #7c8db5;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4c63d2;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4c63d2 0%, #5a67d8 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .info-icon i {
            color: white;
            font-size: 16px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-weight: 600;
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .info-value {
            color: #e2e8f0;
            font-size: 1rem;
            font-weight: 500;
        }

        .employee-photo {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            border: 6px solid #353849;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .employee-photo:hover {
            transform: scale(1.05);
        }

        .photo-container {
            text-align: center;
            padding: 20px;
            background: #353849;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .photo-container h5 {
            color: #e2e8f0;
        }

        .photo-container .text-muted {
            color: #9ca3af !important;
        }

        .modal-footer {
            background: #2a2d3a;
            border: none;
            padding: 20px 30px;
        }

        .modal-footer .btn {
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal-footer .btn-secondary {
            background: #4a5568;
            border: none;
            color: white;
        }

        .modal-footer .btn-secondary:hover {
            background: #5a6478;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Modal de suppression */
        .delete-modal .modal-header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }

        .delete-modal .modal-body {
            text-align: center;
            padding: 30px;
            background: #2a2d3a;
        }

        .delete-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .delete-icon i {
            color: white;
            font-size: 24px;
        }

        .delete-text {
            font-size: 1rem;
            color: #9ca3af;
            margin-bottom: 10px;
        }

        .employee-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #e2e8f0;
            margin-bottom: 15px;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        @media (max-width: 768px) {
            .modal-dialog {
                margin: 10px;
            }

            .info-section {
                padding: 20px;
            }

            .employee-photo {
                width: 120px;
                height: 120px;
            }
        }
    </style>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Employés </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Employés</a></li>
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
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#confirmDeleteModal{{ $employe->id }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>

                                                <!-- Modal de confirmation de suppression -->
                                                <div class="modal fade delete-modal"
                                                    id="confirmDeleteModal{{ $employe->id }}" tabindex="-1"
                                                    aria-labelledby="confirmDeleteLabel{{ $employe->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="confirmDeleteLabel{{ $employe->id }}">
                                                                    <i class="mdi mdi-alert-circle me-2"></i>
                                                                    Confirmer la suppression
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="delete-icon">
                                                                    <i class="mdi mdi-account-remove"></i>
                                                                </div>
                                                                <div class="delete-text">
                                                                    Voulez-vous vraiment supprimer cet employé ?
                                                                </div>
                                                                <div class="employee-name">
                                                                    {{ $employe->nom }} {{ $employe->prenom }}
                                                                </div>
                                                                <p class="text-muted">Cette action est irréversible.</p>
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="button" class="btn btn-secondary me-3"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="mdi mdi-close me-1"></i>Annuler
                                                                </button>
                                                                <form
                                                                    action="{{ route('employes.destroy', $employe->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="mdi mdi-delete me-1"></i>Supprimer
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

                        <!-- Modals de détails des employés -->
                        @foreach ($employes as $employe)
                            <div class="modal fade" id="modalEmploye{{ $employe->id }}" tabindex="-1"
                                aria-labelledby="modalLabel{{ $employe->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $employe->id }}">
                                                <i class="mdi mdi-account-circle me-2"></i>
                                                Profil de {{ $employe->nom }} {{ $employe->prenom }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row g-4">
                                                <div class="col-md-8">
                                                    <div class="info-section">
                                                        <h6>
                                                            <i class="mdi mdi-information-outline me-2"></i>
                                                            Informations personnelles
                                                        </h6>

                                                        <div class="info-item">
                                                            <div class="info-icon">
                                                                <i class="mdi mdi-briefcase"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <div class="info-label">Poste</div>
                                                                <div class="info-value">
                                                                    {{ $postes[$employe->poste] ?? 'Non défini' }}</div>
                                                            </div>
                                                        </div>

                                                        <div class="info-item">
                                                            <div class="info-icon">
                                                                <i class="mdi mdi-phone"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <div class="info-label">Contact</div>
                                                                <div class="info-value">{{ $employe->contact }}</div>
                                                            </div>
                                                        </div>

                                                        <div class="info-item">
                                                            <div class="info-icon">
                                                                <i class="mdi mdi-email"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <div class="info-label">Email</div>
                                                                <div class="info-value">{{ $employe->email }}</div>
                                                            </div>
                                                        </div>

                                                        <div class="info-item">
                                                            <div class="info-icon">
                                                                <i class="mdi mdi-human-male-female"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <div class="info-label">Genre</div>
                                                                <div class="info-value">{{ $employe->genre }}</div>
                                                            </div>
                                                        </div>

                                                        <div class="info-item">
                                                            <div class="info-icon">
                                                                <i class="mdi mdi-map-marker"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <div class="info-label">Adresse</div>
                                                                <div class="info-value">{{ $employe->adresse }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="photo-container">
                                                        @if ($employe->photo)
                                                            <img src="{{ asset('storage/' . $employe->photo) }}"
                                                                alt="Photo de {{ $employe->nom }}"
                                                                class="employee-photo">
                                                        @else
                                                            <div
                                                                class="employee-photo d-flex align-items-center justify-content-center bg-light">
                                                                <i class="mdi mdi-account"
                                                                    style="font-size: 60px; color: #ccc;"></i>
                                                            </div>
                                                        @endif
                                                        <h5 class="mt-3 mb-0">{{ $employe->nom }} {{ $employe->prenom }}
                                                        </h5>
                                                        <p class="text-muted">
                                                            {{ $postes[$employe->poste] ?? 'Non défini' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="mdi mdi-close me-1"></i>Fermer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
