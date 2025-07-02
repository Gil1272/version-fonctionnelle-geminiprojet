<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo"
            href="https://www.goafricaonline.com/bj/843293-gemini-company-informatique-cotonou-benin" target="_blank"
            aria-label="GEMINI CO">
            <svg width="150" height="40" viewBox="0 0 300 80" xmlns="http://www.w3.org/2000/svg" role="img"
                aria-labelledby="title">
                <title>Logo GEMINI CO</title>
                <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"
                    font-family="Arial, Helvetica, sans-serif" font-weight="700" font-size="48" fill="#FFFFFF">
                    GEMINI & CO
                </text>
            </svg>
        </a>
        {{-- <a class="sidebar-brand brand-logo-mini" href="index.html">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
        </a> --}}
    </div>

    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                @if (Auth::guard('web')->check() || Auth::guard('employe')->check())
                    @php
                        $user = Auth::guard('web')->check()
                            ? Auth::guard('web')->user()
                            : Auth::guard('employe')->user();
                        $isAdmin = Auth::guard('web')->check();
                    @endphp


                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                @if (session('role') == 'admin')
                                    {{-- Admin: Afficher les initiales --}}
                                    <div class="avatar-wrapper">
                                        <div class="avatar bg-primary rounded-circle d-flex justify-content-center align-items-center"
                                            style="width: 35px; height: 35px;">
                                            <span class="text-white font-weight-bold">
                                                {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                                {{ Str::upper(Str::substr($user->name, strpos($user->name, ' ') + 1, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    {{-- Employé: Afficher la photo --}}
                                    <img class="img-xs rounded-circle"
                                        src="{{ asset('storage/' . (session('employe')->photo ?? 'default.png')) }}"
                                        alt="">
                                @endif
                                <span class="count bg-success"></span>
                            </div>


                            @if (session('role') == 'admin')
                                {{-- Afficher les informations de l'administrateur --}}
                                <div class="profile-name">
                                    <h5 class="mb-0 font-weight-normal">{{ $user->name }}</h5>
                                    <span>Admin</span>
                                </div>
                            @else
                                {{-- Afficher les informations de l'employé --}}
                                <div class="profile-name">
                                    <h5 class="mb-0 font-weight-normal">{{ session('employe')->nom }}
                                        {{ session('employe')->prenom }}</h5>
                                    <span>Employé</span>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif


                <a href="#" id="profile-dropdown" data-bs-toggle="dropdown" title="Ouvrir le menu profil"
                    aria-label="Ouvrir le menu profil">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                    aria-labelledby="profile-dropdown">
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-cog text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-calendar-today text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Menu Employés -->
        <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#employes-menu" aria-expanded="false"
                aria-controls="employes-menu">
                <span class="menu-icon"><i class="mdi mdi-account-multiple"></i></span>
                <span class="menu-title">Employés</span>
                <i class="menu-arrow bi bi-chevron-right"></i>

            </a>
            <div class="collapse" id="employes-menu" data-bs-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employes.index') }}">Listes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employes.create') }}">Créer un employé</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Menu Projets -->
        <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#projets-menu" aria-expanded="false"
                aria-controls="projets-menu">
                <span class="menu-icon"><i class="mdi mdi-folder-multiple"></i></span>
                <span class="menu-title">Projets</span>
                <i class="menu-arrow bi bi-chevron-right"></i>

            </a>
            <div class="collapse" id="projets-menu" data-bs-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projets.index') }}">Listes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projets.create') }}">Créer un projet</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Mes Tâches -->
        <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#projets-menu" aria-expanded="false"
                aria-controls="projets-menu">
                <span class="menu-icon"><i class="mdi mdi-folder-multiple"></i></span>
                <span class="menu-title">Tâches</span>
                <i class="menu-arrow bi bi-chevron-right"></i>

            </a>
            <div class="collapse" id="projets-menu" data-bs-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('taches.index') }}">Listes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('taches.create') }}">Créer une tâche</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Autres menus -->
        {{-- <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('taches.create') }}">
                <span class="menu-icon"><i class="mdi mdi-playlist-play"></i></span>
                <span class="menu-title">Tâches</span>
            </a>
        </li> --}}
    </ul>
</nav>
