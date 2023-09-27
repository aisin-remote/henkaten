@extends('layouts.root.main')

@section('main')
<!--  Owl carousel -->
<!-- <div class="row" style="margin-top: -50px">
        <div class="col-lg-6 col-md-12 col-12">
            <div class="card overflow-hidden">
                <div class="d-flex flex-row">
                    <div class="p-3">
                        <h5 class="text-info mb-1 fs-6">Theme</h5>
                        <span class="text-muted">21 September 2023</span>
                    </div>
                    <div class="p-3 pt-4 px-5 bg-light-secondary ms-auto">
                        <h3 class="text-info box mb-0 fw-bolder">
                            Gunakan Loto saat Dandori
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

<!-- Vertical Carousel -->
<div class="vertical-carousel">
    <div class="carousel-item">Item 1</div>
    <div class="carousel-item">Item 2</div>
    <div class="carousel-item">Item 3</div>
    <!-- Tambahkan lebih banyak item jika diperlukan -->
</div>

<!-- 
<div class="row">
    <div class="col-md-12 col-lg-4">
        <div class="card overflow-hidden shadow card-hover">
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
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MEN</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MACHINE</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">METHOD</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="mb-2">MATERIAL</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card overflow-hidden shadow card-hover">
            <div class="card-body bg-info text-white text-center p-10">
                <div class="d-inline-block">
                    <h3 class="text-light fw-bolder">DCAA02</h3>
                </div>
            </div>
            <div class="card-body bg-warning text-white text-center p-1 pt-2">
                <div class="d-inline-block">
                    <h4 class="text-light fw-bold">HENKATEN</h4>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="row">
                    <div class="col-12">
                        <div class="row text-center">
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MEN</div>
                                <i class="ti ti-triangle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MACHINE</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">METHOD</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="mb-2">MATERIAL</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card overflow-hidden shadow card-hover">
            <div class="card-body bg-info text-white text-center p-10">
                <div class="d-inline-block">
                    <h3 class="text-light fw-bolder">DCAA03</h3>
                </div>
            </div>
            <div class="card-body bg-danger text-white text-center p-1 pt-2">
                <div class="d-inline-block">
                    <h4 class="text-light fw-bold">STOP</h4>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="row">
                    <div class="col-12">
                        <div class="row text-center">
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MEN</div>
                                <i class="ti ti-triangle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MACHINE</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">METHOD</div>
                                <i class="ti ti-x fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="mb-2">MATERIAL</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card overflow-hidden shadow card-hover">
            <div class="card-body bg-info text-white text-center p-10">
                <div class="d-inline-block">
                    <h3 class="text-light fw-bolder">DCAA04</h3>
                </div>
            </div>
            <div class="card-body bg-danger text-white text-center p-1 pt-2">
                <div class="d-inline-block">
                    <h4 class="text-light fw-bold">STOP</h4>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="row">
                    <div class="col-12">
                        <div class="row text-center">
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MEN</div>
                                <i class="ti ti-triangle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MACHINE</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">METHOD</div>
                                <i class="ti ti-x fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="mb-2">MATERIAL</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card overflow-hidden shadow card-hover">
            <div class="card-body bg-info text-white text-center p-10">
                <div class="d-inline-block">
                    <h3 class="text-light fw-bolder">DCAA05</h3>
                </div>
            </div>
            <div class="card-body bg-warning text-white text-center p-1 pt-2">
                <div class="d-inline-block">
                    <h4 class="text-light fw-bold">HENKATEN</h4>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="row">
                    <div class="col-12">
                        <div class="row text-center">
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MEN</div>
                                <i class="ti ti-triangle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MACHINE</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">METHOD</div>
                                <i class="ti ti-triangle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="mb-2">MATERIAL</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card overflow-hidden shadow card-hover">
            <div class="card-body bg-info text-white text-center p-10">
                <div class="d-inline-block">
                    <h3 class="text-light fw-bolder">DCAA06</h3>
                </div>
            </div>
            <div class="card-body bg-danger text-white text-center p-1 pt-2">
                <div class="d-inline-block">
                    <h4 class="text-light fw-bold">STOP</h4>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="row">
                    <div class="col-12">
                        <div class="row text-center">
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MEN</div>
                                <i class="ti ti-triangle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MACHINE</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">METHOD</div>
                                <i class="ti ti-x fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="mb-2">MATERIAL</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card overflow-hidden shadow card-hover">
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
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MEN</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MACHINE</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">METHOD</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="mb-2">MATERIAL</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4" id="dc8">
        <div class="card overflow-hidden shadow card-hover">
            <div class="card-body bg-info text-white text-center p-10">
                <div class="d-inline-block">
                    <h3 class="text-light fw-bolder">DCAA08</h3>
                </div>
            </div>
            <div class="card-body bg-danger text-white text-center p-1 pt-2">
                <div class="d-inline-block">
                    <h4 class="text-light fw-bold">STOP</h4>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="row">
                    <div class="col-12">
                        <div class="row text-center">
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MEN</div>
                                <i class="ti ti-x fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">MACHINE</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <div class="mb-2">METHOD</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="mb-2">MATERIAL</div>
                                <i class="ti ti-circle fs-7 mb-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection