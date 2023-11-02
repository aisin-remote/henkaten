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
            <li class="nav-item d-none d-xl-block">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <i class="ti ti-search"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav quick-links d-none d-xl-flex">
            <span class="badge bg-warning fw-bolder px-4 py-2">Shift 1</span>
        </ul>
        <div class="d-block d-xl-none">
            <a href="index.html" class="text-nowrap nav-link">
                <img src="{{ asset('assets/images/henkaten-logo.svg') }}" class="dark-logo" width="180"
                    alt="" />
            </a>
        </div>
        <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-bell-ringing"></i>
                            <div class="notification bg-primary rounded-circle"></div>
                        </a>
                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                            aria-labelledby="drop2">
                            <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                <span class="badge bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
                            </div>
                            <div class="message-body" data-simplebar>
                                <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                                    <span class="me-3">
                                        <img src="../../dist/images/profile/user-1.jpg" alt="user"
                                            class="rounded-circle" width="48" height="48" />
                                    </span>
                                    <div class="w-75 d-inline-block v-middle">
                                        <h6 class="mb-1 fw-semibold">Roman Joined the Team!</h6>
                                        <span class="d-block">Congratulate him</span>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                                    <span class="me-3">
                                        <img src="../../dist/images/profile/user-2.jpg" alt="user"
                                            class="rounded-circle" width="48" height="48" />
                                    </span>
                                    <div class="w-75 d-inline-block v-middle">
                                        <h6 class="mb-1 fw-semibold">New message</h6>
                                        <span class="d-block">Salma sent you new message</span>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                                    <span class="me-3">
                                        <img src="../../dist/images/profile/user-3.jpg" alt="user"
                                            class="rounded-circle" width="48" height="48" />
                                    </span>
                                    <div class="w-75 d-inline-block v-middle">
                                        <h6 class="mb-1 fw-semibold">Bianca sent payment</h6>
                                        <span class="d-block">Check your earnings</span>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                                    <span class="me-3">
                                        <img src="../../dist/images/profile/user-4.jpg" alt="user"
                                            class="rounded-circle" width="48" height="48" />
                                    </span>
                                    <div class="w-75 d-inline-block v-middle">
                                        <h6 class="mb-1 fw-semibold">Jolly completed tasks</h6>
                                        <span class="d-block">Assign her new tasks</span>
                                    </div>
                                </a>
                                <a href="javascript:void(0)"
                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                    <span class="me-3">
                                        <img src="../../dist/images/profile/user-5.jpg" alt="user"
                                            class="rounded-circle" width="48" height="48" />
                                    </span>
                                    <div class="w-75 d-inline-block v-middle">
                                        <h6 class="mb-1 fw-semibold">John received payment</h6>
                                        <span class="d-block">$230 deducted from account</span>
                                    </div>
                                </a>
                                <a href="javascript:void(0)"
                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                    <span class="me-3">
                                        <img src="../../dist/images/profile/user-1.jpg" alt="user"
                                            class="rounded-circle" width="48" height="48" />
                                    </span>
                                    <div class="w-75 d-inline-block v-middle">
                                        <h6 class="mb-1 fw-semibold">Roman Joined the Team!</h6>
                                        <span class="d-block">Congratulate him</span>
                                    </div>
                                </a>
                            </div>
                            <div class="py-6 px-7 mb-1">
                                <button class="btn btn-outline-primary w-100"> See All Notifications </button>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="user-profile-img">
                                    <img src="../../dist/images/profile/saiful.png" class="rounded-circle"
                                        width="35" height="35" alt="" />
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
                                    <img src="../../dist/images/profile/saiful.png" class="rounded-circle"
                                        width="80" height="80" alt="" />
                                    <div class="ms-3">
                                        <h5 class="mb-1 fs-3">{{ auth()->user()->name }}</h5>
                                        <span class="mb-2 mt-2 d-block badge bg-light-info text-info">Leader</span>
                                        <p class="mb-0 d-flex text-dark align-items-center gap-2">
                                            <i class="ti ti-mail fs-4"></i> {{ auth()->user()->npk }}
                                        </p>
                                    </div>
                                </div>
                                <div class="message-body">
                                    <a href="page-user-profile.html" class="py-8 px-7 mt-8 d-flex align-items-center">
                                        <span
                                            class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-account.svg"
                                                alt="" width="24" height="24">
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h6 class="mb-1 bg-hover-primary fw-semibold"> My Profile </h6>
                                            <span class="d-block text-dark">Account Settings</span>
                                        </div>
                                    </a>
                                    <a href="app-email.html" class="py-8 px-7 d-flex align-items-center">
                                        <span
                                            class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-inbox.svg"
                                                alt="" width="24" height="24">
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h6 class="mb-1 bg-hover-primary fw-semibold">My Inbox</h6>
                                            <span class="d-block text-dark">Messages & Emails</span>
                                        </div>
                                    </a>
                                    {{-- <a href="app-notes.html" class="py-8 px-7 d-flex align-items-center">
                                        <span
                                            class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-tasks.svg"
                                                alt="" width="24" height="24">
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h6 class="mb-1 bg-hover-primary fw-semibold">My Task</h6>
                                            <span class="d-block text-dark">To-do and Daily Tasks</span>
                                        </div>
                                    </a> --}}
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
