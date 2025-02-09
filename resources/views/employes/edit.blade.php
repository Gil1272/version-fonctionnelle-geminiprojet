@extends('layout.template')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Formulaire de modification d'employé</h4>
                        <p class="card-description"> Modifiez les champs nécessaires pour mettre à jour les informations de
                            l'employé </p>

                        <!-- FORMULAIRE -->
                        <form class="forms-sample" method="POST" action="{{ route('employes.update', $employe->id) }}"
                            enctype="multipart/form-data">
                            @csrf <!-- Protection CSRF -->
                            @method('PUT') <!-- Méthode PUT pour la mise à jour -->

                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom"
                                    value="{{ old('nom', $employe->nom) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" name="prenom" id="prenom"
                                    placeholder="Prénom" value="{{ old('prenom', $employe->prenom) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    value="{{ old('email', $employe->email) }}" required>
                            </div>

                            <!-- Titre/Poste -->
                            <div class="form-group">
                                <label for="poste">Titre/Poste*</label>
                                <select class="form-select" name="poste" id="poste" required>
                                    <option value="" disabled>Sélectionnez un titre</option>
                                    <option value="dev_junior" {{ $employe->poste == 'dev_junior' ? 'selected' : '' }}>
                                        Développeur Junior</option>
                                    <option value="dev_senior" {{ $employe->poste == 'dev_senior' ? 'selected' : '' }}>
                                        Développeur Senior</option>
                                    <option value="lead_dev" {{ $employe->poste == 'lead_dev' ? 'selected' : '' }}>Lead
                                        Développeur</option>
                                    <option value="frontend_dev" {{ $employe->poste == 'frontend_dev' ? 'selected' : '' }}>
                                        Développeur Frontend</option>
                                    <option value="backend_dev" {{ $employe->poste == 'backend_dev' ? 'selected' : '' }}>
                                        Développeur Backend</option>
                                    <option value="fullstack_dev"
                                        {{ $employe->poste == 'fullstack_dev' ? 'selected' : '' }}>Développeur Fullstack
                                    </option>
                                    <option value="mobile_dev" {{ $employe->poste == 'mobile_dev' ? 'selected' : '' }}>
                                        Développeur Mobile</option>
                                    <option value="devops" {{ $employe->poste == 'devops' ? 'selected' : '' }}>DevOps
                                        Engineer</option>
                                </select>
                            </div>

                            <!-- Contact -->
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" class="form-control" name="contact" id="contact"
                                    placeholder="Numéro de téléphone" value="{{ old('contact', $employe->contact) }}"
                                    required>
                            </div>

                            <!-- Genre -->
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <select class="form-select" name="genre" id="genre" required>
                                    <option value="Homme" {{ $employe->genre == 'Homme' ? 'selected' : '' }}>Masculin
                                    </option>
                                    <option value="Femme" {{ $employe->genre == 'Femme' ? 'selected' : '' }}>Féminin
                                    </option>
                                </select>
                            </div>

                            <!-- Photo de profil -->
                            <div class="form-group">
                                <label>Photo de profil</label>
                                <input type="file" name="photo" class="form-control">
                                <small>Si vous ne souhaitez pas changer la photo, laissez ce champ vide.</small>
                            </div>

                            <!-- Adresse -->
                            <div class="form-group">
                                <label for="adresse">Adresse</label>
                                <input type="text" class="form-control" name="adresse" id="adresse"
                                    placeholder="Ville, Quartier" value="{{ old('adresse', $employe->adresse) }}" required>
                            </div>

                            <!-- Boutons -->
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i> Mettre à jour l'employé
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
