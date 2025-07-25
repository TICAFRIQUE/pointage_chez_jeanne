@extends('backend.layouts.master')

@section('title')
    Pointage Équipe
@endsection

@section('css')
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
@endsection

@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Pointage
        @endslot
        @slot('title')
            Employés par Équipe
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow rounded-4">
                <div
                    class="card-header d-flex justify-content-between align-items-center bg-secondary text-white rounded-top">
                    <h5 class="card-title mb-0">👥 Pointage des employés</h5>
                    <a href="{{ route('pointages.listEquipe') }}" class="btn btn-light text-primary fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Retour
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

                        <!-- Sélection de la date -->
                        <div class="row mb-4 justify-content-center">
                            <div class="col-md-6 col-lg-4">
                                <label for="date" class="form-label fw-semibold">📅 Date du pointage</label>
                                <input type="date" name="date" id="date"
                                    class="form-control shadow-sm @error('date') is-invalid @enderror"
                                    value="{{ old('date', date('Y-m-d')) }}">
                            </div>
                        </div>

                        <!-- Table de pointage -->
                        <div class="table-responsive">
                            <table id="buttons-datatables"
                                class="table table-bordered table-hover text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nom & Prénoms</th>
                                        <th>Heure d’arrivée</th>
                                        <th>Heure de départ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($equipeActive as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="text-capitalize">{{ $item->nom . ' ' . $item->prenoms }}</td>
                                            <td>
                                                <input type="time" name="heure_arrivee[{{ $item->id }}]"
                                                    class="form-control shadow-sm" required>
                                            </td>
                                            <td>
                                                <input type="time" name="heure_depart[{{ $item->id }}]"
                                                    class="form-control shadow-sm" required>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <p class="text-muted fst-italic mb-0">Aucun employé dans cette équipe.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success px-5 py-2 rounded-pill shadow">
                                <i class="ri-check-double-line me-2"></i>Valider le pointage
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- JS pour DataTables -->
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
            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });
        });
    </script>
@endsection
