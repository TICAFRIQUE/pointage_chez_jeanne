@extends('backend.layouts.master')

@section('title', 'Historique des pointages')

@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Pointage
        @endslot
        @slot('title')
            Historique
        @endslot
    @endcomponent

    <div class="card shadow rounded-4">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📜 Historique des pointages</h5>
        </div>

        <!-- Filtres -->
        <form action="{{ route('pointages.historique') }}" method="GET" class="p-3 row g-3 align-items-end">

            <div class="col-md-3">
                <label for="date_debut" class="form-label">Date début :</label>
                <input type="date" name="date_debut" id="date_debut" value="{{ request('date_debut') }}"
                    class="form-control form-control-sm">
            </div>

            <div class="col-md-3">
                <label for="date_fin" class="form-label">Date fin :</label>
                <input type="date" name="date_fin" id="date_fin" value="{{ request('date_fin') }}"
                    class="form-control form-control-sm">
            </div>

            <div class="col-md-3">
                <label for="equipe_id" class="form-label">Équipe :</label>
                <select name="equipe_id" id="equipe_id" class="form-select form-select-sm">
                    <option value="">-- Toutes les équipes --</option>
                    @foreach ($equipes as $equipe)
                        <option value="{{ $equipe->id }}" {{ request('equipe_id') == $equipe->id ? 'selected' : '' }}>
                            {{ $equipe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary">Filtrer</button>
                <a href="{{ route('pointages.historique') }}" class="btn btn-sm btn-outline-secondary">Réinitialiser</a>
                <a href="{{ route('pointages.exportPdf', request()->query()) }}" class="btn btn-sm btn-danger">Exporter
                    PDF</a>
            </div>
        </form>

        <!-- Table -->
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Nom & Prénoms</th>
                        <th>Heure d’arrivée</th>
                        <th>Heure de départ</th>
                        <th>Équipe</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pointages as $pointage)
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
                            <td>{{ $pointage->employe->nom }} {{ $pointage->employe->prenoms }}</td>
                            <td>{{ $heureArrivee ? \Carbon\Carbon::parse($heureArrivee)->format('H:i') : '-' }}</td>
                            <td>{{ $pointage->heure_depart ? \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') : '-' }}
                            </td>
                            <td>{{ optional($pointage->equipe)->nom ?? 'Non défini' }}</td>
                            <td>
                                @if ($conforme)
                                    <span class="badge bg-success">Conforme</span>
                                @else
                                    <span class="badge bg-danger">Retard</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pointages.historique.employe', $pointage->employe_id) }}"
                                    class="btn btn-sm btn-outline-primary">Voir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted fst-italic">Aucun pointage trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $pointages->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
