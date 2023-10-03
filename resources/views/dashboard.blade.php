@extends('layouts.root.main')

@section('main')
    <div class="row" style="margin-top: -30px">
        <!--  Owl carousel -->
        <!-- <div class="row" style="margin-top: -50px">
                    >>>>>>> a57ac048d5dd848c5f5309ddb49f2d0885761331
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
                                        <img src="../../dist/images/profile/user-1.jpg" alt="" class="rounded-circle" width="40"
                                            height="40">
                                        <div>
                                            <h5 class="fw-semibold mb-0">Pragos Adams</h5>
                                            <span class="fs-2 d-flex align-items-center py-1"><i
                                                    class="ti ti-map-pin text-dark fs-3 me-1"></i>000877</span>
                                        </div>
                                        <button class="btn btn-danger py-1 px-3 ms-auto">Leader</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card shadow-md card-hover">
                                    <div class="card-body p-3 d-flex align-items-center gap-3">
                                        <img src="../../dist/images/profile/user-1.jpg" alt="" class="rounded-circle" width="40"
                                            height="40">
                                        <div>
                                            <h5 class="fw-semibold mb-0">Pragos Jamal</h5>
                                            <span class="fs-2 d-flex align-items-center py-1"><i
                                                    class="ti ti-map-pin text-dark fs-3 me-1"></i>000871</span>
                                        </div>
                                        <button class="btn btn-warning py-1 px-3 ms-auto">JP</button>
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
