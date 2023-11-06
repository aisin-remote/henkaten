@extends('layouts.root.main')

@section('main')
    <div class="col-lg-6 col-md-12 col-12">
        <div class="card shadow-md card-hover">
            <div class="card-body p-3 d-flex align-items-center gap-3" id="themeContainer">
                <div>
                    <h5 class="fw-semibold mb-0">Periode Planning</h5>
                    <span class="fs-2 d-flex align-items-center py-1 d-inline">{{ Carbon\Carbon::now()->format('l, j F Y') }}
                        <span id="time" class="fs-2 px-2"></span></span>
                </div>

                <button type="button" class="btn btn-secondary py-2 px-5 ms-auto" data-bs-toggle="modal"
                    data-bs-target="#modalTheme" style="border: 3px none #686868">
                    <h4 class="fw-bolder pt-1" style="color: white">
                        {{ Carbon\Carbon::now()->format('l, j F Y') }}
                    </h4>
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-fill mt-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#navpill-111" role="tab"
                            aria-selected="true">
                            <span style="font-weight: bolder">Shift 1</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content border mt-3">
                    <div class="tab-pane active p-3" id="navpill-111" role="tabpanel">
                        <div class="owl-carousel counter-carousel owl-theme">
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-primary shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-primary mb-1 mt-3"> Employee 1</p>
                                            <h5 class="fw-semibold text-primary mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-warning shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-warning mb-1 mt-3">Employee 2</p>
                                            <h5 class="fw-semibold text-warning mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-info shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-info mb-1 mt-3">Employee 3</p>
                                            <h5 class="fw-semibold text-info mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-danger shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-danger mb-1 mt-3">Employee 4</p>
                                            <h5 class="fw-semibold text-danger mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-success shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-success mb-1 mt-3">Employee 5</p>
                                            <h5 class="fw-semibold text-success mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-info shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-info mb-1 mt-3">Employee 6</p>
                                            <h5 class="fw-semibold text-info mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-pills nav-fill mt-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#navpill-111" role="tab"
                            aria-selected="true">
                            <span style="font-weight: bolder">Shift 2</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content border mt-3">
                    <div class="tab-pane active p-3" id="navpill-111" role="tabpanel">
                        <div class="owl-carousel counter-carousel owl-theme">
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-primary shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-primary mb-1 mt-3"> Employee 1</p>
                                            <h5 class="fw-semibold text-primary mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-warning shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-warning mb-1 mt-3">Employee 2</p>
                                            <h5 class="fw-semibold text-warning mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-info shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-info mb-1 mt-3">Employee 3</p>
                                            <h5 class="fw-semibold text-info mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-danger shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-danger mb-1 mt-3">Employee 4</p>
                                            <h5 class="fw-semibold text-danger mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-success shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-success mb-1 mt-3">Employee 5</p>
                                            <h5 class="fw-semibold text-success mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card border-0 zoom-in bg-light-info shadow-none">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                alt="" class="rounded" width="100" height="100">
                                            <p class="fw-semibold fs-3 text-info mb-1 mt-3">Employee 6</p>
                                            <h5 class="fw-semibold text-info mb-0">002484</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-pills nav-fill mt-4" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#navpill-111" role="tab"
                                aria-selected="true">
                                <span style="font-weight: bolder">Shift 3</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content border mt-3">
                        <div class="tab-pane active p-3" id="navpill-111" role="tabpanel">
                            <div class="owl-carousel counter-carousel owl-theme">
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-primary shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                    alt="" class="rounded" width="100" height="100">
                                                <p class="fw-semibold fs-3 text-primary mb-1 mt-3"> Employee 1</p>
                                                <h5 class="fw-semibold text-primary mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-warning shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                    alt="" class="rounded" width="100" height="100">
                                                <p class="fw-semibold fs-3 text-warning mb-1 mt-3">Employee 2</p>
                                                <h5 class="fw-semibold text-warning mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-info shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                    alt="" class="rounded" width="100" height="100">
                                                <p class="fw-semibold fs-3 text-info mb-1 mt-3">Employee 3</p>
                                                <h5 class="fw-semibold text-info mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-danger shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                    alt="" class="rounded" width="100" height="100">
                                                <p class="fw-semibold fs-3 text-danger mb-1 mt-3">Employee 4</p>
                                                <h5 class="fw-semibold text-danger mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-success shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                    alt="" class="rounded" width="100" height="100">
                                                <p class="fw-semibold fs-3 text-success mb-1 mt-3">Employee 5</p>
                                                <h5 class="fw-semibold text-success mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-info shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{ asset('uploads/doc/1698069774-WhatsApp Image 2023-10-18 at 2.18.28 PM.jpeg') }}"
                                                    alt="" class="rounded" width="100" height="100">
                                                <p class="fw-semibold fs-3 text-info mb-1 mt-3">Employee 6</p>
                                                <h5 class="fw-semibold text-info mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="navpill-222" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <p>
                                        Raw denim you probably haven't heard of them jean
                                        shorts Austin. Nesciunt tofu stumptown aliqua,
                                        retro synth master cleanse. Mustache cliche
                                        tempor, williamsburg carles vegan helvetica.
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <img src="../../dist/images/big/img1.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="navpill-333" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="../../dist/images/big/img3.jpg" alt="" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <p>
                                        Raw denim you probably haven't heard of them jean
                                        shorts Austin. Nesciunt tofu stumptown aliqua,
                                        retro synth master cleanse. Mustache cliche
                                        tempor, williamsburg carles vegan helvetica.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
