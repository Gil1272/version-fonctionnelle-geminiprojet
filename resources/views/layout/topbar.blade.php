<!-- partial:partials/_navbar.html -->
<nav class="navbar p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="index.html">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
        </a>
    </div>
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">

            <!-- Paramètres -->
            <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                    <i class="mdi mdi-view-grid"></i>
                </a>
            </li>

            <!-- Notifications -->
            <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-bell"></i>
                    <span class="count bg-danger"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <li class="dropdown-header p-3">Notifications</li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item preview-item" href="#">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-calendar text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Event today</p>
                            <p class="text-muted ellipsis mb-0">Just a reminder that you have an event today</p>
                        </div>
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item preview-item" href="#">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-cog text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Settings</p>
                            <p class="text-muted ellipsis mb-0">Update dashboard</p>
                        </div>
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item preview-item" href="#">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-link-variant text-warning"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Launch Admin</p>
                            <p class="text-muted ellipsis mb-0">New admin wow!</p>
                        </div>
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="dropdown-footer text-center p-2"><a href="#">See all notifications</a></li>
                </ul>
            </li>

            <!-- Profil utilisateur -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth::guard('web')->check() || Auth::guard('employe')->check())
                        @php
                            $user = Auth::guard('web')->check() ? Auth::guard('web')->user() : Auth::guard('employe')->user();
                            $isAdmin = session('role') === 'admin';
                        @endphp
                        <div class="navbar-profile d-flex align-items-center">
                            @if ($isAdmin)
                                <div class="avatar-wrapper me-2">
                                    <div class="avatar bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                                        <span class="text-white fw-bold">
                                            {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                            {{ Str::upper(Str::substr($user->name, strpos($user->name, ' ') + 1, 1)) }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <img class="img-xs rounded-circle me-2" src="{{ asset('storage/' . (session('employe')->photo ?? 'default.png')) }}" alt="">
                            @endif
                            <span class="navbar-profile-name d-none d-sm-inline">
                                {{ $isAdmin ? $user->name : session('employe')->nom . ' ' . session('employe')->prenom }}
                            </span>
                            <i class="mdi mdi-menu-down d-none d-sm-inline ms-1"></i>
                        </div>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                    <li class="dropdown-header p-3">Profil</li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item preview-item" href="#">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-cog text-success"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject mb-1">Paramètres</p>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item preview-item w-100 text-start" style="background: none; border: none;">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-logout text-danger"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject mb-1">Se Déconnecter</p>
                                </div>
                            </button>
                        </form>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="dropdown-footer text-center p-2"><a href="#">Advanced settings</a></li>
                </ul>
            </li>
        </ul>

        <!-- Responsive toggle -->
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <span class="mdi mdi-format-line-spacing"></span>
        </button>
    </div>
</nav>
<!-- partial -->
