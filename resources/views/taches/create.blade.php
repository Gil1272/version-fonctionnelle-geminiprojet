@extends('layout.template')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container py-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-journal-plus me-2"></i>
                            Créer une nouvelle tâche
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="createTaskForm" class="needs-validation" novalidate method="POST"
                            action="{{ route('taches.store') }}">
                            @csrf <!-- Protection CSRF -->
                            <!-- Nom de la tâche -->
                            <div class="mb-3">
                                <label for="taskName" class="form-label">
                                    <i class="bi bi-tag me-2"></i>
                                    Nom de la tâche*
                                </label>
                                <input type="text" name="title" class="form-control" id="taskName"
                                    placeholder="Saisissez le nom de la tâche" required>
                                <div class="invalid-feedback">
                                    Veuillez saisir un nom pour la tâche.
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="taskDescription" class="form-label">
                                    <i class="bi bi-file-text me-2"></i>
                                    Description*
                                </label>
                                <textarea name="description" class="form-control" id="taskDescription" rows="3"
                                    placeholder="Décrivez les détails de la tâche" required></textarea>
                                <div class="invalid-feedback">
                                    Veuillez saisir une description pour la tâche.
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="startDate" class="form-label">
                                        <i class="bi bi-calendar-event me-2"></i>
                                        Date de début*
                                    </label>
                                    <input type="date" name="start_date" class="form-control" id="startDate" required>
                                    <div class="invalid-feedback">
                                        Veuillez sélectionner une date de début.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="endDate" class="form-label">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        Date de fin*
                                    </label>
                                    <input type="date" name="end_date" class="form-control" id="endDate" required>
                                    <div class="invalid-feedback">
                                        Veuillez sélectionner une date de fin.
                                    </div>
                                </div>
                            </div>

                            <!-- Projet -->
                            <div class="mb-3">
                                <label for="projectSelect" class="form-label">
                                    <i class="bi bi-briefcase me-2"></i>
                                    Projet*
                                </label>
                                <select name="projet_id" class="form-select" id="projectSelect" required>
                                    <option value="" selected disabled>Sélectionnez un projet</option>
                                    @foreach ($projets as $projet)
                                        <option value="{{ $projet->id }}">{{ $projet->nom }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un projet.
                                </div>
                            </div>

                            <!-- Employé assigné -->
                            <div class="mb-3">
                                <label for="employeeSelect" class="form-label">
                                    <i class="bi bi-person-badge me-2"></i>
                                    Employé assigné*
                                </label>
                                <select name="employe_id" class="form-select" id="employeeSelect" required>
                                    <option value="" selected disabled>Sélectionnez un employé</option>
                                    @foreach ($employes as $employe)
                                        <option value="{{ $employe->id }}">{{ $employe->nom }} - {{ $employe->poste }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un employé.
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Créer la tâche
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
