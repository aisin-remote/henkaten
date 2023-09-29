<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/horizontal/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Sep 2023 00:45:05 GMT -->

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
    <link rel="shortcut icon" type="image/png" href="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" />
    <!-- Owl Carousel -->
    <link rel="stylesheet" href={{ asset('dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}>
    <link rel="stylesheet" href={{ asset('dist/libs/select2/dist/css/select2.min.css') }}>
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href={{ asset('dist/css/style.min.css') }} />

    <style>
        .vertical-carousel {
            overflow: hidden;
            height: 500px;
            /* Sesuaikan tinggi carousel dengan kebutuhan Anda */
            position: relative;
        }

        .carousel-inner {
            display: flex;
            flex-direction: column;
            transition: transform 0.5s ease-in-out;
            height: 100%;
            /* Menyesuaikan tinggi carousel inner dengan tinggi carousel */
        }

        .carousel-item {
            /* width: 100%; */
            max-width: 100%;
            flex: 1;
            /* Mengisi tinggi yang tersedia dalam carousel */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="horizontal" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Header Start -->
        @include('layouts.partials.header')

        <!-- Header End -->
        <!-- Sidebar Start -->
        @include('layouts.partials.nav')

        <!-- Sidebar End -->
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
                                <span class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
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
                                <span class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
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
    <!-- Import Js Files -->
    <script src={{ asset('dist/libs/jquery/dist/jquery.min.js') }}></script>
    <script src={{ asset('dist/libs/jquery-ui/dist/jquery-ui.min.js') }}></script>
    <script src={{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}></script>
    <script src={{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}></script>
    <!--  core files -->
    <script src={{ asset('dist/js/app.min.js') }}></script>
    <script src={{ asset('dist/js/app.horizontal.init.js') }}></script>
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
        const carousel = document.querySelector('.vertical-carousel');
        const items = carousel.querySelectorAll('.col-md-12');
        let currentIndex = 0;

        function nextItem() {
            currentIndex = (currentIndex + 1) % items.length;
            updateCarousel();
        }

        function prevItem() {
            currentIndex = (currentIndex - 1 + items.length) % items.length;
            updateCarousel();
        }

        function updateCarousel() {
            const translateY = -currentIndex * 100;
            items.forEach((item, index) => {
                item.style.transform = `translateY(${translateY}%)`;
            });
        }

        // Trigger next item on click (you can add buttons for this)
        carousel.addEventListener('click', nextItem);

        // Optional: Auto-rotate the carousel
        setInterval(nextItem, 3000); // Uncomment this line to auto-rotate every 3 seconds
    </script>
</body>

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/horizontal/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Sep 2023 00:45:30 GMT -->

</html>