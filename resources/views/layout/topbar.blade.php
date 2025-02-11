   <!-- partial:partials/_navbar.html -->
   <nav class="navbar p-0 fixed-top d-flex flex-row">
       <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
           <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ asset('assets/images/logo.png') }}"
                   alt="logo" /></a>
       </div>
       <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
           <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
               <span class="mdi mdi-menu"></span>
           </button>

           <ul class="navbar-nav navbar-nav-right">
               <li class="nav-item nav-settings d-none d-lg-block">
                   <a class="nav-link" href="#">
                       <i class="mdi mdi-view-grid"></i>
                   </a>
               </li>

               <li class="nav-item dropdown border-left">
                   <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                       data-bs-toggle="dropdown">
                       <i class="mdi mdi-bell"></i>
                       <span class="count bg-danger"></span>
                   </a>
                   <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list"
                       aria-labelledby="notificationDropdown">
                       <h6 class="p-3 mb-0">Notifications</h6>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item preview-item">
                           <div class="preview-thumbnail">
                               <div class="preview-icon bg-dark rounded-circle">
                                   <i class="mdi mdi-calendar text-success"></i>
                               </div>
                           </div>
                           <div class="preview-item-content">
                               <p class="preview-subject mb-1">Event today</p>
                               <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event
                                   today </p>
                           </div>
                       </a>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item preview-item">
                           <div class="preview-thumbnail">
                               <div class="preview-icon bg-dark rounded-circle">
                                   <i class="mdi mdi-cog text-danger"></i>
                               </div>
                           </div>
                           <div class="preview-item-content">
                               <p class="preview-subject mb-1">Settings</p>
                               <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                           </div>
                       </a>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item preview-item">
                           <div class="preview-thumbnail">
                               <div class="preview-icon bg-dark rounded-circle">
                                   <i class="mdi mdi-link-variant text-warning"></i>
                               </div>
                           </div>
                           <div class="preview-item-content">
                               <p class="preview-subject mb-1">Launch Admin</p>
                               <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                           </div>
                       </a>
                       <div class="dropdown-divider"></div>
                       <p class="p-3 mb-0 text-center">See all notifications</p>
                   </div>
               </li>
               <li class="nav-item dropdown">
                   <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                       @if (Auth::guard('web')->check() || Auth::guard('employe')->check())
                           @php
                               $user = Auth::guard('web')->check()
                                   ? Auth::guard('web')->user()
                                   : Auth::guard('employe')->user();
                               $isAdmin = Auth::guard('web')->check();
                           @endphp
                           <div class="navbar-profile">
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

                               <p class="mb-0 d-none d-sm-block navbar-profile-name">
                                   @if (session('role') == 'admin')
                                       {{ $user->name }}
                                   @else
                                       {{ session('employe')->nom }} {{ session('employe')->prenom }}
                                   @endif
                               </p>
                               <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                           </div>
                       @endif
                   </a>
                   <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list"
                       aria-labelledby="profileDropdown">
                       <h6 class="p-3 mb-0">Profil</h6>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item preview-item">
                           <div class="preview-thumbnail">
                               <div class="preview-icon bg-dark rounded-circle">
                                   <i class="mdi mdi-cog text-success"></i>
                               </div>
                           </div>
                           <div class="preview-item-content">
                               <p class="preview-subject mb-1">Paramètres</p>
                           </div>
                       </a>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item preview-item">
                           <div class="preview-thumbnail">
                               <div class="preview-icon bg-dark rounded-circle">
                                   <i class="mdi mdi-logout text-danger"></i>
                               </div>
                           </div>
                           <form method="POST" action="{{ route('logout') }}" class="preview-item-content">
                               @csrf
                               <button type="submit" class="preview-subject mb-1"
                                   style="background: none; border: none; padding: 0; cursor: pointer;">
                                   Se Déconnecter
                               </button>
                           </form>
                       </a>
                       <div class="dropdown-divider"></div>
                       <p class="p-3 mb-0 text-center">Advanced settings</p>
                   </div>
               </li>
           </ul>
           <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
               data-toggle="offcanvas">
               <span class="mdi mdi-format-line-spacing"></span>
           </button>
       </div>
   </nav>
   <!-- partial -->
