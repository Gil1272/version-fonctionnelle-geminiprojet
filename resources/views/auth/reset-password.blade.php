<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Réinitialiser le mot de passe - Gemini Management System</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">

                            <!-- Logo -->
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="Gemini & Co Logo"
                                    style="width: 120px;">
                            </div>

                            <!-- Titre -->
                            <h4 class="text-center mb-2">Réinitialiser le mot de passe</h4>
                            <p class="text-center text-muted mb-4">
                                Saisissez votre nouveau mot de passe ci-dessous.
                            </p>

                            <!-- Affichage des erreurs -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="form-group">
                                    <label for="email">Adresse e-mail</label>
                                    <input type="email" id="email" class="form-control p_input"
                                        value="{{ $email }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="password">Nouveau mot de passe *</label>
                                    <input type="password" name="password" id="password" class="form-control p_input"
                                        required autofocus>
                                    <small class="form-text text-muted">
                                        Le mot de passe doit contenir au moins 8 caractères.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirmer le mot de passe *</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control p_input" required>
                                </div>

                                <div class="text-center d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-block enter-btn">
                                        Réinitialiser le mot de passe
                                    </button>
                                </div>
                            </form>

                            <!-- Lien de retour -->
                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-primary">
                                    <i class="mdi mdi-arrow-left"></i> Retour à la connexion
                                </a>
                            </div>

                            <p class="text-center mt-3 text-muted">
                                Besoin d'aide ? Contactez le support à
                                <a href="mailto:support@gemini.com">support@gemini.com</a>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>

    <script>
        // Validation côté client
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');

            function validatePasswords() {
                if (password.value !== passwordConfirmation.value) {
                    passwordConfirmation.setCustomValidity('Les mots de passe ne correspondent pas.');
                } else {
                    passwordConfirmation.setCustomValidity('');
                }
            }

            password.addEventListener('input', validatePasswords);
            passwordConfirmation.addEventListener('input', validatePasswords);
        });
    </script>
</body>

</html>
