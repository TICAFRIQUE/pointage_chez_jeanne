@extends('backend.layouts.master')

@section('title', 'Équipes')

@section('css')
    {{-- Pas besoin de DataTables si pas de table --}}
    <style>
        /* Container centré avec max-width */
        .equipes-container {
            max-width: 960px;
            margin: 2rem auto;
            padding: 0 15px;
        }

        /* Grille responsive pour cartes équipes */
        .equipes-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
        }

        .equipe-card {
            background: white;
            border: 1px solid #cfe2ff;
            /* bootstrap primary-subtle */
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 1rem 2rem;
            min-width: 220px;
            flex: 1 1 220px;
            max-width: 280px;
            text-align: center;
            transition: transform 0.2s ease-in-out;
        }

        .equipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.25);
        }

        .equipe-name {
            font-weight: 600;
            color: #0d6efd;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.4rem;
        }

        .equipe-hours {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .equipe-hours i {
            vertical-align: middle;
            margin-right: 0.3rem;
        }

        /* Bouton centré sous la grille */
        .btn-pointage {
            display: block;
            margin: 2.5rem auto 0;
            max-width: 260px;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Accueil
        @endslot
        @slot('title')
            Équipes
        @endslot
    @endcomponent

    <div class="equipes-container">
        <div class="card shadow rounded-4 border-0">
            <div
                class="card-header bg-secondary text-white d-flex justify-content-between align-items-center rounded-top-4 py-3 px-4">
                <h4 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-people-fill"></i> Heures de références
                </h4>
                <a href="{{ route('pointages.listEquipe') }}" class="btn btn-outline-light btn-sm fw-semibold shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Retour
                </a>
            </div>


            @if (session('success_message'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    {{ session('success_message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            <div class="card-body bg-light rounded-bottom py-4">
                <h5
                    class="text-center mb-4 fw-semibold text-uppercase text-primary d-flex justify-content-center align-items-center gap-2">
                    <i class="bi bi-clock-history"></i> Horaires des équipes
                </h5>

                <div class="equipes-grid">
                    @forelse($equipe as $item)
                        <div class="equipe-card">
                            <div class="equipe-name">
                                <i class="bi bi-person-bounding-box text-primary"></i>
                                {{ $item->nom }}
                            </div>
                            <div class="equipe-hours mb-1">
                                <i class="bi bi-clock text-success"></i>
                                <strong>Début :</strong> {{ $item->heure_debut }}
                            </div>
                            <div class="equipe-hours">
                                <i class="bi bi-clock-fill text-danger"></i>
                                <strong>Fin :</strong> {{ $item->heure_fin }}
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted fst-italic w-100">Aucune équipe disponible. Veuillez en créer une.
                        </p>
                    @endforelse
                </div>

                @if ($equipe->isNotEmpty())
                    <a href="{{ route('pointages.pointageDuJour') }}" class="btn btn-outline-primary btn-pointage">
                        <i class="bi bi-clipboard-check me-1"></i> Faire le pointage
                    </a>
                @endif


            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- Pas besoin de DataTables ici si pas de tableau --}}

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
