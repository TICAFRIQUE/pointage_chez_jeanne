@extends('backend.layouts.master')

@section('title', 'Historique de ' . $employe->nom)

@section('css')
    <style>
        /* tes styles ici ... */
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

            <div class="mb-3">
                <input type="text" id="filterInput" class="form-control"
                    placeholder="Rechercher par date, heure ou équipe..." autocomplete="off">
            </div>

            <table class="table table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure d’arrivée</th>
                        <th>Heure de départ</th>
                        <th>Équipe</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pointages as $pointage)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pointage->date)->format('d/m/Y') }}</td>
                            <td>{{ $pointage->heure_arrivee ? \Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') : '-' }}
                            </td>
                            <td>{{ $pointage->heure_depart ? \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') : '-' }}
                            </td>
                            <td>{{ optional($pointage->equipe)->nom ?? 'Non défini' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted fst-italic">Aucun pointage enregistré pour cet employé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

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
