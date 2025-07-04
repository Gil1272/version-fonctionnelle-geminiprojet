<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mot de passe oublié - Gemini Management System</title>
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
                            <h4 class="text-center mb-2">Mot de passe oublié ?</h4>
                            <p class="text-center text-muted mb-4">
                                Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot
                                de passe.
                            </p>

                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Adresse e-mail *</label>
                                    <input type="email" name="email" id="email" class="form-control p_input"
                                        value="{{ old('email') }}" required autofocus>
                                </div>

                                <div class="text-center d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-block enter-btn">
                                        Envoyer le lien de réinitialisation
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
    @if (session('toast_success') || session('toast_error'))
        <div id="toast-message" style="position: fixed; top: 30px; right: 30px; z-index: 9999; min-width: 250px;"
            class="alert {{ session('toast_success') ? 'alert-success' : 'alert-danger' }}">
            {{ session('toast_success') ?? session('toast_error') }}
        </div>
        <script>
            setTimeout(function() {
                var toast = document.getElementById('toast-message');
                if (toast) toast.style.display = 'none';
            }, 4000); // 4 secondes
        </script>
    @endif
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
</body>

</html>
