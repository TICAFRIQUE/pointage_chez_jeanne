<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0 font-size-18">
                @if ($previousUrl = url()->previous())
                    <a href="#" class="btn btn-primary" id="goBack"> <i class="ri ri-arrow-left-fill"></i>
                        Retour</a>
                @endif
                {{ $title }}
            </h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $li_1 }}</a></li>
                    @if (isset($title))
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>
<script>
    // go to back
    // document.getElementById('goBack').addEventListener('click', function() {
    //     window.history.back();
    //     setTimeout(function() {
    //         location.reload();
    //     }, 500);
    // });
    document.getElementById('goBack').addEventListener('click', function() {
        window.location.href = document.referrer;
    });
</script>
<!-- end page title -->
