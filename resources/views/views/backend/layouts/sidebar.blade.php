
{{--  --}}
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box d-flex align-items-center justify-content-between px-3 py-2">
        <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            @if (isset($setting) && $setting->getFirstMediaUrl('logo_header'))
                <img src="{{ URL::asset($setting->getFirstMediaUrl('logo_header')) }}" alt="Logo"
                    class="rounded-circle" height="40">
            @else
                <span class="text-white fw-bold fs-5">{{ config('app.name') }}</span>
            @endif
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <ul class="navbar-nav" id="navbar-nav">

                @can('voir-tableau de bord')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Route::is('dashboard.*') ? 'active' : '' }}"
                            href="{{ route('dashboard.index') }}">
                            <i class="ri-dashboard-2-line"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>

                @endcan

                @if (Auth::user()->role === 'superadmin' || Auth::user()->role === 'developpeur' || Auth::user()->can('voir-parametre'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarParam" data-bs-toggle="collapse"
                            role="button" aria-expanded="{{ Route::is('parametre.*', 'module.*', 'role.*', 'permission.*', 'admin-register.*') ? 'true' : 'false' }}"
                            aria-controls="sidebarParam">
                            <i class="ri-settings-2-fill"></i>
                            <span>Paramètres</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Route::is('parametre.*', 'module.*', 'role.*', 'permission.*', 'admin-register.*') ? 'show' : '' }}"
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
                                        Permissions / Rôles
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
