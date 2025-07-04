@extends('layout.template')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container-xl px-4 mt-4">

                <!-- Onglets de navigation -->
                <ul class="nav nav-tabs" id="editTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="true">Profil</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security"
                            type="button" role="tab" aria-controls="security" aria-selected="false">Sécurité</button>
                    </li>
                </ul>

                <!-- Contenu des onglets -->
                <div class="tab-content mt-3" id="editTabsContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        {{-- Contenu PROFIL --}}
                        <!-- Formulaire englobant toute la section profil -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                            id="mainForm">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="card mb-4 mb-xl-0">
                                        <div class="card-header">Photo de profil</div>
                                        <div class="card-body text-center">
                                            @if ($user->photo && file_exists(public_path('storage/' . $user->photo)))
                                                <img class="img-account-profile rounded-circle mb-2"
                                                    src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil"
                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                            @else
                                                <img class="img-account-profile rounded-circle mb-2"
                                                    src="http://bootdey.com/img/Content/avatar/avatar1.png"
                                                    alt="Photo de profil par défaut"
                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                            @endif
                                            <div class="small font-italic text-muted mb-3">JPG ou PNG ne dépassant pas 5 MB
                                            </div>

                                            <!-- Input file et bouton pour changer la photo -->
                                            <input type="file" name="photo" id="avatarInput" accept="image/*"
                                                style="display: none;">
                                            <button class="btn btn-primary btn-sm" type="button"
                                                onclick="document.getElementById('avatarInput').click()">
                                                <i class="fas fa-camera me-1"></i>Changer la photo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="card mb-4">
                                        <div class="card-header">Détails du compte</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="card-body">
                                                    <div class="row gx-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="small mb-1" for="inputFirstName">Prénom</label>
                                                            <input class="form-control" id="inputFirstName" name="prenom"
                                                                type="text" placeholder="Entrez votre prénom"
                                                                value="{{ old('prenom', $user->prenom ?? '') }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="small mb-1" for="inputLastName">Nom</label>
                                                            <input class="form-control" id="inputLastName" name="nom"
                                                                type="text" placeholder="Entrez votre nom"
                                                                value="{{ old('nom', $user->nom ?? '') }}">
                                                        </div>
                                                    </div>
                                                    <div class="row gx-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="small mb-1" for="inputLocation">Adresse</label>
                                                            <input class="form-control" id="inputLocation" name="adresse"
                                                                type="text" placeholder="Entrez votre adresse"
                                                                value="{{ old('adresse', $user->adresse ?? '') }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="small mb-1" for="inputPhone">Numéro de
                                                                téléphone
                                                            </label>
                                                            <input class="form-control" id="inputPhone" name="contact"
                                                                type="tel" placeholder="Entrez votre numéro"
                                                                value="{{ old('contact', $user->contact ?? '') }}">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="small mb-1" for="inputEmailAddress">Adresse
                                                            email
                                                        </label>
                                                        <input class="form-control" id="inputEmailAddress" name="email"
                                                            type="email" placeholder="Entrez votre adresse email"
                                                            value="{{ old('email', $user->email ?? '') }}">
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Enregistrer les
                                                        modifications</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                        {{-- Contenu SÉCURITÉ --}}
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-header">Changer le mot de passe</div>
                                    <div class="card-body">
                                        <form action="{{ route('profile.change-password') }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label class="small mb-1" for="currentPassword">Mot de passe
                                                    actuel</label>
                                                <div class="input-group">
                                                    <input class="form-control" id="currentPassword"
                                                        name="current_password" type="password"
                                                        placeholder="Entrez votre mot de passe actuel">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="togglePassword('currentPassword')">
                                                        <i class="fas fa-eye" id="currentPassword-icon"></i>
                                                    </button>
                                                </div>
                                                @error('current_password')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="small mb-1" for="newPassword">Nouveau mot de passe</label>
                                                <div class="input-group">
                                                    <input class="form-control" id="newPassword" name="password"
                                                        type="password" placeholder="Entrez votre nouveau mot de passe">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="togglePassword('newPassword')">
                                                        <i class="fas fa-eye" id="newPassword-icon"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="small mb-1" for="confirmPassword">Confirmer le mot de
                                                    passe</label>
                                                <div class="input-group">
                                                    <input class="form-control" id="confirmPassword"
                                                        name="password_confirmation" type="password"
                                                        placeholder="Confirmez votre nouveau mot de passe">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="togglePassword('confirmPassword')">
                                                        <i class="fas fa-eye" id="confirmPassword-icon"></i>
                                                    </button>
                                                </div>
                                                @error('password_confirmation')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        // Fonction pour basculer la visibilité du mot de passe
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Upload automatique de l'avatar
        document.getElementById('avatarInput').addEventListener('change', function() {
            document.getElementById('mainForm').submit();
        });
    </script>

    <style>
        .img-account-profile {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .btn-danger-soft {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .btn-danger-soft:hover {
            background-color: #f1b0b7;
            border-color: #ef808a;
        }
    </style>
@endsection
