@extends('backend.layouts.master')
@section('title')
    Parametre
@endsection
@section('content')
    {{-- <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ URL::asset('build/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">
            <div class="overlay-content">
                <div class="text-end p-3">
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <input id="profile-foreground-img-file-input" type="file"
                            class="profile-foreground-img-file-input">
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                            <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid black;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        a {
            text-decoration: none;
            color: blue;
        }
    </style>

    <div class="row">
        <div class="col-xxl-12  mt-5">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i> Informations du site
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                <i class="far fa-envelope"></i> Application
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#backup" role="tab">
                                <i class="far fa-envelope"></i> Backups
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="{{ route('parametre.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <!-- ========== Start Section ========== -->
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="background-image">Image d'arrière-plan</label>
                                            <input type="file" id="background-image" name="cover" class="form-control"
                                                accept="image/*">
                                            <div class="mt-2">
                                                <img id="background-preview"
                                                    src="{{ $data_parametre ? URL::asset($data_parametre->getFirstMediaUrl('cover')) : URL::asset('images/camera-icon.png') }}"
                                                    class="rounded-circle avatar-xl img-thumbnail"
                                                    alt="Aperçu de l'arrière-plan">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="logo-header">Logo d'en-tête</label>
                                            <input type="file" id="logo-header" name="logo_header" class="form-control"
                                                accept="image/*">
                                            <div class="mt-2 text-center">
                                                <img id="header-preview"
                                                    src="{{ $data_parametre ? URL::asset($data_parametre->getFirstMediaUrl('logo_header')) : URL::asset('images/camera-icon.png') }}"
                                                    class="rounded-circle avatar-xl img-thumbnail"
                                                    alt="Aperçu du logo d'en-tête">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="logo-footer">Logo de pied de page</label>
                                            <input type="file" id="logo-footer" name="logo_footer" class="form-control"
                                                accept="image/*">
                                            <div class="mt-2 text-center">
                                                <img id="footer-preview"
                                                    src="{{ $data_parametre ? URL::asset($data_parametre->getFirstMediaUrl('logo_footer')) : URL::asset('images/camera-icon.png') }}"
                                                    class="rounded-circle avatar-xl img-thumbnail"
                                                    alt="Aperçu du logo de pied de page">
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function previewImage(input, previewId) {
                                            if (input.files && input.files[0]) {
                                                var reader = new FileReader();

                                                reader.onload = function(e) {
                                                    document.getElementById(previewId).src = e.target.result;
                                                }

                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        }

                                        document.getElementById('background-image').addEventListener('change', function() {
                                            previewImage(this, 'background-preview');
                                        });

                                        document.getElementById('logo-header').addEventListener('change', function() {
                                            previewImage(this, 'header-preview');
                                        });

                                        document.getElementById('logo-footer').addEventListener('change', function() {
                                            previewImage(this, 'footer-preview');
                                        });
                                    </script>
                                    <!-- ========== End Section ========== -->
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Nom du projet</label>
                                            <input type="text" name="nom_projet" class="form-control" id="emailInput"
                                                value="{{ $data_parametre['nom_projet'] ?? '' }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-7">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Description du projet</label>
                                            <input type="text" name="description_projet" class="form-control"
                                                id="emailInput" value="{{ $data_parametre['description_projet'] ?? '' }}">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Telephone1</label>
                                            <input type="text" name="contact1" class="form-control" id="phonenumberInput"
                                                value="{{ $data_parametre['contact1'] ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Telephone2</label>
                                            <input type="text" name="contact2" class="form-control"
                                                id="phonenumberInput" value="{{ $data_parametre['contact2'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Telephone3</label>
                                            <input type="text" name="contact3" class="form-control"
                                                id="phonenumberInput" value="{{ $data_parametre['contact3'] ?? '' }}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Email 1</label>
                                            <input type="email" name="email1" class="form-control" id="emailInput"
                                                value="{{ $data_parametre['email1'] ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Email 2</label>
                                            <input type="email" name="email2" class="form-control" id="emailInput"
                                                value="{{ $data_parametre['email2'] ?? '' }}">
                                        </div>
                                    </div>
                                    <!--end col-->


                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="countryInput" class="form-label">Siège social</label>
                                            <input type="text" name="siege_social" class="form-control"
                                                id="countryInput" value="{{ $data_parametre['siege_social'] ?? '' }}" />
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="countryInput" class="form-label">Localisation</label>
                                            <input type="text" name="localisation" class="form-control"
                                                id="countryInput" value="{{ $data_parametre['localisation'] ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="countryInput" class="form-label">Google maps</label>
                                            <input type="text" name="google_maps" class="form-control"
                                                id="countryInput" value="{{ $data_parametre['google_maps'] ?? '' }}" />
                                        </div>
                                    </div>

                                    <!--end col-->




                                    <!-- ========== Start social network ========== -->
                                    <div class="row mt-4">
                                        <div class="mb-3 d-flex">
                                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                <span class="avatar-title rounded-circle fs-16 bg-primary material-shadow">
                                                    <i class=" ri-facebook-fill"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="lien_facebook" class="form-control"
                                                id="websiteInput" value="{{ $data_parametre['lien_facebook'] ?? '' }}">
                                        </div>
                                        <div class="mb-3 d-flex">
                                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                <span class="avatar-title rounded-circle fs-16 bg-primary material-shadow">
                                                    <i class=" ri-instagram-fill"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="lien_instagram" class="form-control"
                                                id="websiteInput" value="{{ $data_parametre['lien_instagram'] ?? '' }}">
                                        </div>

                                        <div class=" mb-3 d-flex">
                                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                <span class="avatar-title rounded-circle fs-16 bg-danger material-shadow">
                                                    <i class=" ri-tiktok-fill"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="lien_twitter" class="form-control"
                                                id="pinterestName" value="{{ $data_parametre['lien_twitter'] ?? '' }}">
                                        </div>
                                        <div class="mb-3 d-flex">
                                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                <span class="avatar-title rounded-circle fs-16 bg-danger material-shadow">
                                                    <i class=" ri-linkedin-line"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="lien_linkedin" class="form-control"
                                                id="pinterestName" value="{{ $data_parametre['lien_linkedin'] ?? '' }}">
                                        </div>

                                        <div class="mb-3 d-flex">
                                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                <span class="avatar-title rounded-circle fs-16 bg-danger material-shadow">
                                                    <i class=" ri-twitter-x-fill"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="lien_tiktok" class="form-control"
                                                id="pinterestName" value="{{ $data_parametre['lien_tiktok'] ?? '' }}">
                                        </div>
                                    </div>
                                    <!-- ========== End social network ========== -->


                                    <div class="col-lg-12">
                                        <div class="hstack mt-3">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="ri-refresh-line align-bottom me-1"></i>
                                                Mettre à jour</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>

                            </form>
                        </div>
                        <!--end tab-pane-->


                        <div class="tab-pane" id="privacy" role="tabpanel">
                            <div class="mb-4 pb-2">
                                {{-- <h5 class="card-title text-decoration-underline mb-3">Security:</h5> --}}

                                <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                                    <input type="text" name="type_clear" value="cache" hidden>
                                    <div class="flex-grow-1">
                                        <h6 class="fs-14 mb-1">Cache systeme</h6>
                                        <p class="text-muted">En cliquant sur vider le cache vous allez supprimer les
                                            fichier temporaires stockés en memoire</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-sm-3">
                                        <a href="#" class="btn btn-sm btn-primary btn-clear">Vider
                                            le
                                            cache</a>
                                    </div>
                                </div>



                            </div>
                            <div class="mb-3">
                                {{-- <h5 class="card-title text-decoration-underline mb-3">Application </h5> --}}
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex">
                                        <div class="flex-grow-1">
                                            <label for="directMessage" class="form-check-label fs-14">Maintenance
                                                mode</label>
                                            <p class="text-muted">Mettre l'application en mode maintenance</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            @if (empty($data_parametre->mode_maintenance) || $data_parametre->mode_maintenance == 'up')
                                                <div class="form-check form-switch">
                                                    <a href="#"
                                                        class="btn btn-sm btn-primary btn-mode-down">Activer</a>
                                                </div>
                                            @else
                                                <div class="form-check form-switch">
                                                    <a href="#"
                                                        class="btn btn-sm btn-primary btn-mode-up">Désactiver</a>
                                                </div>
                                            @endif

                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <!--end tab-pane-->

                        <div class="tab-pane" id="backup" role="tabpanel">
                            <div class="mb-3">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nom du fichier</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($backup as $file)
                                            <tr>
                                                <td>{{ basename($file) }}</td>
                                                <td>
                                                    <a href="{{ route('setting.download-backup', basename($file)) }}">Télécharger
                                                        <i class="ri-download-line align-bottom"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {

            //cache clear
            $('.btn-clear').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ route('parametre.optimize-clear') }}",
                    // data: "data",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            let timerInterval;
                            Swal.fire({
                                title: "Traitement en cour!",
                                html: "Se termine dans <b></b> milliseconds.",
                                timer: 6000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const timer = Swal.getPopup().querySelector(
                                        "b");
                                    timerInterval = setInterval(() => {
                                        timer.textContent =
                                            `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Application optimisé avec succès",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            });
                        }
                    }
                });
            });

            // maintenance mode down
            $('.btn-mode-down').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ route('parametre.maintenance-down') }}",
                    // data: "data",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Mode maintenance activé",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('btn-mode-up').html('désactivé');
                            location.reload(true);
                        }
                    }
                });
            });

            // maintenance mode up
            $('.btn-mode-up').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ route('parametre.maintenance-up') }}",
                    // data: "data",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Mode maintenance desactivé",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            location.reload(true);
                        }
                    }
                });
            });


        });
    </script>
@endsection
