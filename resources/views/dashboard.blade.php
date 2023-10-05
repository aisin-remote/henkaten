@extends('layouts.root.main')

@section('main')
    <div class="row" style="margin-top: -30px">
        <div class="col-lg-6 col-md-12 col-12">
            <div class="card shadow-md card-hover">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div>
                        <h5 class="fw-semibold mb-0">Tema Safety</h5>
                        <span class="fs-2 d-flex align-items-center py-1">Tuesday, 26 September 2023</span>
                    </div>
                    <button class="btn btn-secondary py-2 px-5 ms-auto">
                        <h4 class=" fw-bolder text-light pt-1">
                            Gunakan Loto saat Dandori
                        </h4>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-12">
            <div class="card shadow-md card-hover">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <img src="../../dist/images/profile/saiful.png" alt="" class="rounded-circle" width="60"
                        height="60">
                    <div>
                        <h5 class="fw-semibold mb-0">Saiful</h5>
                        <span class="fs-2 d-flex align-items-center py-1"><i
                                class="ti ti-map-pin text-dark fs-3 me-1"></i>000877</span>
                    </div>
                    <button class="btn btn-dark py-1 px-3 ms-auto">Leader</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-12">
            <div class="card shadow-md card-hover">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <img src="../../dist/images/profile/syarief.png" alt="" class="rounded-circle" width="60"
                        height="60">
                    <div>
                        <h5 class="fw-semibold mb-0">Syarief</h5>
                        <span class="fs-2 d-flex align-items-center py-1"><i
                                class="ti ti-map-pin text-dark fs-3 me-1"></i>000871</span>
                    </div>
                    <button class="btn btn-warning py-1 px-3 ms-auto">JP</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="text-white">
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-4 py-4">
                                    <div class="card-body p-3 d-flex align-items-center gap-3">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h1 class="fw-bolder text-left"
                                                    style="font-size: 5em; display:block; font-weight:900 !important">ALL
                                                    LINE DIE
                                                    CASTING
                                                </h1>
                                            </div>
                                            <div class="col-lg-4">
                                                <img src="{{ asset('assets/images/running.svg') }}" class="dark-logo"
                                                    width="180" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="card overflow-hidden card-hover">
                                    <div class="card-body bg-white text-center text-muted p-10">
                                        <div class="p-30">
                                            <img src="{{ asset('assets/images/running-medium.svg') }}" class="dark-logo"
                                                width="180" alt="" />
                                        </div>
                                    </div>
                                    <div class="card-footer text-white bg-success p-30">
                                        <div class=" no-block align-items-center">
                                            <div class="text-center">
                                                <h3 class="font-weight-medium text-white fs-6">
                                                    MAN
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card overflow-hidden card-hover">
                                    <div class="card-body bg-white text-center text-muted p-10">
                                        <div class="p-30">
                                            <img src="{{ asset('assets/images/running-medium.svg') }}" class="dark-logo"
                                                width="180" alt="" />
                                        </div>
                                    </div>
                                    <div class="card-footer text-white bg-success p-30">
                                        <div class=" no-block align-items-center">
                                            <div class="text-center">
                                                <h3 class="font-weight-medium text-white fs-6">
                                                    METHOD
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card overflow-hidden card-hover">
                                    <div class="card-body bg-white text-center text-muted p-10">
                                        <div class="p-30">
                                            <img src="{{ asset('assets/images/running-medium.svg') }}" class="dark-logo"
                                                width="180" alt="" />
                                        </div>
                                    </div>
                                    <div class="card-footer text-white bg-success p-30">
                                        <div class=" no-block align-items-center">
                                            <div class="text-center">
                                                <h3 class="font-weight-medium text-white fs-6">
                                                    MACHINE
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card overflow-hidden card-hover">
                                    <div class="card-body bg-white text-center text-muted p-10">
                                        <div class="p-30">
                                            <img src="{{ asset('assets/images/running-medium.svg') }}" class="dark-logo"
                                                width="180" alt="" />
                                        </div>
                                    </div>
                                    <div class="card-footer text-white bg-success p-30">
                                        <div class=" no-block align-items-center">
                                            <div class="text-center">
                                                <h3 class="font-weight-medium text-white fs-6">
                                                    MATERIAL
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-4 py-4">
                                    <div class="card-body p-3 align-items-center text-center">
                                        <h1 class="fw-bolder"
                                            style="font-size: 5em; display:block; font-weight:900 !important">
                                            NO HENKATEN
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="row vertical-carousel">
                <div class="carousel-inner">
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc1">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA01</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc2">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA02</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc3">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA03</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc4">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA04</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc5">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA05</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc6">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA06</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc7">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA07</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc8">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA08</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#dc6, #dc7, #dc8, #dc1, #dc2, #dc3, #dc4, #dc5').on('click', function() {
            window.location.replace("{{ url('/line') }}");
        })
    })
</script>
