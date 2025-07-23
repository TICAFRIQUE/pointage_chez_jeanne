@extends('backend.layouts.master')

@section('title', 'Créer un employé')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center fs-5 fw-semibold rounded-top-4">
                    <i class="ri-user-add-line me-2"></i> Création d’un employé
                </div>
                <div class="card-body px-4 py-5 bg-light rounded-bottom-4">
                    <form class="row g-4 needs-validation" method="POST" action="{{ route('employes.store') }}" novalidate>
                        @csrf

                        <!-- Nom -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Nom</label>
                            <input type="text" name="nom" class="form-control form-control-lg rounded-3 shadow-sm"
                                required>
                            <div class="invalid-feedback">Veuillez saisir le nom.</div>
                        </div>

                        <!-- Prénoms -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Prénoms</label>
                            <input type="text" name="prenoms" class="form-control form-control-lg rounded-3 shadow-sm"
                                required>
                            <div class="invalid-feedback">Veuillez saisir les prénoms.</div>
                        </div>

                        <!-- Équipe -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">Équipe</label>
                            <select name="equipe_id" class="form-select form-select-lg rounded-3 shadow-sm" required>
                                <option value="" disabled selected>Choisir une équipe</option>
                                @foreach ($equipes as $equipe)
                                    <option value="{{ $equipe->id }}">
                                        {{ $equipe->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Veuillez choisir une équipe.</div>
                        </div>

                        <!-- Bouton -->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold rounded-3 shadow">
                                <i class="ri-check-line me-1"></i> Enregistrer l’employé
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
