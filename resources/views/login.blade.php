<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connexion - Gemini Management System</title>
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

                            <!-- Mini pitch -->
                            <h4 class="text-center mb-2">Bienvenue sur <strong>GEMINI &amp; CO</strong></h4>
                            <p class="text-center text-muted mb-4">
                                Gestion simplifiée des employés et projets digitaux de votre entreprise.
                            </p>

                            <h3 class="card-title text-start mb-3">Connexion</h3>

                            <!-- Affichage des erreurs de validation -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Affichage du message de succès pour reset password -->
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Adresse e-mail *</label>
                                    <input type="email" name="email" id="email" class="form-control p_input"
                                        value="{{ old('email') }}" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot de passe *</label>
                                    <input type="password" name="password" id="password" class="form-control p_input"
                                        required>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                                    </div>
                                    <a href="#" class="forgot-pass" onclick="showForgotPasswordModal()">Mot de
                                        passe oublié ?</a>
                                </div>
                                <div class="text-center d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-block enter-btn">Se
                                        connecter</button>
                                </div>
                            </form>

                            <p class="text-center mt-3 text-muted">
                                Besoin d'aide ? Contactez le support à
                                <a href="mailto:support@gemini.com">support@gemini.com</a>
                            </p>

                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- Modal pour mot de passe oublié -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Réinitialiser le mot de passe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="forgotPasswordForm" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="forgot_email" class="form-label">Adresse e-mail</label>
                            <input type="email" class="form-control" id="forgot_email" name="email" required>
                            <div class="form-text">
                                Nous vous enverrons un lien pour réinitialiser votre mot de passe.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Envoyer le lien</button>
                        </div>
                    </form>
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

    <!-- Bootstrap JS pour le modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showForgotPasswordModal() {
            const modal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
            modal.show();
        }

        // Gestion du formulaire de mot de passe oublié
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('forgot_email').value;

            if (!email) {
                alert('Veuillez saisir votre adresse e-mail');
                return;
            }

            // Simulation d'envoi d'email (à remplacer par votre logique Laravel)
            alert('Un lien de réinitialisation a été envoyé à votre adresse e-mail.');

            // Fermer le modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
            modal.hide();

            // Optionnel : soumettre réellement le formulaire
            // this.submit();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const rememberCheckbox = document.getElementById('remember');
            const emailInput = document.getElementById('email');

            // Charger l'email sauvegardé si disponible
            const savedEmail = localStorage.getItem('rememberedEmail');
            if (savedEmail) {
                emailInput.value = savedEmail;
                rememberCheckbox.checked = true;
            }

            // Sauvegarder/supprimer l'email selon la checkbox
            rememberCheckbox.addEventListener('change', function() {
                if (this.checked && emailInput.value) {
                    localStorage.setItem('rememberedEmail', emailInput.value);
                } else {
                    localStorage.removeItem('rememberedEmail');
                }
            });

            // Mettre à jour l'email sauvegardé si la checkbox est cochée
            emailInput.addEventListener('input', function() {
                if (rememberCheckbox.checked) {
                    localStorage.setItem('rememberedEmail', this.value);
                }
            });
        });
    </script>
</body>

</html>
