@extends('layout.template')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container py-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nouveau Projet
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="createProjectForm" class="needs-validation" method="POST"
                            action="{{ route('projets.store') }}" novalidate>
                            @csrf <!-- Protection CSRF -->

                            <!-- Nom du projet -->
                            <div class="mb-3">
                                <label for="projectName" class="form-label">
                                    <i class="bi bi-briefcase me-2"></i>
                                    Nom du projet*
                                </label>
                                <input type="text" class="form-control" id="projectName" name="nom" required>
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
                                <textarea class="form-control" id="projectDescription" name="description" rows="3" required></textarea>
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
                                    <input type="date" class="form-control" id="startDate" name="date_debut" required>
                                    <div class="invalid-feedback">
                                        Veuillez sélectionner une date de début.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="endDate" class="form-label">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        Date de fin*
                                    </label>
                                    <input type="date" class="form-control" id="endDate" name="date_fin" required>
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
                                    <option value="" selected disabled>Sélectionnez un type de projet</option>
                                    <option value="web">Développement Web</option>
                                    <option value="mobile">Développement Mobile</option>
                                    <option value="desktop">Application Bureau</option>
                                    <option value="api">API / Microservices</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="database">Base de données</option>
                                    <option value="integration">Intégration de systèmes</option>
                                    <option value="ai">Intelligence Artificielle / ML</option>
                                    <option value="consulting">Consulting</option>
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
                                    <option value="" selected disabled>Sélectionnez un statut</option>
                                    <option value="pending">En attente</option>
                                    <option value="in_progress">En cours</option>
                                    <option value="completed">Terminé</option>
                                    <option value="cancelled">Annulé</option>
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
                                    <option value="" selected disabled>Sélectionnez un superviseur</option>
                                    @foreach ($employes as $employe)
                                        <option value="{{ $employe->id }}">{{ $employe->nom }} {{ $employe->prenom }} -
                                            {{ $employe->poste }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un superviseur.
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Créer le projet
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>
                                    Réinitialiser
                                </button>
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
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()

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
