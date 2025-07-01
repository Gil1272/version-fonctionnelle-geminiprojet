<nav class="navbar navbar-expand-lg shadow-sm fixed-top">
    <div class="container-fluid">

        <!-- Burger toggle -->
        <button class="navbar-toggler border-0" type="button" aria-label="Toggle navigation" id="burgerToggle">
            <span class="mdi mdi-menu mdi-24px text-primary"></span>
        </button>

        <!-- Menu principal -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Profil utilisateur simplifié -->
                <li class="nav-item dropdown" style="position: relative;">
                    <a class="nav-link d-flex align-items-center" href="#" id="profileDropdown" role="button"
                        aria-haspopup="true" aria-expanded="false" aria-label="Profil utilisateur">
                        @php
                            $user = Auth::guard('web')->check()
                                ? Auth::guard('web')->user()
                                : Auth::guard('employe')->user();
                            $isAdmin = session('role') === 'admin';
                        @endphp

                        @if ($isAdmin)
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2"
                                style="width: 40px; height: 40px; font-weight: 700; font-size: 1.25rem; user-select:none;">
                                {{ Str::upper(substr($user->name, 0, 1)) }}{{ Str::upper(substr($user->name, strpos($user->name, ' ') + 1, 1)) }}
                            </div>
                        @else
                            <img src="{{ asset('storage/' . (session('employe')->photo ?? 'default.png')) }}"
                                alt="Avatar" class="rounded-circle me-2" width="40" height="40" />
                        @endif

                        <span class="d-none d-lg-inline fw-semibold text-white">
                            {{ $isAdmin ? $user->name : session('employe')->nom . ' ' . session('employe')->prenom }}
                        </span>
                    </a>

                    <ul id="dropdownMenu" class="dropdown-menu dropdown-menu-end shadow-sm border-0 text-white"
                        role="menu" aria-labelledby="profileDropdown"
                        style="
                position: absolute;
                top: 100%;
                right: 0;
                min-width: 200px;
                background-color: #343a40;
                border-radius: 0.25rem;
                padding: 0.5rem 0;
                box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
                z-index: 1050;
                display: none;
              ">
                        <li>
                            <h6 class="dropdown-header">Mon Profil</h6>
                        </li>
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}"><i
                                    class="mdi mdi-account-edit me-2 text-primary"></i>Modifier profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center text-danger"
                                    style="background:none; border:none; cursor:pointer;">
                                    <i class="mdi mdi-logout me-2"></i>Se déconnecter
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

<style>
    /* Navbar text */
    .navbar-light .navbar-nav .nav-link {
        font-weight: 600;
        font-size: 1rem;
    }

    /* Hover for dropdown items */
    .dropdown-menu .dropdown-item:hover {
        background-color: #e7f1ff;
        color: #0d6efd !important;
    }

    /* Modal fade animation */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
        transform: translateY(-25px);
    }

    .modal.fade.show .modal-dialog {
        transform: translateY(0);
    }

    /* Inputs with better focus */
    input.form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 6px #0d6efd99;
    }

    /* Buttons */
    .btn-primary {
        background-color: #0d6efd;
        border: none;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #084ecb;
    }

    .btn-outline-secondary {
        border-color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const profileToggle = document.getElementById('profileDropdown');
        const dropdownMenu = document.getElementById('dropdownMenu');

        profileToggle.addEventListener('click', (e) => {
            e.preventDefault();
            const isVisible = dropdownMenu.style.display === 'block';
            if (isVisible) {
                dropdownMenu.style.display = 'none';
                profileToggle.setAttribute('aria-expanded', 'false');
            } else {
                dropdownMenu.style.display = 'block';
                profileToggle.setAttribute('aria-expanded', 'true');
            }
        });

        // Fermer le menu quand on clique ailleurs
        document.addEventListener('click', (e) => {
            if (!profileToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.style.display = 'none';
                profileToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Fermer avec Échap (optionnel)
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                dropdownMenu.style.display = 'none';
                profileToggle.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>
