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
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📜 Historique des pointages</h5>
        </div>

        <form action="{{ route('pointages.historique') }}" method="GET" class="p-3 row g-3 align-items-end">
            <div class="col-md-3">
                <label for="date_debut" class="form-label">Date début :</label>
                <input type="date" name="date_debut" id="date_debut" value="{{ request('date_debut') }}"
                    class="form-control form-control-sm shadow-sm">
            </div>
            <div class="col-md-3">
                <label for="date_fin" class="form-label">Date fin :</label>
                <input type="date" name="date_fin" id="date_fin" value="{{ request('date_fin') }}"
                    class="form-control form-control-sm shadow-sm">
            </div>
            <div class="col-md-3">
                <label for="equipe_id" class="form-label">Équipe :</label>
                <select name="equipe_id" id="equipe_id" class="form-select form-select-sm shadow-sm">
                    <option value="">-- Toutes les équipes --</option>
                    @foreach ($equipes as $equipe)
                        <option value="{{ $equipe->id }}" {{ request('equipe_id') == $equipe->id ? 'selected' : '' }}>
                            {{ $equipe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary shadow-sm">🔍 Filtrer</button>
                <a href="{{ route('pointages.historique') }}" class="btn btn-sm btn-outline-secondary">♻ Réinitialiser</a>
                <a href="{{ route('pointages.exportPdf', request()->query()) }}" class="btn btn-sm btn-danger">📄 Exporter
                    PDF</a>
            </div>
        </form>

        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle text-center">
                <thead class="table-info text-dark">
                    <tr>
                        <th>Date</th>
                        <th>Employé</th>
                        <th>Arrivée</th>
                        <th>Départ</th>
                        <th>Équipe</th>
                        <th>🕒 Début équipe</th>
                        <th>Statut</th>
                        <th>⏱ Retard (min)</th>
                        <th>Modalité</th>
                        <th>Action</th>
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
                            <td>{{ $heureDebut ? \Carbon\Carbon::parse($heureDebut)->format('H:i') : '-' }}</td>

                            <td>
                                @if ($pointage->modalite === 'jour_travail')
                                    @if ($conforme)
                                        <span class="badge bg-success rounded-pill">✅ Conforme</span>
                                    @elseif ($heureArrivee)
                                        <span class="badge bg-warning text-dark rounded-pill">⏱ Retard</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill">🚫 Absent</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary rounded-pill">—</span>
                                @endif
                            </td>

                            <td><strong class="text-danger">{{ abs($pointage->total_retard) }}</strong></td>

                            <td>
                                @if ($pointage->modalite === 'jour_travail' && $heureArrivee)
                                    <span class="badge bg-primary rounded-pill">👤 Présent</span>
                                @elseif ($pointage->modalite === 'pas_jour_travail')
                                    <span class="badge bg-secondary rounded-pill">🛌 Repos</span>
                                @else
                                    <span class="badge bg-danger rounded-pill">🚫 Absent</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('pointages.historique.employe', $pointage->employe_id) }}"
                                    class="btn btn-sm btn-outline-info rounded-pill">👁 Voir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-muted fst-italic">Aucun pointage trouvé pour cette période.</td>
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
