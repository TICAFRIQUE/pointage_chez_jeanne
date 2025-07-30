<div class="app-menu navbar-menu">
    <!-- LOGO + toggle bouton -->
    <div class="navbar-brand-box">

        <button type="button" class="btn btn-sm p-0 fs-20 header-item btn-vertical-sm-hover" id="vertical-hover"
            aria-label="Toggle sidebar">
            <i class="ri-menu-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <ul class="navbar-nav" id="navbar-nav">
                @can('voir-tableau de bord')
                    <li class="nav-item">
                        <a href="{{ route('dashboard.index') }}"
                            class="nav-link menu-link {{ Route::is('dashboard.*') ? 'active' : '' }}"
                            title="Tableau de bord">
                            <i class="ri-bar-chart-2-line"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pointages.listEquipe') }}"
                            class="nav-link menu-link {{ Route::is('pointage.*') ? 'active' : '' }}"
                            title="Pointage des équipes">
                            <i class="ri-clock-line"></i>
                            <span>Pointage</span>
                        </a>

                    </li>

                    <li class="nav-item">
                        <a href="{{ route('employes.index') }}"
                            class="nav-link menu-link {{ Route::is('employes.*') ? 'active' : '' }}"
                            title="Liste des employés">
                            <i class="ri-user-3-line"></i>
                            <span>Employés</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('equipes.index') }}"
                            class="nav-link menu-link {{ Route::is('equipes.*') ? 'active' : '' }}"
                            title="Gestion des équipes">
                            <i class="ri-group-line"></i>
                            <span>Équipes</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pointages.historique') }}"
                            class="nav-link menu-link {{ Route::is('historique.*') ? 'active' : '' }}"
                            title="Historique des pointages">
                            <i class="ri-history-line"></i>
                            <span>Historique</span>
                        </a>
                    </li>
                @endcan

                <!-- Paramètres -->
                @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'developpeur' || Auth::user()->can('voir-parametre'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Route::is('role.*') || Route::is('parametre.*') || Route::is('module.*') || Route::is('permission.*') || Route::is('admin-register.*') ? 'active' : '' }}"
                            href="#sidebarParam" data-bs-toggle="collapse" role="button" aria-expanded="false"
                            aria-controls="sidebarParam">
                            <i class="ri-settings-2-fill"></i>
                            <span>Paramètres</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Route::is('role.*') || Route::is('parametre.*') || Route::is('module.*') || Route::is('permission.*') || Route::is('admin-register.*') ? 'show' : '' }}"
                            id="sidebarParam">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('parametre.index') }}"
                                        class="nav-link {{ Route::is('parametre.*') ? 'active' : '' }}">
                                        Informations
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin-register.index') }}"
                                        class="nav-link {{ Route::is('admin-register.*') ? 'active' : '' }}">
                                        Utilisateurs
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('module.index') }}"
                                        class="nav-link {{ Route::is('module.*') ? 'active' : '' }}">
                                        Modules
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('role.index') }}"
                                        class="nav-link {{ Route::is('role.*') ? 'active' : '' }}">
                                        Rôles
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('permission.index') }}"
                                        class="nav-link {{ Route::is('permission.*') ? 'active' : '' }}">
                                        Permissions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<div class="sidebar-background"></div>
</div>

<!-- Overlay pour fermer le menu sur mobile -->
<div class="vertical-overlay"></div>

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les tooltips Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Gestion toggle menu responsive
            const menu = document.querySelector('.app-menu');
            const overlay = document.querySelector('.vertical-overlay');
            const toggleBtn = document.getElementById('vertical-hover');

            if (toggleBtn && menu && overlay) {
                toggleBtn.addEventListener('click', () => {
                    menu.classList.toggle('show');
                    overlay.classList.toggle('active');
                });

                overlay.addEventListener('click', () => {
                    menu.classList.remove('show');
                    overlay.classList.remove('active');
                });
            }
        });
    </script>
@endsection
