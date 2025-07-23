@extends('backend.layouts.master')

@section('title', 'Modifier une équipe')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-warning text-dark text-center fs-5 fw-semibold rounded-top-4">
                    <i class="ri-edit-2-line me-2"></i> Modifier une équipe
                </div>
                <div class="card-body px-4 py-5 bg-light rounded-bottom-4">
                    <form class="row g-4 needs-validation" method="POST" action="{{ route('equipes.store') }}" novalidate>
                        @csrf
                        <!-- Nom de l'équipe -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">Nom de l’équipe</label>
                            <input type="text" name="nom" class="form-control form-control-lg rounded-3 shadow-sm"
                                required>
                            <div class="invalid-feedback">Veuillez saisir le nom de l’équipe.</div>
                        </div>

                        <!-- Heure de début -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Heure de début</label>
                            <input type="time" name="heure_debut"
                                class="form-control form-control-lg rounded-3 shadow-sm" required>
                            <div class="invalid-feedback">Veuillez indiquer l’heure de début.</div>
                        </div>

                        <!-- Heure de fin -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Heure de fin</label>
                            <input type="time" name="heure_fin" class="form-control form-control-lg rounded-3 shadow-sm"
                                required>
                            <div class="invalid-feedback">Veuillez indiquer l’heure de fin.</div>
                        </div>

                        <!-- Bouton -->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-3 shadow">
                                <i class="ri-save-line me-1"></i> Enregistrer l’équipe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
