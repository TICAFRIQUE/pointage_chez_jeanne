@extends('backend.layouts.master')

@section('title')
    Équipes
@endsection

@section('css')
    <!-- Bootstrap + DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
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

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Liste des équipes</h5>
                </div>

                @if (session('success_message'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        {{ session('success_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif

                <div class="card-body bg-light rounded-bottom py-4">
                    <h5 class="text-center mb-4 fw-semibold text-uppercase text-primary">
                        <i class="bi bi-list-ul me-2"></i>Sélectionnez une équipe
                    </h5>

                    <div class="d-flex justify-content-center flex-wrap gap-3 px-2">
                        @forelse($equipe as $item)
                            <a href="{{ route('pointages.equipeActive', ['id' => $item->id]) }}"
                                class="btn btn-outline-primary px-4 py-2 fw-semibold rounded-pill shadow-sm d-flex align-items-center gap-2">
                                <i class="bi bi-person-bounding-box"></i> {{ $item->nom }}
                            </a>
                        @empty
                            <div class="text-center w-100">
                                <p class="text-muted fst-italic">Aucune équipe disponible. Veuillez en créer une.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- jQuery + DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#buttons-datatables')) {
                $('#buttons-datatables').DataTable().destroy();
            }

            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                drawCallback: function(settings) {
                    let route = "employe";
                    delete_row(route);
                }
            });
        });
    </script>
@endsection
