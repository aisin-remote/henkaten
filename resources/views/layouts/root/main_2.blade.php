<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>Digital Henkaten</title>
    <!-- Required Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.ico') }}" />
    <!-- Owl Carousel -->
    {{-- <link rel="stylesheet" href={{ asset('dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}> --}}
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href={{ asset('dist/css/style.min.css') }} />
    <script src="{{ asset('js/highcharts.js') }}"></script>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('images/favicon.ico') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="horizontal" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Header Start -->
        <header class="app-header">
            <nav class="navbar navbar-expand-xl navbar-light container-fluid px-5 mw-100">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler ms-n3" id="sidebarCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-xl-block">
                        <a href="#" class="text-nowrap nav-link">
                            <img src="{{ asset('assets/images/henkaten-logo.svg') }}" class="dark-logo" width="180"
                                alt="" />
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav quick-links d-none d-xl-flex">
                    <span class="badge bg-warning fw-bolder px-4 py-2" id="shift">Shift 1</span>
                </ul>
                <div class="d-block d-xl-none">
                    <a href="index.html" class="text-nowrap nav-link">
                        <img src="{{ asset('assets/images/henkaten-logo.svg') }}" class="dark-logo" width="180"
                            alt="" />
                    </a>
                </div>
                <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="p-2">
                        <i class="ti ti-dots fs-7"></i>
                    </span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                        <a href="javascript:void(0)"
                            class="nav-link round-40 p-1 ps-0 d-flex d-xl-none align-items-center justify-content-center"
                            type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                            aria-controls="offcanvasWithBothOptions">
                            <i class="ti ti-align-justified fs-7"></i>
                        </a>
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link pe-0" href="javascript:void(0)" id="drop1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="user-profile-img">
                                            <img src="{{ asset('dist/images/profile/' . auth()->user()->photo) }}"
                                                class="rounded-circle" width="35" height="35" alt="" />
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop1">
                                    <div class="profile-dropdown position-relative" data-simplebar>
                                        <div class="py-3 px-7 pb-0">
                                            <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                        </div>
                                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                            <img src="{{ asset('dist/images/profile/' . auth()->user()->photo) }}"
                                                class="rounded-circle" width="80" height="80"
                                                alt="" />
                                            <div class="ms-3">
                                                <h5 class="mb-1 fs-3">{{ auth()->user()->name }}</h5>
                                                <span
                                                    class="mb-2 mt-2 d-block badge bg-light-info text-info">{{ auth()->user()->role }}</span>
                                                <p class="mb-0 d-flex text-dark align-items-center gap-2">
                                                    <i class="ti ti-mail fs-4"> </i> {{ auth()->user()->npk }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="message-body">
                                            <a href="page-user-profile.html"
                                                class="py-8 px-7 mt-8 d-flex align-items-center">
                                                <span
                                                    class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                                    <img src={{ asset('images/icon-account.svg') }} alt=""
                                                        width="24" height="24">
                                                </span>
                                                <div class="w-75 d-inline-block v-middle ps-3">
                                                    <h6 class="mb-1 bg-hover-primary fw-semibold"> My Profile </h6>
                                                    <span class="d-block text-dark">Account Settings</span>
                                                </div>
                                            </a>
                                        </div>
                                        <form action="{{ route('logout.auth') }}" method="post">
                                            @csrf
                                            @method('POST')
                                            <div class="d-grid py-4 px-7 pt-8">
                                                <button type="submit" class="btn btn-outline-primary">Log
                                                    Out</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <script>
            function updateShift() {
                var shiftElement = document.getElementById("shift");
                var currentDate = new Date();
                var currentHour = currentDate.getHours();
                var currentMinute = currentDate.getMinutes();
                var currentSecond = currentDate.getSeconds();

                // Define shifts with start and end times
                var shifts = [{
                        startHour: 6,
                        startMinute: 0,
                        endHour: 14,
                        endMinute: 10
                    }, // Shift 1
                    {
                        startHour: 14,
                        startMinute: 10,
                        endHour: 22,
                        endMinute: 10
                    }, // Shift 2
                    {
                        startHour: 22,
                        startMinute: 10,
                        endHour: 6,
                        endMinute: 0
                    } // Shift 3
                ];

                // Determine the current shift
                var shift;
                for (var i = 0; i < shifts.length; i++) {
                    var isShift = false;
                    var shiftStart = shifts[i].startHour * 60 + shifts[i].startMinute;
                    var shiftEnd = shifts[i].endHour * 60 + shifts[i].endMinute;
                    var currentTime = currentHour * 60 + currentMinute;

                    if (shifts[i].startHour <= shifts[i].endHour) {
                        // For shifts that don't cross midnight
                        isShift = currentTime >= shiftStart && currentTime < shiftEnd;
                    } else {
                        // For shifts that cross midnight (like Shift 3)
                        isShift = currentTime >= shiftStart || currentTime < shiftEnd;
                    }

                    if (isShift) {
                        shift = "Shift " + (i + 1);
                        break;
                    }
                }

                shift = shift || "Shift 1"; // Default to Shift 1 if no other shift is matched
                shiftElement.innerHTML = shift;
            }

            document.addEventListener("DOMContentLoaded", function() {
                updateShift();
                setInterval(updateShift, 1000);
            });
        </script>
        <!-- Header End -->

        <!-- Main wrapper -->
        <div class="body-wrapper">
            <div class="container-fluid mw-100 px-5">

                {{-- main content here --}}
                @yield('main')
                {{-- maion content --}}

            </div>
        </div>
        <div class="dark-transparent sidebartoggler"></div>
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
                            <a href="/dashboard">
                                <span class="fs-3 text-black fw-normal d-block">Main Dashboard</span>
                                <span class="fs-3 text-muted d-block">/dashboard</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="/lineDashboard">
                                <span class="fs-3 text-black fw-normal d-block">Line Dashboard</span>
                                <span class="fs-3 text-muted d-block">/lineDashboard</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="/employee/planning">
                                <span class="fs-3 text-black fw-normal d-block">Planning</span>
                                <span class="fs-3 text-muted d-block">/employee/planning</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="/history">
                                <span class="fs-3 text-black fw-normal d-block">Henkaten History</span>
                                <span class="fs-3 text-muted d-block">/history</span>
                            </a>
                        </li>
                        <li class="p-1 mb-1 bg-hover-light-black">
                            <a href="/employee">
                                <span class="fs-3 text-black fw-normal d-block">Employee</span>
                                <span class="fs-3 text-muted d-block">/employee</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Import Js Files -->
    {{-- <script src={{ asset('dist/js/datatable/datatable-basic.init.js') }}></script>
    <script src={{ asset('dist/libs/datatables.net/js/jquery.dataTables.min.js') }}></script> --}}
    <script src={{ asset('dist/libs/jquery/dist/jquery.min.js') }}></script>
    <script src={{ asset('dist/libs/jquery-ui/dist/jquery-ui.min.js') }}></script>
    <script src={{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}></script>
    <script src={{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}></script>
    <!--  core files -->
    <script src={{ asset('dist/js/app.min.js') }}></script>
    <script src={{ asset('dist/js/app.horizontal.init.js') }}></script>
    <script src={{ asset('dist/js/sidebarmenu.js') }}></script>
    <script src={{ asset('dist/js/custom.js') }}></script>
    <!--  current page js files -->
    <script src={{ asset('dist/js/dashboard.js') }}></script>
    <script src={{ asset('dist/js/plugins/toastr-init.js') }}></script>
    <script src={{ asset('dist/js/forms/select2.init.js') }}></script>
    <script src={{ asset('js/bootstrap4-toggle.min.js') }}></script>
    <script>
        $('#logout').on('click', function() {
            localStorage.removeItem('origin_id');
        });
    </script>
</body>

</html>
