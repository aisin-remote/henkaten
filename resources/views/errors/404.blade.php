<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/horizontal/authentication-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Sep 2023 00:46:43 GMT -->

<head>
    <!-- Title -->
    <title>Mordenize</title>
    <!-- Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png"
        href="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" />
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href={{ asset('dist/css/style.min.css') }} />
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="horizontal" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-lg-4">
                        <div class="text-center">
                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/errorimg.svg"
                                alt="" class="img-fluid" width="500">
                            <h1 class="fw-semibold mb-7 fs-9">Opps!!!</h1>
                            <h4 class="fw-semibold mb-7">This page you are looking for could not be found.</h4>
                            <a class="btn btn-primary" href="{{ route('dashboard.index') }}" role="button">Go Back to
                                Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Js Files -->
    <script src={{ asset('dist/libs/jquery/dist/jquery.min.js') }}></script>
    <script src={{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}></script>
    <script src={{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}></script>
    <!-- core files -->
    <script src={{ asset('dist/js/app.min.js') }}></script>
    <script src={{ asset('dist/js/app.horizontal.init.js') }}></script>
    <script src={{ asset('dist/js/app-style-switcher.js') }}></script>
    <script src={{ asset('dist/js/sidebarmenu.js') }}></script>

    <script src={{ asset('dist/js/custom.js') }}></script>
</body>

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/horizontal/authentication-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Sep 2023 00:46:43 GMT -->

</html>
