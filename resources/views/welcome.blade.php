<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Sep 2023 03:03:35 GMT -->

<head>
    <!--  Title -->
    <title>Henkaten</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png"
        href="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" />
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href={{ asset('dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}>
    <link rel="stylesheet" href={{ asset('dist/libs/select2/dist/css/select2.min.css') }}>


    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href={{ asset('dist/css/style.min.css') }} />
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.partials.sidenav')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('layouts.partials.topnav')
            <!--  Header End -->
            <div class="container-fluid mw-100">
                <!--  Owl carousel -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card overflow-hidden">
                            <div class="card-body bg-danger text-white text-center p-10">
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
                    <div class="col-md-6">
                        <div class="card text-center overflow-hidden">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">Gunakan loto saat dandori</h4>
                                </div>
                            </div>
                            <h5 class="card-footer text-dark bg-white mt-3 mb-3">Tema Safety</h5>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="d-md-flex align-items-center mb-9">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab"
                                    aria-selected="true" tabindex="-1">
                                    <span>Shift 1</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab"
                                    aria-selected="false">
                                    <span>Shift 2</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span>Shift 3</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->

                        <div class="ms-auto mt-4 mt-md-0">
                            <button class="btn btn-light-info text-primary">Show All MP</button>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane p-3" id="home" role="tabpanel">
                            <div class="owl-carousel counter-carousel owl-theme">
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-primary shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-primary mb-1"> Employee 1</p>
                                                <h5 class="fw-semibold text-primary mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-warning shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-warning mb-1">Employee 2</p>
                                                <h5 class="fw-semibold text-warning mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-info shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-info mb-1">Employee 3</p>
                                                <h5 class="fw-semibold text-info mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-danger shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-danger mb-1">Employee 4</p>
                                                <h5 class="fw-semibold text-danger mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-success shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-success mb-1">Employee 5</p>
                                                <h5 class="fw-semibold text-success mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-info shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-info mb-1">Employee 6</p>
                                                <h5 class="fw-semibold text-info mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-3 active show" id="profile" role="tabpanel">
                            <div class="owl-carousel counter-carousel owl-theme">
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-primary shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-primary mb-1"> Employee 1</p>
                                                <h5 class="fw-semibold text-primary mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-warning shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-warning mb-1">Employee 2</p>
                                                <h5 class="fw-semibold text-warning mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-info shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-info mb-1">Employee 3</p>
                                                <h5 class="fw-semibold text-info mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-danger shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-danger mb-1">Employee 4</p>
                                                <h5 class="fw-semibold text-danger mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-success shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-success mb-1">Employee 5</p>
                                                <h5 class="fw-semibold text-success mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-info shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-info mb-1">Employee 6</p>
                                                <h5 class="fw-semibold text-info mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="messages" role="tabpanel">
                            <div class="owl-carousel counter-carousel owl-theme">
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-primary shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-primary mb-1">Employee 1</p>
                                                <h5 class="fw-semibold text-primary mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-warning shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-warning mb-1">Employee 2</p>
                                                <h5 class="fw-semibold text-warning mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-info shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-info mb-1">Employee 3</p>
                                                <h5 class="fw-semibold text-info mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-danger shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-danger mb-1">Employee 4</p>
                                                <h5 class="fw-semibold text-danger mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-success shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-success mb-1">Employee 5</p>
                                                <h5 class="fw-semibold text-success mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="card border-0 zoom-in bg-light-info shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                                                    width="50" height="50" class="mb-3" alt="" />
                                                <p class="fw-semibold fs-3 text-info mb-1">Employee 6</p>
                                                <h5 class="fw-semibold text-info mb-0">002484</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- line section -->
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12">
                        <div class="card bg-light-success shadow-none position-relative overflow-hidden">
                            <div class="card-body px-4 py-3">
                                <div class="row py-2">
                                    <div class="d-md-flex align-items-center mb-9">
                                        <div class="col-2">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#vertical-center-modal">
                                                DCAA01
                                            </button>
                                        </div>
                                        <div class="ms-auto mt-4 mt-md-0">
                                            <button type="button"
                                                class="justify-content-center w-100 btn mb-1 btn-rounded btn-warning d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#samedata-modal">
                                                <i class="ti ti-arrows-exchange fs-4 me-2"></i>
                                                Henkaten
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-danger">JP</span>
                                                    <h3 class="card-title mt-3">Jonatan Liandi</h3>
                                                    <h6 class="card-subtitle">002566</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-danger" style="width:100%">POS
                                                            1</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-warning">Operator</span>
                                                    <h3 class="card-title mt-3">Geger Geden</h3>
                                                    <h6 class="card-subtitle">002599</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-warning" style="width:100%">POS
                                                            2</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-success">Operator</span>
                                                    <h3 class="card-title mt-3">Pragos Susilo</h3>
                                                    <h6 class="card-subtitle">002833</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-12">
                                                        <button class="btn btn-success" style="width:100%">POS
                                                            3</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-xs-12">
                        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                            <div class="card-body px-4 py-3">
                                <div class="row py-2">
                                    <div class="d-md-flex align-items-center mb-9">
                                        <div class="col-2">
                                            <button class="btn btn-dark">PIC</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-dark">Leader</span>
                                                    <h3 class="card-title mt-3">Rudi Susilo</h3>
                                                    <h6 class="card-subtitle">002833</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-12">
                                                        <button class="btn btn-dark" style="width:100%">POS
                                                            3</button>
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
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12">
                        <div class="card bg-light-warning shadow-none position-relative overflow-hidden">
                            <div class="card-body px-4 py-3">
                                <div class="row py-2">
                                    <div class="d-md-flex align-items-center mb-9">
                                        <div class="col-2">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#vertical-center-modal">
                                                DCAA02
                                            </button>
                                        </div>
                                        <div class="ms-auto mt-4 mt-md-0">
                                            <button type="button"
                                                class="justify-content-center w-100 btn mb-1 btn-rounded btn-warning d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#samedata-modal">
                                                <i class="ti ti-arrows-exchange fs-4 me-2"></i>
                                                Henkaten
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-danger">JP</span>
                                                    <h3 class="card-title mt-3">Jonatan Liandi</h3>
                                                    <h6 class="card-subtitle">002566</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-danger" style="width:100%">POS
                                                            1</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-warning">Operator</span>
                                                    <h3 class="card-title mt-3">Geger Geden</h3>
                                                    <h6 class="card-subtitle">002599</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-warning" style="width:100%">POS
                                                            2</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-success">Operator</span>
                                                    <h3 class="card-title mt-3">Pragos Susilo</h3>
                                                    <h6 class="card-subtitle">002833</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-12">
                                                        <button class="btn btn-success" style="width:100%">POS
                                                            3</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-xs-12">
                        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                            <div class="card-body px-4 py-3">
                                <div class="row py-2">
                                    <div class="d-md-flex align-items-center mb-9">

                                        <div class="col-2">
                                            <button class="btn btn-dark">PIC</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-dark">Leader</span>
                                                    <h3 class="card-title mt-3">Rudi Susilo</h3>
                                                    <h6 class="card-subtitle">002833</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-12">
                                                        <button class="btn btn-dark" style="width:100%">POS
                                                            3</button>
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
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12">
                        <div class="card bg-light-danger shadow-none position-relative overflow-hidden">
                            <div class="card-body px-4 py-3">
                                <div class="row py-2">
                                    <div class="d-md-flex align-items-center mb-9">
                                        <div class="col-2">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#vertical-center-modal">
                                                DCAA03
                                            </button>
                                        </div>
                                        <div class="ms-auto mt-4 mt-md-0">
                                            <button type="button"
                                                class="justify-content-center w-100 btn mb-1 btn-rounded btn-warning d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#samedata-modal">
                                                <i class="ti ti-arrows-exchange fs-4 me-2"></i>
                                                Henkaten
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-danger">JP</span>
                                                    <h3 class="card-title mt-3">Jonatan Liandi</h3>
                                                    <h6 class="card-subtitle">002566</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-danger" style="width:100%">POS
                                                            1</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-warning">Operator</span>
                                                    <h3 class="card-title mt-3">Geger Geden</h3>
                                                    <h6 class="card-subtitle">002599</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-warning" style="width:100%">POS
                                                            2</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-success">Operator</span>
                                                    <h3 class="card-title mt-3">Pragos Susilo</h3>
                                                    <h6 class="card-subtitle">002833</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-12">
                                                        <button class="btn btn-success" style="width:100%">POS
                                                            3</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-xs-12">
                        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                            <div class="card-body px-4 py-3">
                                <div class="row py-2">
                                    <div class="d-md-flex align-items-center mb-9">

                                        <div class="col-2">
                                            <button class="btn btn-dark">PIC</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="../../dist/images/profile/user-1.jpg"
                                                    class="rounded-1 img-fluid" width="90">
                                                <div class="mt-n2">
                                                    <span class="badge bg-dark">Leader</span>
                                                    <h3 class="card-title mt-3">Rudi Susilo</h3>
                                                    <h6 class="card-subtitle">002833</h6>
                                                </div>
                                                <div class="row mt-3 justify-content-center">
                                                    <div class="col-12">
                                                        <button class="btn btn-dark" style="width:100%">POS
                                                            3</button>
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
        </div>
        <div class="dark-transparent sidebartoggler"></div>
        <div class="dark-transparent sidebartoggler"></div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="vertical-center-modal" tabindex="-1" aria-labelledby="vertical-center-modal"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Line Info
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="card-group mb-4">
                            <!-- Column -->
                            <div class="card bg-secondary">
                                <div class="card-body text-center text-white">
                                    <div class="p-3">
                                        <h2 class="text-white fs-7">7 Jam</h2>
                                        </h2>
                                        <h5 class="fw-light mt-3 text-white">Waktu Produksi</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <div class="card bg-info">
                                <div class="card-body text-center text-white">
                                    <div class="p-3">
                                        <h2 class="text-white fs-7">3</h2>
                                        </h2>
                                        <h5 class="fw-light mt-3 text-white">Jumlah MP</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    {{-- modal henkaten --}}
    <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="exampleModalLabel1">
                        Henkaten
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <label for="validationDefault01" class="mb-1">MP Before</label>
                                <select class="select2 form-control" style="width: 100%; height: 36px"
                                    id="select-on-modal">
                                    <option>-- Select MP --</option>
                                    <optgroup label="DCAA01">
                                        <option value="AK">Handika Gemink</option>
                                        <option value="HI">Rates Gamink</option>
                                    </optgroup>
                                    <optgroup label="DCAA02">
                                        <option value="CA">Fabian Gemink</option>
                                        <option value="NV">Rohmat Gemink</option>
                                    </optgroup>
                                    <optgroup label="DCAA03">
                                        <option value="AZ">Diki Gemink</option>
                                        <option value="CO">Alliq Gemink</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="col-12 mt-4">
                                <label for="validationDefault01" class="mb-1">MP After</label>
                                <select class="select2 form-control" style="width: 100%; height: 36px"
                                    id="select-on-modal2">
                                    <option>-- Select MP --</option>
                                    <optgroup label="DCAA01">
                                        <option value="AK">Handika Gemink</option>
                                        <option value="HI">Rates Gamink</option>
                                    </optgroup>
                                    <optgroup label="DCAA02">
                                        <option value="CA">Fabian Gemink</option>
                                        <option value="NV">Rohmat Gemink</option>
                                    </optgroup>
                                    <optgroup label="DCAA03">
                                        <option value="AZ">Diki Gemink</option>
                                        <option value="CO">Alliq Gemink</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger text-danger font-medium"
                        data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-success">
                        Save Henkaten
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of henkaten modal --}}

    <!--  Shopping Cart -->
    <div class="offcanvas offcanvas-end shopping-cart" tabindex="-1" id="offcanvasRight"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header py-4">
            <h5 class="offcanvas-title fs-5 fw-semibold" id="offcanvasRightLabel">Shopping Cart</h5>
            <span class="badge bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
        </div>
        <div class="offcanvas-body h-100 px-4 pt-0" data-simplebar>
            <ul class="mb-0">
                <li class="pb-7">
                    <div class="d-flex align-items-center">
                        <img src="../../dist/images/products/product-1.jpg" width="95" height="75"
                            class="rounded-1 me-9 flex-shrink-0" alt="" />
                        <div>
                            <h6 class="mb-1">Supreme toys cooker</h6>
                            <p class="mb-0 text-muted fs-2">Kitchenware Item</p>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <h6 class="fs-2 fw-semibold mb-0 text-muted">$250</h6>
                                <div class="input-group input-group-sm w-50">
                                    <button class="btn border-0 round-20 minus p-0 bg-light-success text-success "
                                        type="button" id="add1"> - </button>
                                    <input type="text"
                                        class="form-control round-20 bg-transparent text-muted fs-2 border-0  text-center qty"
                                        placeholder="" aria-label="Example text with button addon"
                                        aria-describedby="add1" value="1" />
                                    <button class="btn text-success bg-light-success  p-0 round-20 border-0 add"
                                        type="button" id="addo2"> + </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="pb-7">
                    <div class="d-flex align-items-center">
                        <img src="../../dist/images/products/product-2.jpg" width="95" height="75"
                            class="rounded-1 me-9 flex-shrink-0" alt="" />
                        <div>
                            <h6 class="mb-1">Supreme toys cooker</h6>
                            <p class="mb-0 text-muted fs-2">Kitchenware Item</p>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <h6 class="fs-2 fw-semibold mb-0 text-muted">$250</h6>
                                <div class="input-group input-group-sm w-50">
                                    <button class="btn border-0 round-20 minus p-0 bg-light-success text-success "
                                        type="button" id="add2"> - </button>
                                    <input type="text"
                                        class="form-control round-20 bg-transparent text-muted fs-2 border-0  text-center qty"
                                        placeholder="" aria-label="Example text with button addon"
                                        aria-describedby="add2" value="1" />
                                    <button class="btn text-success bg-light-success  p-0 round-20 border-0 add"
                                        type="button" id="addon34"> + </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="pb-7">
                    <div class="d-flex align-items-center">
                        <img src="../../dist/images/products/product-3.jpg" width="95" height="75"
                            class="rounded-1 me-9 flex-shrink-0" alt="" />
                        <div>
                            <h6 class="mb-1">Supreme toys cooker</h6>
                            <p class="mb-0 text-muted fs-2">Kitchenware Item</p>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <h6 class="fs-2 fw-semibold mb-0 text-muted">$250</h6>
                                <div class="input-group input-group-sm w-50">
                                    <button class="btn border-0 round-20 minus p-0 bg-light-success text-success "
                                        type="button" id="add3"> - </button>
                                    <input type="text"
                                        class="form-control round-20 bg-transparent text-muted fs-2 border-0  text-center qty"
                                        placeholder="" aria-label="Example text with button addon"
                                        aria-describedby="add3" value="1" />
                                    <button class="btn text-success bg-light-success  p-0 round-20 border-0 add"
                                        type="button" id="addon3"> + </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="align-bottom">
                <div class="d-flex align-items-center pb-7">
                    <span class="text-dark fs-3">Sub Total</span>
                    <div class="ms-auto">
                        <span class="text-dark fw-semibold fs-3">$2530</span>
                    </div>
                </div>
                <div class="d-flex align-items-center pb-7">
                    <span class="text-dark fs-3">Total</span>
                    <div class="ms-auto">
                        <span class="text-dark fw-semibold fs-3">$6830</span>
                    </div>
                </div>
                <a href="eco-checkout.html" class="btn btn-outline-primary w-100">Go to shopping cart</a>
            </div>
        </div>
    </div>

    <!--  Mobilenavbar -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <nav class="sidebar-nav scroll-sidebar">
            <div class="offcanvas-header justify-content-between">
                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
                    alt="" class="img-fluid">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body profile-dropdown mobile-navbar" data-simplebar="" data-simplebar>
                <ul id="sidebarnav">
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span>
                                <i class="ti ti-apps"></i>
                            </span>
                            <span class="hide-menu">Apps</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level my-3">
                            <li class="sidebar-item py-2">
                                <a href="#" class="d-flex align-items-center">
                                    <div
                                        class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-chat.svg"
                                            alt="" class="img-fluid" width="24" height="24">
                                    </div>
                                    <div class="d-inline-block">
                                        <h6 class="mb-1 bg-hover-primary">Chat Application</h6>
                                        <span class="fs-2 d-block fw-normal text-muted">New messages arrived</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item py-2">
                                <a href="#" class="d-flex align-items-center">
                                    <div
                                        class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-invoice.svg"
                                            alt="" class="img-fluid" width="24" height="24">
                                    </div>
                                    <div class="d-inline-block">
                                        <h6 class="mb-1 bg-hover-primary">Invoice App</h6>
                                        <span class="fs-2 d-block fw-normal text-muted">Get latest invoice</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item py-2">
                                <a href="#" class="d-flex align-items-center">
                                    <div
                                        class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-mobile.svg"
                                            alt="" class="img-fluid" width="24" height="24">
                                    </div>
                                    <div class="d-inline-block">
                                        <h6 class="mb-1 bg-hover-primary">Contact Application</h6>
                                        <span class="fs-2 d-block fw-normal text-muted">2 Unsaved Contacts</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item py-2">
                                <a href="#" class="d-flex align-items-center">
                                    <div
                                        class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-message-box.svg"
                                            alt="" class="img-fluid" width="24" height="24">
                                    </div>
                                    <div class="d-inline-block">
                                        <h6 class="mb-1 bg-hover-primary">Email App</h6>
                                        <span class="fs-2 d-block fw-normal text-muted">Get new emails</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item py-2">
                                <a href="#" class="d-flex align-items-center">
                                    <div
                                        class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-cart.svg"
                                            alt="" class="img-fluid" width="24" height="24">
                                    </div>
                                    <div class="d-inline-block">
                                        <h6 class="mb-1 bg-hover-primary">User Profile</h6>
                                        <span class="fs-2 d-block fw-normal text-muted">learn more information</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item py-2">
                                <a href="#" class="d-flex align-items-center">
                                    <div
                                        class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-date.svg"
                                            alt="" class="img-fluid" width="24" height="24">
                                    </div>
                                    <div class="d-inline-block">
                                        <h6 class="mb-1 bg-hover-primary">Calendar App</h6>
                                        <span class="fs-2 d-block fw-normal text-muted">Get dates</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item py-2">
                                <a href="#" class="d-flex align-items-center">
                                    <div
                                        class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-lifebuoy.svg"
                                            alt="" class="img-fluid" width="24" height="24">
                                    </div>
                                    <div class="d-inline-block">
                                        <h6 class="mb-1 bg-hover-primary">Contact List Table</h6>
                                        <span class="fs-2 d-block fw-normal text-muted">Add new contact</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item py-2">
                                <a href="#" class="d-flex align-items-center">
                                    <div
                                        class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-application.svg"
                                            alt="" class="img-fluid" width="24" height="24">
                                    </div>
                                    <div class="d-inline-block">
                                        <h6 class="mb-1 bg-hover-primary">Notes Application</h6>
                                        <span class="fs-2 d-block fw-normal text-muted">To-do and Daily tasks</span>
                                    </div>
                                </a>
                            </li>
                            <ul class="px-8 mt-7 mb-4">
                                <li class="sidebar-item mb-3">
                                    <h5 class="fs-5 fw-semibold">Quick Links</h5>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a class="fw-semibold text-dark" href="#">Pricing Page</a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a class="fw-semibold text-dark" href="#">Authentication Design</a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a class="fw-semibold text-dark" href="#">Register Now</a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a class="fw-semibold text-dark" href="#">404 Error Page</a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a class="fw-semibold text-dark" href="#">Notes App</a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a class="fw-semibold text-dark" href="#">User Application</a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a class="fw-semibold text-dark" href="#">Account Settings</a>
                                </li>
                            </ul>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="app-chat.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-message-dots"></i>
                            </span>
                            <span class="hide-menu">Chat</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="app-calendar.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-calendar"></i>
                            </span>
                            <span class="hide-menu">Calendar</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="app-email.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-mail"></i>
                            </span>
                            <span class="hide-menu">Email</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!--  Search Bar -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-1">
                <div class="modal-header border-bottom">
                    <input type="search" class="form-control fs-3" placeholder="Search here" id="search" />
                    <span data-bs-dismiss="modal" class="lh-1 cursor-pointer">
                        <i class="ti ti-x fs-5 ms-3"></i>
                    </span>
                </div>
                <div class="modal-body message-body" data-simplebar="">
                    <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
                    <ul class="list mb-0 py-2">
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Modern</span>
                                <span class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Dashboard</span>
                                <span class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Contacts</span>
                                <span class="fs-3 text-muted d-block">/apps/contacts</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Posts</span>
                                <span class="fs-3 text-muted d-block">/apps/blog/posts</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Detail</span>
                                <span
                                    class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Shop</span>
                                <span class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Modern</span>
                                <span class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Dashboard</span>
                                <span class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Contacts</span>
                                <span class="fs-3 text-muted d-block">/apps/contacts</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Posts</span>
                                <span class="fs-3 text-muted d-block">/apps/blog/posts</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Detail</span>
                                <span
                                    class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="#">
                                <span class="fs-3 text-black fw-normal d-block">Shop</span>
                                <span class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--  Customizer -->
    <!--  Import Js Files -->
    <script src={{ asset('dist/libs/jquery/dist/jquery.min.js') }}></script>
    <script src={{ asset('../../dist/libs/jquery-ui/dist/jquery-ui.min.js') }}></script>
    <script src={{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}></script>
    <script src={{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}></script>
    <!--  core files -->
    <script src={{ asset('dist/js/app.min.js') }}></script>
    <script src={{ asset('dist/js/app.init.js') }}></script>
    <script src={{ asset('dist/js/app-style-switcher.js') }}></script>
    <script src={{ asset('dist/js/sidebarmenu.js') }}></script>
    <script src={{ asset('dist/js/custom.js') }}></script>
    <!--  current page js files -->
    <script src={{ asset('dist/libs/owl.carousel/dist/owl.carousel.min.js') }}></script>
    <script src={{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}></script>
    <script src={{ asset('dist/js/dashboard.js') }}></script>
    <script src={{ asset('dist/libs/select2/dist/js/select2.full.min.js') }}></script>
    {{-- <script src={{ asset('dist/libs/select2/dist/js/select2.min.js') }}></script> --}}
    <script src={{ asset('dist/js/forms/select2.init.js') }}></script>
    <script>
        $('#select-on-modal , #select-on-modal2').select2({
            dropdownParent: $('#samedata-modal')
        });
    </script>


</body>

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Sep 2023 03:04:10 GMT -->

</html>
