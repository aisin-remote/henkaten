<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar container-fluid mw-100" style="padding-left: 80px">
            <ul id="sidebarnav">
                <!-- ============================= -->
                <!-- Home -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <!-- =================== -->
                <!-- Dashboard -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="/dashboard" aria-expanded="false">
                        <span class="rounded-3">
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="/lineDashboard" aria-expanded="false">
                        <span class="rounded-3">
                            <i class="ti ti-article"></i>
                        </span>
                        <span class="hide-menu">Lines</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Icons</span>
                </li>
                <!-- =================== -->
                <!-- Tabler Icon -->
                <!-- =================== -->
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="/employee" aria-expanded="false">
                        <span class="rounded-3">
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Active Employee</span>
                    </a>
                </li> --}}
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="/employee/planning" aria-expanded="false">
                        <span class="rounded-3">
                            <i class="ti ti-calendar-time"></i>
                        </span>
                        <span class="hide-menu">Planning</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="/history" aria-expanded="false">
                        <span class="rounded-3">
                            <i class="ti ti-history"></i>
                        </span>
                        <span class="hide-menu">History</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/henkatenManagement" class="sidebar-link has-arrow" aria-expanded="false">
                        <span>
                            <i class="ti ti-box"></i>
                        </span>
                        <span class="hide-menu">Master</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="/henkatenManagement" class="sidebar-link">
                                <i class="ti ti-book"></i>
                                <span class="hide-menu">Henkaten Management</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/employee" class="sidebar-link">
                                <i class="ti ti-user"></i>
                                <span class="hide-menu">Employee</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/skill" class="sidebar-link">
                                <i class="ti ti-barbell"></i>
                                <span class="hide-menu">Skill</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/skill/minimum" class="sidebar-link">
                                <i class="ti ti-aperture"></i>
                                <span class="hide-menu">Minimum Skill</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/theme" class="sidebar-link">
                                <i class="ti ti-timeline-event-text"></i>
                                <span class="hide-menu">Theme</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <div class="fixed-profile p-3 bg-light-secondary rounded sidebar-ad mt-3 mx-9 d-block d-lg-none">
        <div class="hstack gap-3 justify-content-between">
            <div class="john-img">
                <img src="../../dist/images/profile/user-1.jpg" class="rounded-circle" width="42" height="42"
                    alt="">
            </div>
            <div class="john-title">
                <h6 class="mb-0 fs-4">John Doe</h6>
                <span class="fs-2">Designer</span>
            </div>
            <button class="border-0 bg-transparent text-primary ms-2" tabindex="0" type="button" aria-label="logout"
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                <i class="ti ti-power fs-6"></i>
            </button>
        </div>
    </div>
</aside>
