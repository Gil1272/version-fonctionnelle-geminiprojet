@extends('layout.template')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Formulaire de création d'employé</h4>
                        <p class="card-description"> Remplissez tous les champs pour créer un employé </p>

                        <!-- FORMULAIRE -->
                        <form class="forms-sample" method="POST" action="{{ route('employes.store') }}"
                            enctype="multipart/form-data">
                            @csrf <!-- Protection CSRF -->

                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" name="prenom" id="prenom"
                                    placeholder="Prénom" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    required>
                            </div>

                            <!-- Titre/Poste -->
                            <div class="form-group">
                                <label for="poste">Titre/Poste*</label>
                                <select class="form-select" name="poste" id="poste" required>
                                    <option value="" selected disabled>Sélectionnez un titre</option>
                                    <option value="dev_junior">Développeur Junior</option>
                                    <option value="dev_senior">Développeur Senior</option>
                                    <option value="lead_dev">Lead Développeur</option>
                                    <option value="frontend_dev">Développeur Frontend</option>
                                    <option value="backend_dev">Développeur Backend</option>
                                    <option value="fullstack_dev">Développeur Fullstack</option>
                                    <option value="mobile_dev">Développeur Mobile</option>
                                    <option value="devops">DevOps Engineer</option>
                                </select>
                            </div>

                            <!-- Contact -->
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" class="form-control" name="contact" id="contact"
                                    placeholder="Numéro de téléphone" required>
                            </div>

                            <!-- Genre -->
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <select class="form-select" name="genre" id="genre" required>
                                    <option value="Homme">Masculin</option>
                                    <option value="Femme">Féminin</option>
                                </select>
                            </div>

                            <!-- Photo de profil -->
                            <div class="form-group">
                                <label>Photo de profil</label>
                                <input type="file" name="photo" class="form-control" required>
                            </div>

                            <!-- Adresse -->
                            <div class="form-group">
                                <label for="adresse">Adresse</label>
                                <input type="text" class="form-control" name="adresse" id="adresse"
                                    placeholder="Ville, Quartier" required>
                            </div>

                            <!-- Boutons -->
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i> Créer un employé
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i> Réinitialiser
                                </button>
                            </div>

                        </form>
                        <!-- FIN FORMULAIRE -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
