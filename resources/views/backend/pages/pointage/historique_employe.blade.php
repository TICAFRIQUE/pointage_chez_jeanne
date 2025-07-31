@extends('backend.layouts.master')

@section('title', 'Historique de ' . $employe->nom)

@section('css')
    <style>
        #filterInput {
            max-width: 400px;
            margin-bottom: 1rem;
        }

        table {
            font-size: 14px;
        }

        thead th {
            background-color: #0dcaf0;
            color: white;
            text-align: center;
        }

        tbody tr:hover {
            background-color: #f1f9fc;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.35em 0.6em;
            border-radius: 0.25rem;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
@endsection

@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Pointage
        @endslot
        @slot('title')
            Historique de {{ $employe->nom }} {{ $employe->prenoms }}
        @endslot
    @endcomponent

    <div class="card shadow rounded-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">📜 Historique des pointages : {{ $employe->nom }} {{ $employe->prenoms }}</h5>
        </div>

        <div class="card-body table-responsive p-4">
            {{-- Filtre de recherche --}}
            <input type="text" id="filterInput" class="form-control" placeholder="Rechercher par date, heure, équipe..."
                autocomplete="off">

            {{-- Résumé du total de retard --}}
            <div class="alert alert-info mt-3">
                <strong>⏳ Cumul total du retard :</strong> {{ $total_retard }} minutes
            </div>

            {{-- Tableau des pointages --}}
            <table class="table table-striped table-hover text-center align-middle mt-3">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Arrivée</th>
                        <th>Départ</th>
                        <th>Équipe</th>
                        <th>Statut</th>
                        <th>Retard (min)</th>
                        <th>Modalité</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pointages as $pointage)
                        @php
                            $heureDebut = optional($pointage->equipe)->heure_debut;
                            $heureArrivee = $pointage->heure_arrivee;
                            $conforme =
                                $heureDebut &&
                                $heureArrivee &&
                                \Carbon\Carbon::parse($heureArrivee)->lte(\Carbon\Carbon::parse($heureDebut));
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pointage->date)->format('d/m/Y') }}</td>
                            <td>{{ $heureArrivee ? \Carbon\Carbon::parse($heureArrivee)->format('H:i') : '-' }}</td>
                            <td>{{ $pointage->heure_depart ? \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') : '-' }}
                            </td>
                            <td>{{ optional($pointage->equipe)->nom ?? 'Non défini' }}</td>
                            <td>
                                @if ($pointage->modalite === 'jour_travail')
                                    @if ($conforme)
                                        <span class="badge bg-success">✅ Conforme</span>
                                    @elseif ($pointage->heure_arrivee)
                                        <span class="badge bg-warning">⏱ Retard</span>
                                    @else
                                        <span class="badge bg-danger">🚫 Absent</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">—</span>
                                @endif
                            </td>
                            <td>{{ $pointage->total_retard * -1 }}</td>
                            <td>
                                @if ($pointage->modalite === 'jour_travail' && $pointage->heure_arrivee)
                                    <span class="badge bg-primary">👤 Présent</span>
                                @elseif ($pointage->modalite === 'pas_jour_travail')
                                    <span class="badge bg-secondary">🛌 Repos</span>
                                @else
                                    <span class="badge bg-danger">🚫 Absent</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted fst-italic">Aucun pointage enregistré pour cet employé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $pointages->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterInput = document.getElementById('filterInput');
            const table = document.querySelector('table tbody');

            filterInput.addEventListener('input', function() {
                const filterValue = this.value.toLowerCase();
                [...table.rows].forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filterValue) ? '' : 'none';
                });
            });
        });
    </script>
@endsection
