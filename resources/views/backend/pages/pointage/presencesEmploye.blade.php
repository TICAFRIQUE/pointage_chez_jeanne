@extends('backend.layouts.master')

@section('title', 'Pointage Équipe')

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />

    <style>
        .pointage-container {
            max-width: 900px;
            margin: 2rem auto;
        }

        input[type="time"],
        select.form-select {
            min-width: 120px;
        }

        .btn-valider {
            max-width: 280px;
            margin: 2rem auto 0 auto;
            display: block;
        }
    </style>
@endsection

@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Pointage
        @endslot
        @slot('title')
            Pointage des employés
        @endslot
    @endcomponent

    <div class="pointage-container card shadow rounded-4">
        <div
            class="card-header bg-secondary text-white d-flex justify-content-between align-items-center rounded-top-4 py-3 px-4">
            <h4 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Pointage par personne</h4>
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

        <div class="card-body px-4 py-4">
            <form action="{{ route('pointages.store') }}" method="POST">
                @csrf

                <div class="mb-4 col-md-3 col-sm-4">
                    <label for="date" class="form-label fw-semibold">📅 Date du pointage</label>
                    <input type="date" name="date" id="date"
                        class="form-control shadow-sm @error('date') is-invalid @enderror"
                        value="{{ old('date', date('Y-m-d')) }}">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <p class="text-muted fst-italic small mb-4">
                    Veuillez enregistrer les heures d’arrivée et de départ pour chaque employé.
                </p>

                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table id="buttons-datatables" class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>#</th>
                                <th>Nom & Prénoms</th>
                                <th>Équipe</th>
                                <th>Heure d’arrivée</th>
                                <th>Heure de départ</th>
                                <th>Modalité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pointageDuJour as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-capitalize">{{ $item->nom . ' ' . $item->prenoms }}</td>
                                    <td>
                                        <select name="equipe[{{ $item->id }}]"
                                            class="form-select form-select-sm shadow-sm">
                                            <option value="" {{ $item->equipe_id ? '' : 'selected' }}>-- Sélectionner
                                                une équipe --</option>
                                            @foreach ($equipes as $equipe)
                                                <option value="{{ $equipe->id }}"
                                                    {{ $item->equipe_id == $equipe->id ? 'selected' : '' }}>
                                                    {{ $equipe->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <input type="time" name="heure_arrivee[{{ $item->id }}]"
                                            class="form-control form-control-sm shadow-sm">
                                    </td>
                                    <td>
                                        <input type="time" name="heure_depart[{{ $item->id }}]"
                                            class="form-control form-control-sm shadow-sm">
                                    </td>
                                    <td>
                                        <select name="modalite[{{ $item->id }}]"
                                            class="form-select form-select-sm shadow-sm modalite-select"
                                            data-id="{{ $item->id }}">
                                            <option value="jour_travail">Present</option>
                                            <option value="pas_jour_travail">Jour de répos</option>
                                            <option value="absent">Absent</option>
                                        </select>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted fst-italic">Aucun employé Enregistré.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($pointageDuJour->isNotEmpty())
                    <button type="submit" class="btn btn-success btn-valider rounded-pill shadow">
                        <i class="ri-check-double-line me-2"></i>Valider le pointage
                    </button>
                @endif
            </form>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            // Activer DataTables
            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                paging: false,
                searching: false,
                info: false,
                responsive: true
            });

            // Gérer l’activation/désactivation des horaires selon la modalité
            $('.modalite-select').each(function() {
                const select = $(this);
                const id = select.data('id');
                const arrivee = $(`input[name="heure_arrivee[${id}]"]`);
                const depart = $(`input[name="heure_depart[${id}]"]`);

                function toggleInputs() {
                    const value = select.val();
                    const disabled = (value !== 'jour_travail');

                    arrivee.prop('disabled', disabled);
                    depart.prop('disabled', disabled);

                    if (disabled) {
                        arrivee.val('');
                        depart.val('');
                    }
                }

                select.on('change', toggleInputs);
                toggleInputs(); // Au chargement
            });
        });
    </script>
@endsection
