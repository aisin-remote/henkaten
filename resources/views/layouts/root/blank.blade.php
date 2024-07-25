<!DOCTYPE html>
<html lang="en">


<head>
    <!--  Title -->
    <title>Digital Henkaten</title>
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
    <link rel="shortcut icon" type="image/png" href={{ asset('images/favicon.ico') }} />
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href={{ asset('dist/css/style.min.css') }} />
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src={{ asset('images/favicon.ico') }} alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-lg-9">
                        @yield('main')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Import Js Files -->
    <script src={{ asset('dist/libs/jquery/dist/jquery.min.js') }}></script>
    <script src={{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}></script>
    <script src={{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}></script>
    <!--  core files -->
    <script src={{ asset('dist/js/app.min.js') }}></script>
    <script src={{ asset('dist/js/app-style-switcher.js') }}></script>
    <script src={{ asset('dist/js/sidebarmenu.js') }}></script>

    <script src={{ asset('dist/js/custom.js') }}></script>
</body>

</html>
