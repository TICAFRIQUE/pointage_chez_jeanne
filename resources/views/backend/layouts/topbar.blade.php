<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header d-flex justify-content-between align-items-center">

            {{-- Logo --}}
            <div class="d-flex align-items-center">
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('build/images/logo-sm.png') }}" alt="Logo" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('build/images/logo-dark.png') }}" alt="Logo" height="17">
                        </span>
                    </a>

                    <a href="{{ route('dashboard.index') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('build/images/logo-sm.png') }}" alt="Logo" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('build/images/logo-light.png') }}" alt="Logo" height="17">
                        </span>
                    </a>
                </div>

                {{-- Hamburger Menu --}}
                <button type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none"
                    id="topnav-hamburger-icon" aria-label="Toggle navigation">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            {{-- Profil et actions --}}
            <div class="d-flex align-items-center">

                {{-- Mode clair/sombre --}}
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle light-dark-mode"
                        aria-label="Toggle dark mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                {{-- Profil utilisateur --}}
                @auth
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user"
                                    src="{{ Auth::user()->avatar ? asset('images/' . Auth::user()->avatar) : asset('images/user-icon.png') }}"
                                    alt="Avatar">
                                <span class="text-start ms-xl-2">
                                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                        {{ Auth::user()->username }}
                                    </span>
                                    <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">
                                        {{ Auth::user()->roles[0]->name ?? '' }}
                                    </span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">Bienvenue {{ Auth::user()->username }} !</h6>
                            <a class="dropdown-item" href="{{ route('admin-register.profil', Auth::user()->id) }}">
                                <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                <span class="align-middle">Profil</span>
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
                                <span class="align-middle">Aide</span>
                            </a>
                            <div class="dropdown-divider"></div>

                            {{-- Déconnexion --}}
                            <a class="dropdown-item" href="javascript:void(0);"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bx bx-power-off font-size-16 align-middle me-1"></i>
                                <span>Déconnexion</span>
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endauth

            </div>
        </div>
    </div>
</header>
