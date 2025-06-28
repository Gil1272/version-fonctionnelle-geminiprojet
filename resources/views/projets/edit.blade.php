@extends('layout.template')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container py-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-pencil-square me-2"></i>
                            Modifier le Projet
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="editProjectForm" class="needs-validation" method="POST"
                            action="{{ route('projets.edit', $projet->id) }}" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Nom du projet -->
                            <div class="mb-3">
                                <label for="projectName" class="form-label">
                                    <i class="bi bi-briefcase me-2"></i>
                                    Nom du projet*
                                </label>
                                <input type="text" class="form-control" id="projectName" name="nom"
                                    value="{{ old('nom', $projet->nom) }}" required>
                                <div class="invalid-feedback">
                                    Veuillez saisir un nom de projet.
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="projectDescription" class="form-label">
                                    <i class="bi bi-file-text me-2"></i>
                                    Description*
                                </label>
                                <textarea class="form-control" id="projectDescription" name="description" rows="3" required>{{ old('description', $projet->description) }}</textarea>
                                <div class="invalid-feedback">
                                    Veuillez saisir une description.
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="startDate" class="form-label">
                                        <i class="bi bi-calendar-event me-2"></i>
                                        Date de début*
                                    </label>
                                    <input type="date" class="form-control" id="startDate" name="date_debut"
                                        value="{{ old('date_debut', $projet->date_debut) }}" required>
                                    <div class="invalid-feedback">
                                        Veuillez sélectionner une date de début.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="endDate" class="form-label">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        Date de fin*
                                    </label>
                                    <input type="date" class="form-control" id="endDate" name="date_fin"
                                        value="{{ old('date_fin', $projet->date_fin) }}" required>
                                    <div class="invalid-feedback">
                                        Veuillez sélectionner une date de fin.
                                    </div>
                                </div>
                            </div>

                            <!-- Type de projet -->
                            <div class="mb-3">
                                <label for="projectType" class="form-label">
                                    <i class="bi bi-tag me-2"></i>
                                    Type de projet*
                                </label>
                                <select class="form-select" id="projectType" name="type_projet" required>
                                    <option value="" disabled>Sélectionnez un type de projet</option>
                                    @foreach ([
            'web' => 'Développement Web',
            'mobile' => 'Développement Mobile',
            'desktop' => 'Application Bureau',
            'api' => 'API / Microservices',
            'maintenance' => 'Maintenance',
            'database' => 'Base de données',
            'integration' => 'Intégration de systèmes',
            'ai' => 'Intelligence Artificielle / ML',
            'consulting' => 'Consulting',
        ] as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('type_projet', $projet->type_projet) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un type de projet.
                                </div>
                            </div>

                            <!-- Statut -->
                            <div class="mb-3">
                                <label for="projectStatus" class="form-label">
                                    <i class="bi bi-flag me-2"></i>
                                    Statut*
                                </label>
                                <select class="form-select" id="projectStatus" name="statut" required>
                                    <option value="" disabled>Sélectionnez un statut</option>
                                    @foreach ([
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'completed' => 'Terminé',
            'cancelled' => 'Annulé',
        ] as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('statut', $projet->statut) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un statut.
                                </div>
                            </div>

                            <!-- Superviseur -->
                            <div class="mb-3">
                                <label for="projectSupervisor" class="form-label">
                                    <i class="bi bi-person-badge me-2"></i>
                                    Superviseur*
                                </label>
                                <select class="form-select" id="projectSupervisor" name="employe_id" required>
                                    <option value="" disabled>Sélectionnez un superviseur</option>
                                    @foreach ($employes as $employe)
                                        <option value="{{ $employe->id }}"
                                            {{ old('employe_id', $projet->employe_id) == $employe->id ? 'selected' : '' }}>
                                            {{ $employe->nom }} {{ $employe->prenom }} - {{ $employe->poste }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un superviseur.
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save me-2"></i>
                                    Enregistrer les modifications
                                </button>
                                <a href="{{ route('projets.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Retour
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validation du formulaire
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Validation des dates
        document.getElementById('endDate').addEventListener('change', function() {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(this.value);
            if (endDate < startDate) {
                this.setCustomValidity('La date de fin doit être postérieure à la date de début');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
@endsection
