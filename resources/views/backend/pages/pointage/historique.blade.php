@extends('backend.layouts.master')

@section('title', 'Historique des pointages')

@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1') Pointage @endslot
        @slot('title') Historique @endslot
    @endcomponent

    <div class="card shadow rounded-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">📜 Historique des pointages</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Nom & Prénoms</th>
                        <th>Heure d’arrivée</th>
                        <th>Heure de départ</th>
                        <th>Equipe</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pointages as $pointage)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pointage->date)->format('d/m/Y') }}</td>
                            <td>{{ $pointage->employe->nom }} {{ $pointage->employe->prenoms }}</td>
                            <td>{{ $pointage->heure_arrivee }}</td>
                            <td>{{ $pointage->heure_depart }}</td>
                            <td>{{ $pointage->employe->equipe->nom }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Aucun pointage trouvé.</td>
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
