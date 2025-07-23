<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-layout="vertical"
      data-topbar="light"
      data-sidebar="dark"
      data-sidebar-size="lg"
      data-sidebar-image="none"
      data-preloader="disable"
      data-theme="default"
      data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <meta name="description" content="Tableau de bord d'administration pour le restaurant Chez Jeanne" />
    <meta name="author" content="Ticafrique" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    @foreach([57,60,72,76,114,120,144,152,180] as $size)
        <link rel="apple-touch-icon" sizes="{{ $size }}x{{ $size }}"
              href="{{ asset("assets/img/favicon/apple-icon-{$size}x{$size}.png") }}">
    @endforeach

    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/img/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles -->
    @include('backend.layouts.head-css')
</head>

<body>
    <!-- Layout Wrapper -->
    <div id="layout-wrapper">

        <!-- Topbar -->
        @include('backend.layouts.topbar')

        <!-- Sidebar -->
        @include('backend.layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Alertes -->
                    @include('sweetalert::alert')
                    @include('backend.components.alertMessage')

                    <!-- Contenu principal -->
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            @include('backend.layouts.footer')
        </div>
    </div>

    <!-- Scripts -->
    @include('backend.layouts.vendor-scripts')
</body>
</html>
